/**
 * Consentimento de cookies (ver inc/cookie-consent.php).
 *
 * Os conteúdos de terceiros chegam ao browser inativos:
 * - scripts com type="text/plain" e data-ama-consent="<serviço>";
 * - vídeos como marcadores .ama-embed com data-ama-consent="<serviço>".
 * Só são ativados quando o visitante dá consentimento para esse serviço.
 */
(function () {
    "use strict";

    var config = window.AMA_CONSENT || { cookie: "ama_consent", version: 1, maxAge: 15552000, services: {} };
    var serviceKeys = Object.keys(config.services);
    var MESSAGE_KEY = "ama_consent_message";

    var messages = {
        accept: "Aceitou todos os conteúdos de terceiros.",
        reject: "Rejeitou todos os conteúdos de terceiros.",
        save: "As suas escolhas foram guardadas."
    };
    var changeHint = " Pode alterar a sua escolha a qualquer momento em «Definições de cookies», no rodapé da página.";

    var banner, opener = null;

    function readConsent() {
        var match = document.cookie.match(new RegExp("(?:^|; )" + config.cookie + "=([^;]*)"));
        if (!match) {
            return null;
        }
        try {
            var value = JSON.parse(decodeURIComponent(match[1]));
            return value && value.v === config.version ? value : null;
        } catch (e) {
            return null;
        }
    }

    function writeConsent(choices) {
        var value = { v: config.version };
        serviceKeys.forEach(function (key) {
            value[key] = !!choices[key];
        });
        document.cookie = config.cookie + "=" + encodeURIComponent(JSON.stringify(value)) +
            "; max-age=" + config.maxAge + "; path=/; SameSite=Lax" +
            (location.protocol === "https:" ? "; Secure" : "");
        return value;
    }

    function allowed(consent, key) {
        return !!(consent && consent[key]);
    }

    /* Ativação dos conteúdos */

    function activateScripts(key) {
        document.querySelectorAll('script[type="text/plain"][data-ama-consent="' + key + '"]').forEach(function (blocked) {
            var script = document.createElement("script");
            Array.prototype.forEach.call(blocked.attributes, function (attribute) {
                if (["type", "data-ama-consent", "data-ama-src"].indexOf(attribute.name) === -1) {
                    script.setAttribute(attribute.name, attribute.value);
                }
            });
            script.src = blocked.getAttribute("data-ama-src");
            blocked.replaceWith(script);
        });
    }

    function loadEmbed(embed, moveFocus) {
        if (embed.classList.contains("is-loaded")) {
            return;
        }
        var iframe = document.createElement("iframe");
        iframe.src = embed.getAttribute("data-ama-embed-src");
        iframe.title = embed.getAttribute("data-ama-embed-title");
        iframe.className = "ama-embed__frame";
        iframe.setAttribute("allow", "accelerometer; encrypted-media; gyroscope; picture-in-picture; fullscreen");
        iframe.setAttribute("allowfullscreen", "");
        iframe.setAttribute("referrerpolicy", "strict-origin-when-cross-origin");
        iframe.setAttribute("loading", "lazy");

        embed.replaceChildren(iframe);
        embed.classList.add("is-loaded");

        if (moveFocus) {
            iframe.focus();
        }
    }

    function applyConsent(consent) {
        serviceKeys.forEach(function (key) {
            if (!allowed(consent, key)) {
                return;
            }
            activateScripts(key);
            document.querySelectorAll('.ama-embed[data-ama-consent="' + key + '"]').forEach(function (embed) {
                loadEmbed(embed, false);
            });
        });
    }

    function initEmbeds() {
        document.querySelectorAll(".ama-embed").forEach(function (embed) {
            var button = embed.querySelector(".ama-embed__load");
            if (!button) {
                return;
            }
            button.hidden = false;
            button.addEventListener("click", function () {
                loadEmbed(embed, true);
            });
        });
    }

    /* Aviso de cookies */

    function part(selector) {
        return banner.querySelector(selector);
    }

    function setSettingsOpen(open) {
        part("#ama-cookie-settings").hidden = !open;
        part('[data-ama-consent-action="save"]').hidden = !open;
        part('[data-ama-consent-action="customize"]').setAttribute("aria-expanded", open ? "true" : "false");
    }

    function fillCheckboxes(consent) {
        serviceKeys.forEach(function (key) {
            var checkbox = banner.querySelector('input[name="' + key + '"]');
            if (checkbox) {
                checkbox.checked = allowed(consent, key);
            }
        });
    }

    function showQuestion(withSettings) {
        fillCheckboxes(readConsent());
        part(".ama-cookie-banner__question").hidden = false;
        part(".ama-cookie-banner__confirmation").hidden = true;
        setSettingsOpen(withSettings);
        banner.hidden = false;
    }

    function showConfirmation(text) {
        part(".ama-cookie-banner__question").hidden = true;
        var confirmation = part(".ama-cookie-banner__confirmation");
        var message = confirmation.querySelector(".ama-cookie-banner__message");
        message.textContent = text + changeHint;
        confirmation.hidden = false;
        banner.hidden = false;
        message.focus();
    }

    function hideBanner() {
        banner.hidden = true;
        if (opener && document.body.contains(opener)) {
            opener.focus();
        }
        opener = null;
    }

    function decide(action) {
        var previous = readConsent();
        var choices = {};

        serviceKeys.forEach(function (key) {
            if (action === "accept") {
                choices[key] = true;
            } else if (action === "save") {
                var checkbox = banner.querySelector('input[name="' + key + '"]');
                choices[key] = !!(checkbox && checkbox.checked);
            } else {
                choices[key] = false;
            }
        });

        var consent = writeConsent(choices);

        // Um conteúdo já carregado não pode ser descarregado: recarrega-se a página.
        var revoked = serviceKeys.some(function (key) {
            return allowed(previous, key) && !allowed(consent, key);
        });
        if (revoked) {
            try {
                sessionStorage.setItem(MESSAGE_KEY, action);
            } catch (e) {}
            location.reload();
            return;
        }

        applyConsent(consent);
        showConfirmation(messages[action]);
    }

    function initBanner() {
        banner = document.getElementById("ama-cookie-banner");
        if (!banner) {
            return;
        }

        banner.addEventListener("click", function (event) {
            var button = event.target.closest("[data-ama-consent-action]");
            if (!button) {
                return;
            }
            var action = button.getAttribute("data-ama-consent-action");
            if (action === "customize") {
                setSettingsOpen(part("#ama-cookie-settings").hidden);
            } else if (action === "hide") {
                hideBanner();
            } else {
                decide(action);
            }
        });

        // Botões "Definições de cookies" (rodapé, página de cookies, vídeos).
        document.addEventListener("click", function (event) {
            var button = event.target.closest('[data-ama-consent-action="open"]');
            if (!button) {
                return;
            }
            opener = button;
            showQuestion(true);
            part("#ama-cookie-banner-title").focus();
            banner.scrollIntoView({ block: "start" });
        });

        var pendingMessage = null;
        try {
            pendingMessage = sessionStorage.getItem(MESSAGE_KEY);
            sessionStorage.removeItem(MESSAGE_KEY);
        } catch (e) {}

        if (pendingMessage && messages[pendingMessage]) {
            showConfirmation(messages[pendingMessage]);
            return;
        }

        var needsBanner = serviceKeys.some(function (key) {
            return config.services[key].autoload;
        });
        if (needsBanner && !readConsent()) {
            showQuestion(false);
        }
    }

    function init() {
        initEmbeds();
        initBanner();
        applyConsent(readConsent());
    }

    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", init);
    } else {
        init();
    }
})();

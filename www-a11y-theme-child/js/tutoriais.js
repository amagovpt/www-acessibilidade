/**
 * Tutoriais (inc/tutoriais.php): marca com aria-current="location" o link dos
 * "Links de acesso rápido" que corresponde à secção aberta e colore o código.
 */
(function () {
    "use strict";

    function markCurrent() {
        var hash = decodeURIComponent(location.hash.slice(1));

        document.querySelectorAll(".tutorial-toc a[href^='#']").forEach(function (link) {
            if (hash && link.getAttribute("href").slice(1) === hash) {
                link.setAttribute("aria-current", "location");
            } else {
                link.removeAttribute("aria-current");
            }
        });
    }

    window.addEventListener("hashchange", markCurrent);
    markCurrent();

    /**
     * Código colorido com o Prism (js/prism.min.js). Os blocos de código do editor não
     * indicam a linguagem: começa por "<" é HTML, tem "propriedade: valor;" dentro de
     * chavetas é CSS, o resto é JavaScript.
     */
    function language(text) {
        text = text.trim();
        if (text.charAt(0) === "<") {
            return "markup";
        }
        if (/^[^{}()=;]+\{[^}]*:[^}]*;?[^}]*\}/m.test(text) && !/\b(function|const|let|var)\b|=>/.test(text)) {
            return "css";
        }
        return "javascript";
    }

    var blocks = document.querySelectorAll(".tutorial-content pre");

    blocks.forEach(function (pre) {
        var code = pre.querySelector("code") || pre;

        if (window.Prism && !/\blang(uage)?-/.test(code.className)) {
            code.classList.add("language-" + language(code.textContent));
            window.Prism.highlightElement(code);
        }
    });

    // Blocos com deslocamento horizontal têm de ser acessíveis pelo teclado.
    function markScrollable() {
        blocks.forEach(function (pre) {
            if (pre.scrollWidth > pre.clientWidth) {
                pre.setAttribute("tabindex", "0");
            } else {
                pre.removeAttribute("tabindex");
            }
        });
    }

    window.addEventListener("load", markScrollable);
    window.addEventListener("resize", markScrollable);
})();

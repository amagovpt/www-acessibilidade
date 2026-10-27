/**
 * Tutoriais (inc/tutoriais.php): marca com aria-current="location" o link dos
 * "Links de acesso rápido" que corresponde à secção aberta.
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
})();

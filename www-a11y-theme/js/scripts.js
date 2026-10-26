document.addEventListener("DOMContentLoaded", () => {
  const openMobileMenuBtn = document.querySelector(".open-mobile-menu");
  const closeMobileMenuBtn = document.querySelector(".close-mobile-menu");
  const mobileOverlay = document.querySelector(".mobile-overlay");

  if (openMobileMenuBtn) {
    openMobileMenuBtn.addEventListener("click", () => {
      mobileOverlay.style.visibility = "visible";
      document.body.classList.add("no-scroll");
    });
    closeMobileMenuBtn.addEventListener("click", () => {
      mobileOverlay.style.visibility = "hidden";
      document.body.classList.remove("no-scroll");
    });
  }

  const darkMode = localStorage.getItem("darkMode");
  const darkModeBtn = document.getElementById("darkModeBtn");
  const darkModeLabel = document.getElementById("darkModeLabel");

  if (darkMode === "true") {
    if (!document.body.classList.contains("dark-theme")) {
      document.body.classList.toggle("dark-theme");
      darkModeLabel.innerHTML = "Modo Claro";
    }
  }

  if (darkModeBtn) {
    darkModeBtn.addEventListener(
      "click",
      () => {
        document.body.classList.toggle("dark-theme");
        if (document.body.classList.contains("dark-theme")) {
          darkModeLabel.innerHTML = "Modo Claro";
          localStorage.setItem("darkMode", true);
        } else {
          darkModeLabel.innerHTML = "Modo Escuro";
          localStorage.setItem("darkMode", false);
        }
      },
      false
    );
  }

  //FACEBOOK
  jQuery("#fb-icon span").mouseover(() => {
    document
      .querySelector("#fb-icon span")
      .classList.remove("icon-share-facebook");
    document
      .querySelector("#fb-icon span")
      .classList.add("icon-share-facebook-over");
  });

  jQuery("#fb-icon span").mouseout(() => {
    document
      .querySelector("#fb-icon span")
      .classList.add("icon-share-facebook");
    document
      .querySelector("#fb-icon span")
      .classList.remove("icon-share-facebook-over");
  });

  //TWITTER
  jQuery("#tw-icon span").mouseover(() => {
    document
      .querySelector("#tw-icon span")
      .classList.remove("icon-share-twitter");
    document
      .querySelector("#tw-icon span")
      .classList.add("icon-share-twitter-over");
  });

  jQuery("#tw-icon span").mouseout(() => {
    document.querySelector("#tw-icon span").classList.add("icon-share-twitter");
    document
      .querySelector("#tw-icon span")
      .classList.remove("icon-share-twitter-over");
  });

  //LINKEDIN
  jQuery("#ld-icon span").mouseover(() => {
    document
      .querySelector("#ld-icon span")
      .classList.remove("icon-share-linkedin");
    document
      .querySelector("#ld-icon span")
      .classList.add("icon-share-linkedin-over");
  });

  jQuery("#ld-icon span").mouseout(() => {
    document
      .querySelector("#ld-icon span")
      .classList.add("icon-share-linkedin");
    document
      .querySelector("#ld-icon span")
      .classList.remove("icon-share-linkedin-over");
  });

  //FACEBOOK
  jQuery("#fb-icon").click((e) => {
    e.preventDefault();
    var local = window.location.href;
    var url = "https://www.facebook.com/sharer/sharer.php?u=" + local;
    window.open(url, "_blank");
  });
  //TWITTER
  jQuery("#tw-icon").click((e) => {
    e.preventDefault();
    var local = window.location.href;
    var url = "https://twitter.com/intent/tweet?url=" + local;
    window.open(url, "_blank");
  });
  //LINKEDIN
  jQuery("#ld-icon").click((e) => {
    e.preventDefault();
    var local = window.location.href;
    var url = "https://www.linkedin.com/shareArticle?mini=true&url=" + local;
    window.open(url, "_blank");
  });

  //CF7
  jQuery("input[name=terms-conditions]").on("change", (e) => {
    if (jQuery(e.currentTarget).is(":checked")) {
      jQuery(".checkmark span").addClass("checked");
      jQuery(this).attr("style", "border: 2px solid #333399 !important");
      jQuery(".checkmark").attr("style", "background-color: white");
      jQuery("#terms_required").css("visibility", "hidden");
      jQuery("#terms_required").text("");
    } else {
      jQuery(".checkmark span").removeClass("checked");
      jQuery(".checkmark").attr("style", "background-color: #eaeaea");
    }
  });

  // Formidable Forms
  jQuery(document).ready(function () {
    if (jQuery(".frm_forms").length > 0) {
      // Remove the style attribute from all select elements within the Formidable form
      jQuery(".frm_forms select").removeAttr("style");
    }
  });

  // Focus on flushHeading
  jQuery(document).ready(() => {
    const flushHeadingBtn = document.getElementById("flushHeading");
    const flushEcossistema = document.getElementById("flushEcossistema");

    flushHeadingBtn.addEventListener("keydown", (event) => {
      if (
        event.key === "Enter" &&
        !flushEcossistema.classList.contains("show")
      ) {
        flushEcossistema.focus();
        flushEcossistema.addEventListener("focusin", (event) => {
          const firstFocusable = event.target; // Target of the focusin event
          if (
            firstFocusable &&
            firstFocusable.matches(
              'a[href], button, textarea, input:not([type="hidden"]), select, details summary'
            )
          ) {
            firstFocusable.focus(); // Only focus if it's a focusable element
          }
          flushEcossistema.removeEventListener("focusin", arguments.callee); // Remove listener after use
        });
      }
    });
  });

  // Formidable Forms focus on error
  function attachErrorClickListener() {
    document
      .querySelectorAll(".error-message")
      .forEach(function (errorMessage) {
        errorMessage.addEventListener("click", function () {
          let fieldId = this.getAttribute("data-field-id");
          let field = document.getElementById(fieldId);
          if (field) {
            field.focus();
          }
        });
      });
  }

  /**
   * Remove the fieldset that includes all the form fields inside.
   */
  function removeFieldset() {
    let forms = document.querySelectorAll(".frm_form_fields");
    forms.forEach(function (form) {
      let fieldset = form.querySelector(":scope > fieldset");
      if (fieldset) {
        while (fieldset.firstChild) {
          form.insertBefore(fieldset.firstChild, fieldset);
        }
        fieldset.remove();
      }
    });
  }

  removeFieldset();

  // Attach the listener initially
  attachErrorClickListener();

  // Reattach the listener after each AJAX request
  jQuery(document).ajaxComplete(function () {
    attachErrorClickListener();
  });

  // Toggle ícone de pesquisa (Pesquisar ↔ Fechar)
  var searchToggleBtn = jQuery("#searchDropdown");
  var searchIcon = searchToggleBtn.find(".icon");

  searchToggleBtn.on("shown.bs.dropdown", function () {
    searchIcon.removeClass("icon-search").addClass("icon-close-round");

    // Aguarda o dropdown aparecer antes de focar
    setTimeout(function () {
      jQuery("#search-input, #search-field").first().focus();
    }, 50); // Pequeno delay para garantir renderização
  });

  searchToggleBtn.on("hidden.bs.dropdown", function () {
    searchIcon.removeClass("icon-close-round").addClass("icon-search");
  });

  // Impede que o clique na label feche o dropdown
  jQuery("label[for='search-input']").on("click", function (e) {
    e.stopPropagation();
  });

  // Fix accessibility: Add title to dynamically created virtualbrain iframe and alt to images
  function addAccessibilityAttributesToVirtualbrain() {
    let hasChanges = false;
    
    // Fix iframe title
    const iframe = document.getElementById('virtualbrain-iframe');
    if (iframe && !iframe.hasAttribute('title')) {
      iframe.setAttribute('title', 'Assistente Virtual de Acessibilidade');
      hasChanges = true;
    }
    
    // Fix image alt attribute for virtualbrain images - using multiple selectors
    const selectors = [
      'img[src*="virtualbrain-public-files.s3.eu-west-3.amazonaws.com"]',
      'img[src*="virtualbrain"]',
      'img[src*="amazonaws.com"]',
      '.frame-root img',
      '.frame-content img',
      'div[class*="frame"] img'
    ];
    
    selectors.forEach(selector => {
      const images = document.querySelectorAll(selector);
      images.forEach(img => {
        if (!img.hasAttribute('alt')) {
          img.setAttribute('alt', '');
          hasChanges = true;
        }
      });
    });
    
    // Also check for any images without alt in frame-related containers
    const frameContainers = document.querySelectorAll('.frame-root, .frame-content, [class*="frame"]');
    frameContainers.forEach(container => {
      const images = container.querySelectorAll('img:not([alt])');
      images.forEach(img => {
        img.setAttribute('alt', '');
        hasChanges = true;
      });
    });
    
    // Check inside iframe content (if accessible)
    if (iframe) {
      try {
        const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
        if (iframeDoc) {
          const frameImages = iframeDoc.querySelectorAll('img:not([alt])');
          frameImages.forEach(img => {
            img.setAttribute('alt', '');
            hasChanges = true;
          });
        }
      } catch (e) {
        // Cross-origin iframe, can't access content
      }
    }
    
    // Specific check for the exact image structure: body > div > div > div > img
    const bodyDivImages = document.querySelectorAll('body > div > div > div > img:not([alt])');
    bodyDivImages.forEach(img => {
      // Only target virtualbrain images to avoid affecting other images
      if (img.src && (img.src.includes('virtualbrain') || img.src.includes('amazonaws.com'))) {
        img.setAttribute('alt', '');
        hasChanges = true;
      }
    });
    
    // Fallback: Check ALL images without alt and fix virtualbrain ones
    const allImagesWithoutAlt = document.querySelectorAll('img:not([alt])');
    allImagesWithoutAlt.forEach(img => {
      if (img.src && (img.src.includes('virtualbrain') || img.src.includes('amazonaws.com'))) {
        img.setAttribute('alt', '');
        hasChanges = true;
      }
    });
    
    return hasChanges || (iframe && iframe.hasAttribute('title'));
  }

  // Check for iframe and images immediately and then periodically
  addAccessibilityAttributesToVirtualbrain();
  
  // Set up a MutationObserver to watch for the iframe and images being added to the DOM
  const observer = new MutationObserver(function(mutations) {
    mutations.forEach(function(mutation) {
      if (mutation.type === 'childList') {
        addAccessibilityAttributesToVirtualbrain();
      }
    });
  });
  
  // Start observing
  observer.observe(document.body, {
    childList: true,
    subtree: true
  });
  
  // Also check periodically as a fallback
  const intervalId = setInterval(() => {
    if (addAccessibilityAttributesToVirtualbrain()) {
      clearInterval(intervalId);
    }
  }, 1000);
  
  // Clear interval after 30 seconds to avoid indefinite checking
  setTimeout(() => {
    clearInterval(intervalId);
  }, 30000);
});

/*
 * Gerador da Declaração: separadores (passos) e botão do menu em ecrãs pequenos.
 * Vem de gerador/js/index_gerador.js (amagovpt/a11y-da), só a parte "Script Tabs".
 * A outra parte desse ficheiro tratava do cabeçalho e rodapé antigos, que agora são os do tema.
 */
function menugerador() {
  var tabs = document.getElementById("tab-menu");
  var botao = document.getElementById("menugerador");
  tabs.classList.toggle("aberto");
  if (botao) {
    botao.setAttribute("aria-expanded", window.getComputedStyle(tabs).display === "none" ? "false" : "true");
  }
}

// Em ecrãs pequenos o menu começa fechado (CSS); o aria-expanded tem de corresponder.
(function () {
  var tabs = document.getElementById("tab-menu");
  var botao = document.getElementById("menugerador");
  if (!tabs || !botao) {
    return;
  }
  var acertar = function () {
    botao.setAttribute("aria-expanded", window.getComputedStyle(tabs).display === "none" ? "false" : "true");
  };
  acertar();
  window.addEventListener("resize", acertar);
}());

//  <!--################################################################################################################ Script Tabs -->


// tabs https://www.w3.org/TR/wai-aria-practices/examples/tabs/tabs-1/tabs.html
/*
*   This content is licensed according to the W3C Software License at
*   https://www.w3.org/Consortium/Legal/2015/copyright-software-and-document
*/
(function () {
    var tablist = document.querySelectorAll('[role="tablist"]')[0];
    var tabs;
    var panels;
    var paginador;

    generateArrays();

    function generateArrays () {
        tabs = document.querySelectorAll('[role="tab"]');
        panels = document.querySelectorAll('[role="tabpanel"]');
        paginador = document.querySelectorAll('[role="button"]'); 

    };


    // Bind listeners
    for (i = 0; i < tabs.length; ++i) {
        addListenersTabs(i);
    };
    for (i = 0; i < paginador.length; ++i) {
        addListenersButtons(i);
    };

    function addListenersTabs (index) {
        $(tabs[index]).parents('li')[0].addEventListener('click', clickEventListener);
        //tabs[index].addEventListener('click', clickEventListener);
        tabs[index].index = index;
    };

    function addListenersButtons (index) {
        paginador[index].addEventListener('click', clickEventListener);
        paginador[index].index = index;
    };

    // When a tab is clicked, activateTab is fired to activate it
    function clickEventListener (event) {       
	

        if($(this).is('a')){
			//botões
            controls = this.getAttribute('aria-controls');
            var tab = $('#tab-menu').find('[aria-controls="'+controls+'"]')[0];
            console.log(tab);
        }
        else{
			
			//menu lateral
			var tabURL = this.children[0].children[0];
            var tab = this.children[0];
			location.href = tabURL
        }

       activateTab(tab, false);
      
    };

    // Activates any given tab panel
    function activateTab (tab, setFocus) {
        setFocus = setFocus || true;
        // Deactivate all other tabs
        deactivateTabs();


        // Get the value of aria-controls (which is an ID)
        var controls = tab.getAttribute('aria-controls');
		
        // Set the tab as selected
        tab = $('#tab-menu').find('[aria-controls="'+controls+'"]');
        tab.parents('li').addClass('selected');
		tab[0].setAttribute('aria-selected', 'true');

         // Remove tabindex attribute
        tab[0].removeAttribute('tabindex');

       

        // Remove hidden attribute from tab panel to make it visible
        document.getElementById(controls).removeAttribute('hidden');

        // Set focus when required
        if (setFocus) {
            tab[0].focus();
        };
    };

    // Deactivate all tabs and tab panels
    function deactivateTabs () {
        for (t = 0; t < tabs.length; t++) {
            tabs[t].setAttribute('tabindex', '-1');
            tabs[t].setAttribute('aria-selected', 'false');
			//tabs[t].parentElement.parentElement.removeAttribute('class', 'selected');   // adicionado paulo
            tabs[t].parentElement.removeAttribute('class', 'selected');   // adicionado paulo
            // tabs[t].removeEventListener('focus', focusEventHandler);
        };

        for (p = 0; p < panels.length; p++) {
            panels[p].setAttribute('hidden', 'hidden');
        };
    };

}());

//  <!--################################################################################################################ Fim Script Tabs -->
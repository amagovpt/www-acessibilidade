<?php

/**
 * Shortcode para adicionar o accessmonitor no footer. É uma ligação que dispara logo o validador de acessibilidade
 * para a URL que o utilizador inserir no formulário.
 *
 * @return string|null
 */
function accessmonitor_home_cb(): ?string {
    ob_start(); ?>
    <section id="access" class="d-block">
        <div class="container">
            <div class="p-3">
                <div class="col-12 my-3">
                    <div class="col-12 d-flex d-sm-none align-items-center justify-content-end">
                        <span class="version">versão 2.1</span>
                    </div>
                    <div class="d-flex justify-content no-gutters">
                        <div class="py-2 d-flex align-items-center" style="gap: .5rem">
                            <div class="icon-check-monitor icon" aria-hidden="true"></div>
                            <h2><a href="https://accessmonitor.acessibilidade.gov.pt/" target="_blank" rel="noopener">access<strong>Monitor</strong> <span class="visually-hidden">hiperligação externa</span></a></h2>
                        </div>
                        <div class="p-2 d-sm-flex d-none align-items-center"><span class="version">versão 2.1</span></div>
                    </div>
                        <p id="access_description">O validador de práticas de acessibilidade web (WCAG 2.1)</p>
                        <p style="padding: 0.5em"><span aria-label="consulte também" role="img" style="margin-right: 0.2em; font-size: 1rem; line-height: 1;">🔗</span><a href="https://chromewebstore.google.com/detail/accessmonitor-extension/knjdoonhhnjfmigigfgoehhihodndaii?hl=pt-PT&amp;utm_source=ext_sidebar">Extensão para Chrome</a> | <a href="https://amagovpt.github.io/accessmonitor-rulesets/">Testes AccessMonitor</a>.</p>
                </div>
                <form id="accessmonitor" class="w-100 needs-validation" novalidate>
                    <label id="url_label" for="uri">Introduza o endereço de uma página:</label>
                    
                    <div class="input-group">
                        <input id="uri" class="form-control mb-0" title="Endereço da página" name="uri" pattern="https?://.+" required="" size="20" type="text" value="" placeholder="http://">
                        <p><span class="ama invalid-feedback">
                            Introduza um url válido. Ex.: http://www.google.pt
                        </span>
                        </p> 
                    </div>
                    <button class="ama btn btn-primary btn_access" type="submit">Validar</button>
                </form>
            </div>
        </div>
    </section>
    <?php

    return ob_get_clean();
}

add_shortcode('accessmonitor_home', 'accessmonitor_home_cb');
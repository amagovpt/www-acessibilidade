<?php

/**
 * Shortcode para adicionar o accessmonitor no footer. É uma ligação que dispara logo o validador de acessibilidade
 * para a URL que o utilizador inserir no formulário.
 *
 * @return string|null
 */
function accessmonitor_wide_cb(): ?string {
    ob_start(); ?>
    <section id="access" class="d-block">
        <div class="container">
            <div class="row pt-3">
                <div class="col-lg-6 col-12 my-3">
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
                        <span id="access_description">O validador de práticas de acessibilidade web (WCAG 2.1)</span>
                </div>
                <div class="col-lg-6 col-12 my-3">
                    <form id="accessmonitor" class="w-100 needs-validation" novalidate>
                        <div class="container-fluid px-0">
                            <div class="row">
                                <div class="col-lg-8 col-md-6 col-sm-8 col-12">
                                    <label id="url_label" for="uri">Introduza o endereço de uma página:</label>
                                    <div class="input-group">
                                        <input id="uri" class="form-control mb-0" title="Endereço da página" name="uri" pattern="https?://.+" required="" size="20" type="text" value="" placeholder="http://">
                                        <p><span class="ama invalid-feedback">
                                            Introduza um url válido. Ex.: http://www.google.pt
                                        </span></p>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-4 col-12 --d-flex --flex-column --justify-content-end">
                                    <button class="ama btn btn-primary" type="submit">Validar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <?php

    return ob_get_clean();
}

add_shortcode('accessmonitor_wide', 'accessmonitor_wide_cb');
<?php

function validador_accessmonitor_cb(): string
{
    ob_start(); ?>
    <div id="infos_right" class="p-2">
        <div class="access_monitor">
            <div class="d-flex justify-content-start align-items-center no-gutters access_top">
                <div class="d-flex">
                    <div class="icon-check-monitor" aria-hidden="true">&nbsp;</div>
                    <h3><a href="https://accessmonitor.acessibilidade.gov.pt/" target="_blank"
                           rel="noopener noreferrer">access<strong>Monitor</strong> <span
                                class="visually-hidden">hiperligação externa</span></a></h3>
                </div>
                <div class="d-flex version_badge"><span class="version">versão 2.1</span></div>
            </div>
            <form id="accessmonitor" class="row no-gutters" onsubmit="return submitForm();">
                <div class="col-12">
                    <p id="access_description">O validador de práticas de acessibilidade web (WCAG 2.1)</p>
                </div>
                <div class="col-lg-12 col-md-6 col-sm-12">
                    <label id="url_label" for="uri">Introduza o endereço de uma página:</label>
                    <div class="input-group has-validation">
                        <input id="uri" class="form-control mr-sm-2" title="Endereço da página" name="uri" pattern="https?://.+" required="" size="20" type="text" value="" placeholder="http://">
                        <div class="invalid-feedback">
                            Introduza um url válido. Ex.: http://www.google.pt
                        </div>
                    </div>
                    <!--<p><span class="access_error d-none">Introduza um url válido. Ex.: http://www.google.pt</span></p>-->
                    <div id="div_btn_access" class="col-lg-12 col-md-6 col-sm-12">
                        <button class="ama btn btn-primary btn_access" type="submit">
                            Validar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php return ob_get_clean();
}
add_shortcode("validador_accessmonitor", "validador_accessmonitor_cb");
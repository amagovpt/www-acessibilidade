<?php

function partilhar_redes_sociais_cb($attrs): ?string {

    $attrs = shortcode_atts(
        [
            'tag_titulo' => 'h2',
        ],
        $attrs,
        'partilhar-redes-sociais'
    );

    ob_start();
    ?>
    <div class="share-post">
        <<?= esc_html($attrs['tag_titulo']) ?>>Partilhar</<?= esc_html($attrs['tag_titulo']) ?>>
        <ul class="d-flex list-inline mb-0">
            <li>
                <button id="fb-icon" type="button" aria-label="Partilhar no Facebook">
                    <span class="icon-share-facebook" aria-hidden="true"></span>
                </button>
            </li>
            <li>
                <button id="tw-icon" type="button" aria-label="Partilhar no Twitter">
                    <span class="icon-share-twitter" aria-hidden="true"></span>
                </button>
            </li>
            <li>
                <button id="ld-icon" type="button" aria-label="Partilhar no Linkedin">
                    <span class="icon-share-linkedin" aria-hidden="true"></span>
                </button>
            </li>
        </ul>
    </div>
    <?php
    return ob_get_clean();
}

add_shortcode('partilhar-redes-sociais', 'partilhar_redes_sociais_cb');
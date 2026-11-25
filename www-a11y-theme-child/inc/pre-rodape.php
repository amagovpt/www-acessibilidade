<?php
/**
 * Área de widgets "Pré-rodapé" (issue #66).
 *
 * O call to action do accessMonitor, que estava escrito diretamente nos templates
 * ([accessmonitor_wide]), passa a ser um widget desta área, editável em
 * Aspeto > Widgets. Os templates chamam ama_pre_rodape() no fim do <main>.
 */

defined('ABSPATH') || exit;

function ama_pre_rodape_registar(): void
{
    register_sidebar([
        'name'          => 'Pré-rodapé',
        'id'            => 'pre-rodape',
        'description'   => 'Aparece antes do rodapé nas páginas, artigos, tutoriais e publicações. Por omissão tem o accessMonitor (bloco Shortcode com [accessmonitor_wide]).',
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '<h2 class="visually-hidden">',
        'after_title'   => '</h2>',
    ]);
}
add_action('widgets_init', 'ama_pre_rodape_registar');

// O bloco Shortcode passa o texto por wpautop(), que punha a <section> do accessMonitor
// dentro de um <p>. Nos widgets, tira o <p> à volta de shortcodes sozinhos numa linha
// (entre do_blocks, prioridade 9, e do_shortcode, prioridade 11).
add_filter('widget_block_content', 'shortcode_unautop', 10);

/**
 * Mostra a área "Pré-rodapé" (nada, se não tiver widgets).
 */
function ama_pre_rodape(string $classes = ''): void
{
    if (!is_active_sidebar('pre-rodape')) {
        return;
    }

    printf('<div class="container-fluid p-0 pre-rodape%s"><div class="row g-0"><div class="col">', $classes !== '' ? ' ' . esc_attr($classes) : '');
    dynamic_sidebar('pre-rodape');
    echo '</div></div></div>';
}

/**
 * Na primeira vez (depois de instalar esta versão), põe o accessMonitor na área
 * "Pré-rodapé", para o site ficar igual sem passos manuais. Corre uma só vez:
 * depois disso, o que estiver em Aspeto > Widgets é respeitado (mesmo vazio).
 */
function ama_pre_rodape_widget_inicial(): void
{
    if (get_option('ama_pre_rodape_inicial')) {
        return;
    }

    $sidebars = get_option('sidebars_widgets', []);
    if (!is_array($sidebars)) {
        $sidebars = [];
    }

    if (empty($sidebars['pre-rodape'])) {
        $blocks  = get_option('widget_block', []);
        $blocks  = is_array($blocks) ? $blocks : [];
        $numbers = array_filter(array_keys($blocks), 'is_int');
        $number  = $numbers ? max($numbers) + 1 : 1;

        $blocks[$number]        = ['content' => "<!-- wp:shortcode -->\n[accessmonitor_wide]\n<!-- /wp:shortcode -->"];
        $blocks['_multiwidget'] = 1;
        update_option('widget_block', $blocks);

        $sidebars['pre-rodape'] = ['block-' . $number];
        update_option('sidebars_widgets', $sidebars);
    }

    update_option('ama_pre_rodape_inicial', '1');
}
add_action('wp_loaded', 'ama_pre_rodape_widget_inicial');

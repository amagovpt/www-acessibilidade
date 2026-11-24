<?php
/**
 * [get_tools_home total="6"]: ferramentas na página de início (issue #63).
 *
 * Ordem: primeiro as ferramentas com o campo "Destaque" = Sim e, a seguir, as mais
 * recentes. Lista em duas colunas, seguida da ligação "Todas as ferramentas".
 */
function get_tools_home($attrs = []): string
{
    $attrs = shortcode_atts(['total' => 6], $attrs, 'get_tools_home');
    $total = max(1, absint($attrs['total']));

    if (!function_exists('pods')) {
        return '';
    }

    $tools = pods('ferramentas', [
        'limit'       => $total,
        'orderby'     => 'destaque.meta_value DESC, post_date DESC',
        'post_status' => 'publish',
    ]);
    if (!$tools || !$tools->total()) {
        return '';
    }

    $output = '';
    while ($tools->fetch()) {
        $external = (string) get_post_meta($tools->id(), 'link_externo', true) === '1';

        $output .= sprintf(
            '<li><a href="%s"%s>%s%s</a></li>',
            esc_url($tools->display('link')),
            $external ? ' target="_blank" rel="noopener"' : '',
            esc_html(wp_specialchars_decode($tools->display('post_title'), ENT_QUOTES)),
            $external ? '<span class="visually-hidden"> hiperligação externa</span>' : ''
        );
    }

    $page = get_page_by_path('ferramentas');

    return ama_lista_homepage($output, $page ? get_permalink($page) : '', 'Todas as ferramentas');
}
add_shortcode('get_tools_home', 'get_tools_home');

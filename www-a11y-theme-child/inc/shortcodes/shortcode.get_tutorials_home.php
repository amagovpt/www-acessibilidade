<?php
/**
 * [get_tutorials_home total="6"]: tutoriais na página de início (issue #63).
 *
 * Usa os mesmos tutoriais da página agregadora "Tutoriais" (páginas filhas diretas de
 * "Tutoriais" e os antigos do tipo "tutorial"), pela mesma ordem dos cartões em destaque:
 * primeiro os marcados como destaque e, a seguir, os mais recentes.
 * Lista em duas colunas, seguida da ligação "Todos os tutoriais".
 */
function get_tutorials_home($attrs = []): string
{
    $attrs = shortcode_atts(['total' => 6], $attrs, 'get_tutorials_home');
    $total = max(1, absint($attrs['total']));

    if (!function_exists('ama_tutoriais_items')) {
        return '';
    }

    $items = ama_tutoriais_items();
    if (!$items) {
        return '';
    }

    usort($items, static fn(array $a, array $b): int => [$b['destaque'], $b['date']] <=> [$a['destaque'], $a['date']]);

    $output = '';
    foreach (array_slice($items, 0, $total) as $item) {
        $output .= sprintf('<li><a href="%s">%s</a></li>', esc_url($item['url']), $item['title']);
    }

    $root_id = ama_tutoriais_root_id();

    return ama_lista_homepage($output, $root_id ? get_permalink($root_id) : '', 'Todos os tutoriais');
}
add_shortcode('get_tutorials_home', 'get_tutorials_home');

/**
 * Lista da página de início em duas colunas (a partir de 768px), com a ligação
 * para a página da secção por baixo.
 */
function ama_lista_homepage(string $items, string $url, string $label): string
{
    $html = '<ul class="ama-list lista-homepage colunas-1 colunas-md-2">' . $items . '</ul>';

    if ($url !== '') {
        $html .= sprintf('<p class="mt-4 mb-0"><a class="ama btn btn-primary" href="%s">%s</a></p>', esc_url($url), esc_html($label));
    }

    return $html;
}

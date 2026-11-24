<?php
/**
 * [get_artigos_destaque_homepage]: carrossel "Em destaque" da página de início, com os
 * artigos fixos (sticky) publicados, até 4.
 *
 * Cada slide pode ter uma imagem (issue #64), escolhida no campo "Imagem no destaque da
 * página de início" do artigo. Com imagem: texto 66% | imagem 33%; sem imagem, o texto
 * ocupa a largura toda.
 */
function get_artigos_destaque_homepage(): string
{
    $sticky = array_filter(array_map('absint', (array) get_option('sticky_posts')));
    if (!$sticky) {
        return '';
    }

    // get_posts() e não query_posts(), que substituía a consulta principal da página.
    $stickies = get_posts([
        'post__in'            => $sticky,
        'posts_per_page'      => 4,
        'post_status'         => 'publish',
        'orderby'             => 'date',
        'order'               => 'DESC',
        'ignore_sticky_posts' => true,
    ]);
    if (!$stickies) {
        return '';
    }

    $home  = home_url();
    $count = count($stickies);

    $output = '<div id="carousel_highlights_articles" class="carousel" data-ride="carousel" data-interval="false">';

    if ($count > 1) {
        $output .= '<ol class="carousel-indicators" aria-label="' . $count . ' destaques, seletor em forma de carrossel">';
        for ($y = 0; $y < $count; $y++) {
            $output .= sprintf(
                '<li data-bs-target="#carousel_highlights_articles" data-bs-slide-to="%1$d"%2$s><span role="button">%3$d</span></li>',
                $y,
                $y === 0 ? ' class="active"' : '',
                $y + 1
            );
        }
        $output .= '</ol>';
    }

    $output .= '<div class="carousel-inner">';
    foreach ($stickies as $x => $post) {
        $category = get_the_category($post->ID);
        $link     = $home . '/blogue/' . ($category ? $category[0]->slug : 'sem-categoria') . '/' . $post->post_name;
        $button   = (string) get_post_meta($post->ID, 'sticky_button', true);
        $image_id = (int) get_post_meta($post->ID, 'ama_imagem_carrossel', true);
        $image    = $image_id ? wp_get_attachment_image($image_id, 'medium_large', false, ['class' => 'img-fluid destaque-imagem']) : '';

        $text = '<h3 class="info_title h2 mb-3"><a href="' . esc_url($link) . '">' . $post->post_title . '</a></h3>'
            . '<p class="info_content mb-3">' . get_the_excerpt($post) . '</p>'
            . '<div class="d-inline btn_more_infos"><a class="ama btn btn-primary" title="' . esc_attr($post->post_title) . '" href="' . esc_url($link) . '">' . ($button !== '' ? esc_html($button) : 'Ler mais') . '</a></div>';

        if ($image !== '') {
            $text = '<div class="row">'
                . '<div class="col-12 col-md-8">' . $text . '</div>'
                . '<div class="col-12 col-md-4 destaque-imagem-coluna">' . $image . '</div>'
                . '</div>';
        }

        $output .= '<div class="carousel-item' . ($x === 0 ? ' active' : '') . '">' . $text . '</div>';
    }
    $output .= '</div></div>';

    return $output;
}
add_shortcode('get_artigos_destaque_homepage', 'get_artigos_destaque_homepage');

/**
 * Campo do artigo para a imagem do slide (ACF, definido aqui para ficar no código).
 */
function ama_carrossel_campo_imagem(): void
{
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group([
        'key'      => 'group_ama_carrossel_homepage',
        'title'    => 'Destaque na página de início',
        'fields'   => [
            [
                'key'           => 'field_ama_imagem_carrossel',
                'label'         => 'Imagem no destaque da página de início',
                'name'          => 'ama_imagem_carrossel',
                'type'          => 'image',
                'instructions'  => 'Opcional. Aparece à direita do texto no carrossel "Em destaque" (só para artigos fixos no topo). Sem imagem, o texto ocupa a largura toda. O texto alternativo é o da imagem na Biblioteca multimédia.',
                'return_format' => 'id',
                'preview_size'  => 'medium',
                'library'       => 'all',
                'mime_types'    => 'jpg, jpeg, png, gif, webp, svg',
            ],
        ],
        'location' => [
            [
                ['param' => 'post_type', 'operator' => '==', 'value' => 'post'],
            ],
        ],
        'position' => 'side',
        'active'   => true,
    ]);
}
// Os shortcodes são carregados no "init", depois do "acf/init": nesse caso regista já.
if (did_action('acf/init')) {
    ama_carrossel_campo_imagem();
} else {
    add_action('acf/init', 'ama_carrossel_campo_imagem');
}

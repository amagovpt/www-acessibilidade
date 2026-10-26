<?php

/**
 * Shortcode para mostra uma lsitagem de todos os artigos.
 *
 * @return string|null
 */
function get_all_posts_cb(): ?string
{
    $output = '';
    $tag = '';
    $posts_per_page = 10;

    $current_page = get_query_var('paged') ? get_query_var('paged') : 1;

    // Posts
    $posts = new WP_Query([
        'post_type'         => 'post',
        'post_status'       => 'publish',
        'posts_per_page'    => $posts_per_page,
        'orderby'           => 'post_date',
        'order'             => 'DESC',
        'paged'             => $current_page
    ]);

    if (is_wp_error($posts)) {
        return null;
    }

    if(!$posts->have_posts()) {
        return null;
    }

    while($posts->have_posts()) {
        $posts->the_post();
        ob_start();
        get_template_part('template-parts/post-list', 'item');
        $output .= ob_get_clean();
    }

    if(is_category()) {
        $tag = 'data-category="'.get_queried_object()->slug.'" ';
    }

    // Constrói e devolve os resultados
    $output     = sprintf('<div class="post-list-container"><div class="loading-posts"></div><ul '.$tag.'class="post-list">%s</ul></div>', $output);
    $pagination = AMA_pagination_v2($posts, $current_page);
    $output     .= '<div id="paginacao">'.$pagination.'</div>';

    wp_reset_postdata();

    return $output;
}

add_shortcode('all_posts', 'get_all_posts_cb');
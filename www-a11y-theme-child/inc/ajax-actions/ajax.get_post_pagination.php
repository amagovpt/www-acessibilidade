<?php

/**
 * Callback AJAX para a paginação de artigos do sítio web.
 *
 * @return void
 */
function ama_post_pagination(): void
{
    $page = isset($_POST['page']) ? sanitize_text_field(wp_unslash($_POST['page'])) : 1;
    $page = intval($page);

    $output = '';

    $query_params = [
        'post_type'         => 'post',
        'post_status'       => 'publish',
        'posts_per_page'    => 10,
        'orderby'           => 'post_date',
        'order'             => 'DESC',
        'paged'             => intval($page)
    ];

    if(isset($_POST['category']) && !empty($_POST['category'])) {
        $query_params['category_name'] = sanitize_text_field(wp_unslash($_POST['category']));
    }

    if (isset($_POST['category']) && !empty($_POST['category'])) {
        $query_params['category_name'] = sanitize_text_field(wp_unslash($_POST['category']));
    } elseif (isset($_POST['tag']) && !empty($_POST['tag'])) {
        $query_params['tag'] = sanitize_text_field(wp_unslash($_POST['tag']));
    }

    $posts = new WP_Query($query_params);

    if (is_wp_error($posts)) {
        wp_send_json_error("<li>Não foi possível obter mais resultados.<li>");
    }

    if(!$posts->have_posts()) {
        wp_send_json_error("<li>Não foi possível obter mais resultados.</li>");
    }

    while($posts->have_posts()) {
        $posts->the_post();
        ob_start();
        get_template_part('template-parts/post-list', 'item');
        $output .= ob_get_clean();
    }

    $pagination = AMA_pagination_v2($posts, $page);

    wp_reset_postdata();

    wp_send_json_success([
        'current_page'  => $page,
        'total_posts'   => $posts->found_posts,
        'pagination'    => $pagination,
        'content'       => $output,
    ]);
}

add_action("wp_ajax_nopriv_ama_post_pagination", "ama_post_pagination");
add_action("wp_ajax_ama_post_pagination", "ama_post_pagination");
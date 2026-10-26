<?php

/**
 * Shortcode para mostrar os posts em cards. Versão atualizada e corrigida.
 *
 * @param $attrs
 * @return string|null
 */
function posts_cards_cb( $attrs ): ?string
{
    global $wpdb;
    
    $html = '';

    $attrs = shortcode_atts([
            "total" => 3,
        ],
        $attrs
    );

    // Query para devolver os posts
    $query = "
    SELECT POST.ID, POST.post_title, POST.post_date 
    FROM {$wpdb->prefix}posts AS POST
    INNER JOIN {$wpdb->prefix}postmeta AS META ON POST.ID = META.post_id
    WHERE META.meta_key = 'destaque' AND META.meta_value = '1'
    ORDER BY POST.post_date DESC 
    LIMIT 0, 3;
";

    $posts = $wpdb->get_results($query);


    // Build the results
    if (!is_wp_error($posts)) {
        if (is_countable($posts) && count($posts)) {

            // Loop through all the posts
            foreach ($posts as $post) {

                // Verificar se o post tem imagem em destaque, caso contrário, verificar se tem imagem associada (meta field)
                if(has_post_thumbnail($post->ID)) {
                    $post_thumbnail_id = get_post_thumbnail_id($post->ID);
                } else {
                    $post_thumbnail_id = (get_post_meta($post->ID, "imagem", true)) ? get_post_meta($post->ID, "imagem", true)["ID"] : 0;
                }

                $html .=
                    '<li class="post-card-wrapper">
                        <article class="post-card">
                            <div class="post-thumbnail">
                                '.wp_get_attachment_image($post_thumbnail_id, "fullwidth", false, ["class" => "img-fluid"]).'
                            </div>
                                <div class="post-body">
                                    <h3 class="post-title">
                                        <a href="'.get_the_permalink($post->ID).'">'.get_the_title($post->ID).'</a>
                                    </h3>
                                    <p class="post-date">
                                        '.get_the_date("d \d\\e F, Y", $post->ID).'
                                    </p>
                                </div>
                        </article>
                    </li>';
            }

        }
    }



    // Apresenta os resultados
    return sprintf('<div class="container py-5"><div class="row"><div class="col p-0"><ul class="grid grid-1 grid-md-3 gap-40 list-unstyled">%s</ul></div></div></div>', $html);
}

add_shortcode("posts-cards", "posts_cards_cb");
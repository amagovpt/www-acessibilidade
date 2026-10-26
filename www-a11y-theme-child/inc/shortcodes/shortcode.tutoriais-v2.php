<?php

/**
 * Shortcode que devolve uma lista de tutoriais.
 *
 * Este shortcode devolve, em HTML, a lista de tutoriais disponíveis no site.
 * Os tutoriais estão originalmente inseridos no GitHub da AMA, e o seu conteúdo
 * é obtido através de uma chamada à API do GitHub. Cada tutorial tem um 'custom field' onde é
 * guardado a sua URL no GitHub.
 *
 * @return string|null
 */
function tutoriais_v2_cb(): ?string {

    $tuts = get_posts([
        'post_type'             => 'tuto',
        'posts_per_page'        => -1,
        'orderby'               => 'title',
        'order'                 => 'ASC',
        'ignore_sticky_posts'   => true,
    ]);

    if (empty($tuts)) {
        return null;
    }

    $output = '';

    foreach ($tuts as $tut) {

        $category = wp_get_object_terms($tut->ID, 'categoria_tuto', []);
        if(is_countable($category) && count($category) > 0){
            $category = $category[0]->name;
        } else {
            $category = '';
        }

        $output .= sprintf(
            '<li>
                        <div><a href="%s">%s</a></div>
                        <div>'.$category.'</div>
                        </li>',
            get_permalink($tut->ID),
            $tut->post_title
        );
    }


    return sprintf('<ul class="colunas-1 colunas-md-2 ama-list">%s</ul>', $output);
}
add_shortcode('tutoriais-v2', 'tutoriais_v2_cb');

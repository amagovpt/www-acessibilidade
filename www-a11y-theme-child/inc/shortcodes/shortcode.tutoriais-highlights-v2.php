<?php

function tutoriais_highlights_v2_cb(): ?string {
    $tuts = get_posts([
        'post_type'             => 'tuto',
        'posts_per_page'        => 3,
        'orderby'               => 'title',
        'order'                 => 'ASC',
        'ignore_sticky_posts'   => false,
    ]);

    if (empty($tuts)) {
        return null;
    }

    $icon       = '<div aria-hidden="true" class="icon-xl-forms"></div>';

    $output = '';
    foreach ($tuts as $tut) {

        $category = wp_get_object_terms($tut->ID, 'categoria_tuto', []);
        if(is_countable($category) && count($category) > 0){
            $category = $category[0]->name;
        } else {
            $category = '';
        }
        // TODO: Criar um Custom field para o ícone e mostrar o ícone

        $output .= '<li class="card-highlight">
                        <div class="card-body row">
                            <div class="col-12">
                                <p class="card-text">'.$category.'</p>
                                <h3 class="card-title">
                                    <a href="'.get_permalink($tut->ID).'">'.$tut->post_title.'</a>
                                </h3>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="icons_tutorials">'.$icon.'</div>
                        </div>
                    </li>';
    }

    return sprintf('<ul class="grid grid-md-3 gap-30">%s</ul>', $output);
}

add_shortcode('tutoriais-highlights-v2', 'tutoriais_highlights_v2_cb');
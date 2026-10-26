<?php

/**
 * Mostra as ferramentas em destaque em formato grelha.
 *
 * Este shortcode é utilizado na página de Ferramentas.
 * Mostra as ferramentas em destaque.
 *
 * @param array $attrs
 * @return string|null
 */
function get_highlights_tools( array $attrs ): ?string
{

    $attrs = shortcode_atts( array(
        'class' => '',
    ), $attrs );

    $output = '';
    $tools_params = array(
        'limit'   => 3,
        'orderby' => 'destaque.meta_value DESC, post_date DESC',
        'post_status' => 'publish'
    );
    $tools = pods( 'ferramentas' , $tools_params);
    $x=0;
    while ( $tools->fetch() ){
        $category   = wp_get_object_terms( $tools->rows[$x]->ID, 'categoria_ferramenta', array());
        $id_tool    = $tools->display('ID');
        $target_txt = '';

        $x++;

        if($tools->display('icon') == false){
            $icon = '<div aria-hidden="true" class="icon-xl-validations"></div>';
        } else {
            $icon = '<img aria-hidden="true" alt="icone" class="icon_card" src="'.$tools->display('icon').'"/>';
        }

        $output .= '<li class="card-highlight">
                        <div class="card-body row">
                            <div class="col-12">
                                <p class="card-text">'.$category[0]->name.'</p>
                                <h3 class="card-title h4 mb-4"><a '.$target_txt.' href="'.$tools->display('link').'">'.$tools->display('post_title').'</a></h3>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="icons_tutorials">'.$icon.'</div>
                        </div>
                    </li>';
    }

    return sprintf('<ul class="list-unstyled grid grid-md-3 gap-30 '.$attrs["class"].'">%s</ul>', $output);
}
add_shortcode( 'get_highlights_tools', 'get_highlights_tools' );
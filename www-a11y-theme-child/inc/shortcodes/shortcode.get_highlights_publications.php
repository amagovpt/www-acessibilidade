<?php
function get_highlights_publications( array $atts ): ?string
{
    $attrs = shortcode_atts( array(
        'class' => '',
    ), $atts );
    $home = home_url();
    $output = '';
    $publications_params = array(
        'limit'   => 3,
        'orderby' => 'destaque.meta_value DESC',
    );
    $publications = pods( 'publicacoes' , $publications_params);
    $x=0;
    while ( $publications->fetch() ){
        $category = wp_get_object_terms( $publications->rows[$x]->ID, 'categoria_publicacao', array());
        $x++;
        $icon = '';
        if($publications->display('icon') == false){
            $icon = '<div aria-hidden="true" class="icon-xl-law"></div>';
        }
        else{
            $icon = '<img aria-hidden="true" alt="icone" class="icon_card" src="'.$publications->display('icon').'"/>';
        }

        $output .= '<li class="card-highlight">
                        <div class="card-body row">
                            <div class="col-12">
                                <p class="card-text">'.$category[0]->name.'</p>
                                <h3 class="card-title"><a href="'.$home.'/publicacao/'.$publications->display('post_name').'">'.$publications->display('post_title').'</a></h3>
                            </div>
                            
                        </div>
                        <div class="card-footer">
                                '.$icon.'
                            </div>
                    </li>';
    }

    return sprintf('<ul class="list-unstyled grid grid-md-3 gap-30 '.$attrs["class"].'">%s</ul>', $output);
}
add_shortcode( 'get_highlights_publications', 'get_highlights_publications' );
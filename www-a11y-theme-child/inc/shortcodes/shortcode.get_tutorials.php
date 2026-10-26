<?php
/**
 * Shortcode para mostrar os tutoriais.
 *
 * @return string|null
 */
function get_tutorials(): ?string
{
    #return "<h1> hello, world!</h1>";
    $output             = '';
    $home               = home_url();
    $tutorials_params   = array(
        'limit'   => -1,
        'orderby' => 'post_date DESC',
        'post_status' => 'publish'
    );
    $tutorials          = pods( 'tutorial' , $tutorials_params);


    if(is_countable($tutorials->rows) && !count($tutorials->rows) > 0){
        return null;
    }

    foreach ($tutorials->rows as $tutorial) {
        $output .= "<li>";
        $output .= "<a href='".get_permalink($tutorial->ID)."'>".$tutorial->post_title."</a>";
        $output .= "</li>";
    }

    return sprintf('<ul class="colunas-1 colunas-md-2 ama-list">%s</ul>', $output);
}
add_shortcode( 'get_tutorials', 'get_tutorials' );
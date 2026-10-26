<?php
function get_tutorials_home(): ?string
{
    $output = '';
    $tutorials_params = array(
        'limit'   => 6,
        'orderby' => 'destaque.meta_value DESC, post_date DESC',
        'post_status' => 'publish'
    );
    $tutorials = pods( 'tutorial' , $tutorials_params);

    if($tutorials !== false) {
        while ($tutorials->fetch()){
            $output .= '<li><a href="'.site_url().'/tutorial/'.$tutorials->display('post_name').'">'.$tutorials->display( 'post_title').'</a></li>';
        }
    } else {
        return "";
    }

    return sprintf('<ul class="ama-list">%s</ul>', $output);
}
add_shortcode( 'get_tutorials_home', 'get_tutorials_home' );
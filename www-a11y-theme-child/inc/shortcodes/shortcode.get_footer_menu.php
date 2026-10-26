<?php
function get_footer_menu(){
    $output = '';
    $home = home_url();
    $footer_menu = wp_get_nav_menu_items('107');
    foreach ($footer_menu as $menu) {
        if($menu->target == '_blank'){
            $output .= '<li class="d-flex links">
							<a target ="_blank" href="'.$menu->url.'">'.$menu->title.'</a>
						</li>';
        }
        else{
            $output .= '<li class="d-flex links">
							<a href="'.$menu->url.'">'.$menu->title.'</a>
						</li>';
        }

    }
    return $output;
}
add_shortcode( 'get_footer_menu', 'get_footer_menu' );
<?php
function get_header_menu(){
    $output = '';
    $home = home_url();
    $header_menu = wp_get_nav_menu_items('125');
    foreach ($header_menu as $menu) {
        if($menu->title == 'Modo Escuro'){
            $output .= '<li class="d-flex align-items-center" id="btn_dark_mode">
							<a href="#" id="dark_mode"><span aria-hidden="true" class="icon-dark icon"></span></a>
						</li>';
        }
        else if($menu->title == 'In English'){
            $output .= '<li class="d-flex align-items-center" id="btn_english_version" lang="en">
							<a href="'.$menu->url.'"><em lang="en">'.$menu->title.'</em><span aria-hidden="true" class="icon-globe-language icon"></span></a>
						  </li>';
        }
        else{
            $output .= '<li class="d-flex align-items-center" id="'.$menu->title.'">
							<a href="'.$menu->url.'">'.$menu->title.'</a>
						  </li>';
        }
    }
    return $output;
}
add_shortcode( 'get_header_menu', 'get_header_menu' );
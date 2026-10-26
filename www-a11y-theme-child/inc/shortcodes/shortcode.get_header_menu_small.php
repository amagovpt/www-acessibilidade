<?php
function get_header_menu_small(){
    $output = '';
    $home = home_url();
    $header_menu = wp_get_nav_menu_items('125');
    foreach ($header_menu as $menu) {
        if($menu->title == 'Modo Escuro'){
            $output .= '<li class="d-flex align-items-center">
							<a class="d-flex align-items-center" href="#" id="dark_mode_small">
								<span id="dark_mode_text_small"></span>
								<span aria-hidden="true" class="icon-dark icon"></span>
							</a>
						</li>';
        }
        else if($menu->title == 'In English'){
            $output .= '<li class="d-flex align-items-center" id="link_lang">
							<a class="d-flex align-items-center" href="'.$menu->url.'">
								<span><em lang="en">'.$menu->title.'</em></span>
								<span aria-hidden="true" class="icon-globe-language icon"></span>
							</a>
						</li>';
        }
        else{
            $output .= '<li class="d-flex align-items-center" id="'.$menu->title.'">
							<a class="d-flex align-items-center" href="'.$menu->url.'">
								<span>'.$menu->title.'</span>
							</a>
						</li>';
        }
    }
    return $output;
}
add_shortcode( 'get_header_menu_small', 'get_header_menu_small' );
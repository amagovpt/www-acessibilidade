<?php
function get_destaques(){
    $output = '';
    $home = home_url();
    $destaques_params = array(
        'limit'   => -1,
        'orderby' => 'post_date DESC',
        'post_status' => 'publish'
    );
    $destaques = pods( 'artigos-quem_somos' , $destaques_params);


    foreach($destaques->rows as $destaque){
        $link = get_post_meta($destaque->ID,'link');

        $output .= '<li class="p-2 d-flex justify-content-start align-items-center">
							<div aria-hidden="true" class="icon-arrow-bullets d-flex justify-content-start align-items-center"></div>';
        if($link[0] == ''){
            $link = $home. '/mudanca/' .$destaque->post_name;
            $output .= '<div><a href="'.$link.'">'.$destaque->post_title.'</a></div>
						</li>';
        }
        else{
            $link = $link[0];
            $output .= '<div><a target="_blank" href="'.$link.'">'.$destaque->post_title.'<span class="sr-only">hiperligação externa</span></a></div>
						</li>';
        }
    }
    return $output;
}
add_shortcode( 'get_destaques', 'get_destaques' );
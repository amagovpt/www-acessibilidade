<?php
function get_tools_home(): ?string
{
    $output = '';
    $tools_params = array(
        'limit'   => 7,
        'orderby' => 'destaque.meta_value DESC, post_date DESC',
        'post_status' => 'publish'
    );
    $tools = pods( 'ferramentas' , $tools_params);
    while ($tools->fetch()){
        $id_tool = $tools->display('ID');
        $target = get_post_meta($id_tool,'link_externo');
        $target_txt = '';
        if($target[0] == "1"){
            $target_txt = 'target="_blank"';
        }
        $output .= '<li><a '.$target_txt.' href="'.$tools->display('link').'">'.$tools->display('post_title').'<span class="visually-hidden"> hiperligação externa</span></a></li>';
    }
    return  sprintf('<ul class="ama-list">%s</ul>', $output);
}
add_shortcode( 'get_tools_home', 'get_tools_home' );
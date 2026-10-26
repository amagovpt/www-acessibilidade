<?php
function get_most_views(){
    $output = '';
    $home = home_url();
    $views_params = array(
        'limit'   => 4,
        'orderby' => 'visualizacoes.meta_value DESC, post_date DESC',
        'post_status' => 'publish'
    );
    $articles_views = pods( 'post' , $views_params);
    while($articles_views->fetch()){
        $post_date = $articles_views->display('post_modified');
        $date = get_the_date($format="",  $articles_views->display('ID'));
        $category_views = get_the_category($articles_views->display('ID'));
        $output .= '<li class="item">
                        <h3 class="h5"><a href="'.get_permalink($articles_views->id()).'">'.$articles_views->display('post_title').'</a></h3>
                        <div class="post-state">'.$date.'</div>
                    </li>';
    }
    return sprintf('<ul class="most-read">%s</ul>', $output);
}
add_shortcode( 'get_most_views', 'get_most_views' );
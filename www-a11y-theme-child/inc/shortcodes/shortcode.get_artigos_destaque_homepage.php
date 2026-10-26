<?php
function get_artigos_destaque_homepage(){
    $output = '';
    $home = home_url();
    $sticky = get_option( 'sticky_posts' );

    $args_sticky = array(
        'posts_per_page' => 4,
        'limit' => 4,
        'post__in'  => $sticky,
        'orderby' => 'post_date DESC',
        'post_status' => 'publish'
    );
    $stickies = query_posts($args_sticky);

    $output = '<div id="carousel_highlights_articles" class="carousel" data-ride="carousel" data-interval="false">';

    $count = count($stickies);
    if($count > 4){
        $count = 4;
    }
    if($count > 1){
        $output .= '<ol class="carousel-indicators" aria-label="'.$count.' destaques, seletor em forma de carrossel">';
        for($y=0;$y<$count;$y++){
            $n = $y+1;
            if($y == 0){
                $output .= '<li data-bs-target="#carousel_highlights_articles" data-bs-slide-to="0" class="active"><span role="button">1</span></li>';
            }
            else{
                $output .= '<li data-bs-target="#carousel_highlights_articles" data-bs-slide-to="'.$y.'"><span role="button">'.$n.'</span></li>';
            }
        }
        $output .= '</ol>';
    }
    $output .= '<div class="carousel-inner">';
    $x = 0;
    foreach($stickies as $article){
        $post = get_post($article);
        $descricao = get_the_excerpt($article);
        $category = get_the_category($article);
        $button = get_post_meta($post->ID,'sticky_button');
        if($x == 0){
            $output .= '<div class="carousel-item active">
							 <h3 class="info_title h2 mb-3"><a href="'.$home.'/blogue/'.$category[0]->slug.'/'.$post->post_name.'">'.$post->post_title.'</a></h3>
							<p class="info_content mb-3">'.$descricao.'</p>
							   <div class="d-inline btn_more_infos"><a class="ama btn btn-primary" title="'.$post->post_title.'" href="'.$home.'/blogue/'.$category[0]->slug.'/'.$post->post_name.'">'.$button[0].'</a></div>
						</div>';
        }
        else{
            $output .= '<div class="carousel-item">
							 <h3 class="info_title"><a href="'.$home.'/blogue/'.$category[0]->slug.'/'.$post->post_name.'">'.$post->post_title.'</a></h3>
							<p class="info_content">'.$descricao.'</p>
							   <div class="d-inline btn_more_infos"><a class="ama btn btn-primary" title="'.$post->post_title.'" href="'.$home.'/blogue/'.$category[0]->slug.'/'.$post->post_name.'">'.$button[0].'</a></div>
						</div>';
        }
        $x++;
    }
    $output .= '</div>';
    $output .= '</div>';
    return $output;
}
add_shortcode( 'get_artigos_destaque_homepage', 'get_artigos_destaque_homepage' );

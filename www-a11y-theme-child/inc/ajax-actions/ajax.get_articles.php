<?php

function get_articles(){
    $home = home_url();
    $output = array();

    $highlight_params = array(
        'limit'   => 1,
        /*'orderby' => 'destaque.meta_value DESC, post_date DESC',*/
        'orderby' => 'post_date DESC',
        'post_status' => 'publish',
        'where'  => 'destaque.meta_value = 1'
    );
    $highlight_article = pods( 'post' , $highlight_params);
    $first_id          = null;
    while ( $highlight_article->fetch() ) {
        $first_id = $highlight_article->field( 'ID' );
    }

    $page = isset( $_POST['page'] ) ? (int) $_POST['page'] : 1;
    if ( $page < 1 ) {
        $page = 1;
    }
    $offset = ( ( $page - 1 ) * 7 ) + 3;

    $query_args = array(
        'post_type'      => 'post',
        'posts_per_page' => 7,
        'offset'         => $offset,
        'post_status'    => 'publish',
        'orderby'        => 'post_date DESC',
    );
    if ( $first_id ) {
        $query_args['post__not_in'] = array( (int) $first_id );
    }
    $all_articles_params = get_posts( $query_args );
    $flag = 0;

    foreach ($all_articles_params as $all_articles) {
        $format = "j \\d\\e F, Y";
        $post_date = $all_articles->post_modified;
        $date = get_the_date($format,  $all_articles->ID);
        $category = get_the_category( $all_articles->ID );
        if ( empty( $category ) ) {
            continue;
        }
        $description = get_the_excerpt( $all_articles->ID );
        if($flag < 3){
            $output[$flag] = '<li class="press_item py-5">
		                            <h3 class="h5"><a href="'.$home.'/blogue/'.$category[0]->slug.'/'.$all_articles->post_name.'"> '.$all_articles->post_title.'</a></h3>
		                            <span class="d-flex my-3">'.$date.'</span>
		                            <div class="d-sm-block d-none">
		                                <p>'.$description.'</p>
		                                <div class="d-inline-flex read_more">
		                                    <a class="ama btn btn-secondary" href="'.$home.'/blogue/'.$category[0]->slug.'/'.$all_articles->post_name.'" title="'.$all_articles->post_title.'">Ler mais</a>
		                                </div>
		                            </div>
		                        </li>';
        }
        else{
            $output[$flag] = '<li class="press_item py-5">
	                            <h3 class="h5"><a href="'.$home.'/blogue/'.$category[0]->slug.'/'.$all_articles->post_name.'">'.$all_articles->post_title.'</a></h3>
	                            <span class="d-flex">'.$date.'</span>
	                        </li>';
        }
        $flag++;
    }
    echo json_encode(implode('', $output));
    die();
}
add_action('wp_ajax_get_articles', 'get_articles');
add_action('wp_ajax_nopriv_get_articles', 'get_articles');
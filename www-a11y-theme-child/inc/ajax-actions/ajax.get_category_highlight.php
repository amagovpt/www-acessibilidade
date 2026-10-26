<?php

function get_category_highlight(){
    $output = '';
    $home = home_url();
    $category_id = $_POST['id'];
    $articles = query_posts(
        array('post_type' => 'post',
            'posts_per_page' => 3,
            'order'     => 'DESC',
            'meta_key'  => 'destaque',
            'orderby'   => 'meta_value_num', //or 'meta_value_num'
            'post_status' => 'publish',
            'tax_query' => array(
                array('taxonomy' => 'category',
                    'terms' => $category_id
                )
            )
        )
    );
    foreach( $articles as $post ){
        $post_date = $post->post_date;
        $date = get_the_date('', $post->ID);
        $category = get_the_category($post->ID);

        $image = '';
        $alt   = '';
        if ( has_post_thumbnail( $post->ID ) ) {
            $thumbnail_id = get_post_thumbnail_id( $post->ID );
            $image        = wp_get_attachment_image_url( $thumbnail_id, 'large' );
            $alt          = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );
            if ( empty( $alt ) ) {
                $alt = get_the_title( $post->ID );
            }
        } elseif ( get_post_meta( $post->ID, 'imagem', true ) ) {
            $image_array = get_post_meta( $post->ID, 'imagem', true );
            $image       = $image_array['guid'] ?? '';
            $alt         = $image_array['post_title'] ?? '';
        } else {
            $aux = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
            if ( $aux >= 1 ) {
                $image = $matches[1][0] ?? '';
                $aux2  = preg_match_all('/<img.+alt=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches_alt);
                $alt   = $matches_alt[1][0] ?? '';
            }
        }

        $output .= '<div class="col-lg-4 col-12">
                            <article class="card-block ">
                                <div class="image-box">
                                    <img class="img-fluid w-100" alt="'.$alt.'" src="'.$image.'">
                                </div>
                            	<div class="content-box">
                                	<h3 class="news-title"><a href="'.$home.'/blogue/'.$category[0]->slug.'/'.$post->post_name.'">'.$post->post_title.'</a></h3>
                                	<p>'.$date.'</p>
                            	</div>
                            </article>
                        </div>';
    }
    echo json_encode($output);
    die();
}

add_action('wp_ajax_get_category_highlight', 'get_category_highlight');
add_action('wp_ajax_nopriv_get_category_highlight', 'get_category_highlight');


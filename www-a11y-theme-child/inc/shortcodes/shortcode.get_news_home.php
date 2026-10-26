<?php
function get_news_home(){
    $home = home_url();
    $output = '';
    $articles_params = array(
        'limit'   => 3,
        'orderby' => 'destaque.meta_value DESC, post_date DESC',
        'post_status' => 'publish'
    );
    $articles = pods( 'post' , $articles_params);
    while($articles->fetch()){
        $post_date = $articles->display('post_modified');
        $date = get_the_date($format = '',  $articles->display('ID'));
        $category_highlights = get_the_category($articles->display('ID'));
        $image = '';
        $alt   = '';
        if ( has_post_thumbnail( $articles->display('ID') ) ) {
            $thumbnail_id = get_post_thumbnail_id( $articles->display('ID') );
            $image        = wp_get_attachment_image_url( $thumbnail_id, 'large' );
            $alt          = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );
            if ( empty( $alt ) ) {
                $alt = $articles->display('post_title');
            }
        } elseif ( $articles->display('imagem') ) {
            $image_array = get_post_meta( $articles->display('ID'), 'imagem' );
            $image       = $image_array[0]['guid'] ?? '';
            $alt         = $image_array[0]['post_title'] ?? '';
        } else {
            $aux = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $articles->display("post_content"), $matches);
            if ( $aux >= 1 ) {
                $image = $matches[1][0] ?? '';
                $aux2  = preg_match_all('/<img.+alt=[\'"]([^\'"]+)[\'"].*>/i', $articles->display("post_content"), $matches_alt);
                $alt   = $matches_alt[1][0] ?? '';
            }
        }
        $output .= '<div class="col-lg-4 col-12">
							<article class="card-block">
								<div class="image-box">
									<img class="img-fluid w-100" alt="'.$alt.'" src="'.$image.'">
								</div>
								<div class="content-box">
									<h3 class="news-title"><a href="'.$home.'/blogue/'.$category_highlights[0]->slug.'/'.$articles->display("post_name").'/">'.$articles->display("post_title").'</a></h3>
									<p>'.$date.'</p>
								</div>
							</article>
						</div>';
    }
    return $output;
}
add_shortcode( 'get_news_home', 'get_news_home' );
<?php
function get_news()
{
    $home = home_url();
    $output = '';

    $highlight_params = array(
        'limit'         => 1,
        'orderby'       => 'post_date DESC',
        'post_status'   => 'publish',
        'where'         => 'destaque.meta_value = 1'
    );
    $highlight_article = pods( 'post' , $highlight_params);
    while($highlight_article->fetch()){
        $first_id = $highlight_article->field('ID');
    }

    $articles_params = array(
        'limit'         => 3,
        'orderby'       => 'post_date DESC',
        'post_status'   => 'publish',
        'where'         => 'id <> '.$first_id.'',
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
        $output .= '<li class="post-card-wrapper col-lg-4 col-12">
                        <article class="post-card">';
                        $output .= '<div class="post-thumbnail">';
                        if(has_post_thumbnail($articles->display('ID'))) {
                            
                            $output .= get_the_post_thumbnail($articles->display('ID'), 'large', ['class' => 'img-fluid']);
                            

                        }
                        $output .= '</div>';
                        $output .= '<div class="post-body">
                                <h3 class="post-title"><a href="'.$home.'/blogue/'.$category_highlights[0]->slug.'/'.$articles->display("post_name").'/">'.wp_trim_words($articles->display("post_title"), 15).'</a></h3>
                                <p class="post-date">'.$date.'</p>
                            </div>
                        </article>
                    </li>';
    }
    return sprintf('<div class="container-fluid px-0"><ul class="row list-unstyled">%s</ul></div>',$output);
}
add_shortcode( 'get_news', 'get_news' );
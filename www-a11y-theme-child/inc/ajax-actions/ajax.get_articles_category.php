<?php
function get_articles_category(){
    $home = home_url();
    $output = array();
    $offset = $_POST['offset'];
    $category_id = $_POST['category_id'];
    $all_articles_params = get_posts(
        array(
            'posts_per_page' => 7,
            'offset' => $offset,
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC',
            'tax_query' => array(
                array(
                    'taxonomy' => 'category',
                    'field' => 'term_id',
                    'terms' => $category_id,
                )
            )
        )
    );
    $flag = 0;
    foreach ($all_articles_params as $all_articles) {
        $post_date = $all_articles->post_modified;
        $date = get_the_date($format,  $all_articles->ID);
        $category = get_the_category($all_articles->ID);
        $descricao = get_the_excerpt($all_articles->ID);
        if($flag < 3){
            $output[$flag] = '<li class="press_item">
		                            <h3><a href="'.$home.'/blogue/'.$category[0]->slug.'/'.$all_articles->post_name.'"> '.$all_articles->post_title.'</a></h3>
		                            <span class="d-flex">'.$date.'</span>
		                            <div class="d-sm-block d-none">
		                                <p>'.$descricao.'</p>
		                                <div class="d-inline-flex read_more">
		                                    <a href="'.$home.'/blogue/'.$category[0]->slug.'/'.$all_articles->post_name.'" title="'.$all_articles->post_title.'">Ler mais</a>
		                                    <div class="d-flex align-items-center read_more_arrow">
		                                        <div aria-hidden="true" class="icon-arrow-bullets d-flex align-items-center"></div>
		                                    </div>
		                                </div>
		                            </div>
		                        </li>';
        }
        else{
            $output[$flag] = '<li class="press_item">
		                            <h3><a href="'.$home.'/blogue/'.$category[0]->slug.'/'.$all_articles->post_name.'">'.$all_articles->post_title.'</a></h3>
		                            <span class="d-flex">'.$date.'</span>
		                        </li>';
        }
        $flag++;
    }

    echo json_encode(implode('', $output));
    die();
}
add_action('wp_ajax_get_articles_category', 'get_articles_category');
add_action('wp_ajax_nopriv_get_articles_category', 'get_articles_category');
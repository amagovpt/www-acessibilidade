<?php

function get_search(){
    $home = home_url();
    $output = array();
    $search = $_POST['search'];
    //$search = utf8_encode($search);
    $offset = $_POST['offset'];
    $area = $_POST['area'];
    $category = $_POST['category'];
    $relevance = $_POST['relevance'];

    if($area == ''){
        $area_query = array('post', 'publicacoes', 'tutorial', 'ferramentas');
    }
    else{
        $area_query = $area;
    }

    $args = array(
        'posts_per_page' => 10,
        'offset' => $offset,
        'post_type' => $area_query,
        's' => $search,
        'orderby' => 'post_date',
        'order' => $relevance,
        'post_status' => 'publish'
    );

    if($category != ''){
        $args = array(
            'posts_per_page' => 10,
            'offset' => $offset,
            'post_type' => $area_query,
            's' => $search,
            'orderby' => 'post_date',
            'order' => $relevance,
            'post_status' => 'publish',
            'tax_query' => array(
                array(
                    'taxonomy' => 'category',
                    'field' => 'term_id',
                    'terms' => $category,
                )
            )
        );
    }

    $the_query = new WP_Query($args);
    $count = count($the_query->posts);

    $aux = 0;
    foreach ($the_query->posts as $post){
        $post_modified = $the_query->post_modified;
        $date = get_the_date($format,  $post->ID);
        $category = '';
        $descricao = '';
        $category_link = '';
        $link = '';
        switch ($post->post_type){
            case 'publicacoes':
                $category = 'Publicações';
                $descricao = $post->descricao;
                $category_link = 'publicacoes';
                $link = get_post_meta($post->ID, 'link', FALSE);
                $link = $home.'/publicacao/'.$post->post_name.'/';
                break;
            case 'post':
                $category = 'Blogue';
                //$descricao = $post->descricao;
                $descricao = get_the_excerpt($post->ID);
                $category_link = 'blogue';
                $blogue_category = get_the_category($post->ID);
                $link = $home.'/blogue/'.$blogue_category[0]->slug.'/'.$post->post_name.'/';
                break;
            case 'ferramentas':
                $category = 'Ferramentas';
                $tag = get_the_tags($post->ID);
                $descricao = $tag[0]->name;
                $category_link = 'ferramentas';
                $link = get_post_meta($post->ID, 'link', FALSE);
                $link = $link[0];
                break;
            case 'tutorial':
                $category = 'Tutoriais';
                $descricao = $post->post_content;
                $category_link = 'tutoriais';
                $link = $home.'/tutorial/'.$post->post_name.'/';
                break;
        }
        $descricao = str_replace( $search, '<span class="search_match">'.$search.'</span>', $descricao);
        $output[$aux] = '<li class="search_item">
                                <a href="'.$link.'"><h3>'.$post->post_title.'</h3></a>
                                <span class="d-flex"><a href="'.$home.'/'.$category_link.'/" class="category_link">'.$category.'</a>&nbsp;| '.$date.'</span>
                                <p>'.$descricao.'</p>
                            </li>';
        $aux++;
    }
    echo json_encode(implode('', $output));
    die();
}
add_action('wp_ajax_get_search', 'get_search');
add_action('wp_ajax_nopriv_get_search', 'get_search');
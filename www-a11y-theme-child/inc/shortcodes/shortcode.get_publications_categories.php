<?php
function get_publications_categories(){
    $output = '';
    $home = home_url();
    $categories = get_terms( 'categoria_publicacao' );
    $aux = 0;
    foreach($categories as $category){
        if($aux < 8){
            $output .= '<li class="list-group-item border-0">
							<a class="d-block" href="'.$home.'/publicacoes/">'.$category->name.'</a>
						</li>';
        }
        $aux++;
    }
    return $output;
}
add_shortcode( 'get_publications_categories', 'get_publications_categories' );
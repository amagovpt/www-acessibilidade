<?php
function get_tutorials_categories(){
    $output = '';
    $home = home_url();
    $categories = get_terms( 'categoria_tutorial' );
    $aux = 0;
    foreach($categories as $category){
        if($aux < 8){
            $output .= '<li class="list-group-item border-0">
								<a class="d-block" href="'.$home.'/tutoriais/">'.$category->name.'</a>
							</li>';
        }
        $aux++;
    }
    return $output;
}
add_shortcode( 'get_tutorials_categories', 'get_tutorials_categories' );
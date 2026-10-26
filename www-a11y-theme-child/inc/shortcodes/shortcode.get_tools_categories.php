<?php
function get_tools_categories(): ?string{
    $output = '';
    $home = home_url();
    $categories = get_terms( 'categoria_ferramenta' );
    $aux = 0;
    if(!is_wp_error($categories) && !empty($categories)) {
        foreach($categories as $category){
            if($aux < 8){
                $output .= '<li class="list-group-item border-0">
								<a class="d-block" href="'.$home.'/ferramentas/">'.$category->name.'</a>
							</li>';
            }
            $aux++;
        }
    }

    return $output;
}
add_shortcode( 'get_tools_categories', 'get_tools_categories' );
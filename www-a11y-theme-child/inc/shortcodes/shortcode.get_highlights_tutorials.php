<?php

/**
 * Shortcode para mostrar os tutoriais em destaque.
 *
 * @return string|null
 */
function get_highlights_tutorials(): ?string {
    $output = '';
    $home = home_url();
    $tutorials_params = array(
        'limit'   => 3,
        'orderby' => 'destaque.meta_value DESC, post_date DESC',
        'post_status' => 'publish'
    );
    $tutorial = pods( 'tutorial' , $tutorials_params);
    $x=0;
    while ( $tutorial->fetch() ){
        $category = wp_get_object_terms( $tutorial->rows[$x]->ID, 'categoria_tutorial', array());
        if(count($category) == 0){
            $category = '';
        }
        else{
            $category = $category[0]->name;
        }
        $x++;
        $icon = '';
        if($tutorial->display('icon') == false){
            $icon = '<div aria-hidden="true" class="icon-xl-forms"></div>';
        }
        else{
            //$icon = '<object aria-hidden="true" type="image/svg+xml" data="'.$tutorial->display('icon').'" class="icon_card">icon</object> ';
            $icon = '<img aria-hidden="true" alt="icone" class="icon_card" src="'.$tutorial->display('icon').'"/>';
        }

        $output .= '<li class="card-highlight">
                        <div class="card-body row">
                            <div class="col-12">
                                <p class="card-text">'.$category.'</p>
                                <h3 class="card-title"><a href="'.$home.'/tutorial/'.$tutorial->display('post_name').'">'.$tutorial->display('post_title').'</a></h3>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="icons_tutorials">'.$icon.'</div>
                        </div>
                    </li>';
    }
    return sprintf('<ul class="grid grid-md-3 gap-30">%s</ul>', $output);
}
add_shortcode( 'get_highlights_tutorials', 'get_highlights_tutorials' );
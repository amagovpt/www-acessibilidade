<?php
function get_blogue_categories(): string
{
    $output = '';
    $home = home_url();
    $categories = get_categories();
    if (!empty($categories) && !is_wp_error($categories)) {
        foreach($categories as $category){
            $output .= '<li class="item"><a href="'.$home.'/blogue/'.$category->slug.'/">'.$category->name.'</a></li>';
        }
    }

    return sprintf('<ul class="sidebar-list">%s</ul>', $output);
}
add_shortcode( 'get_blogue_categories', 'get_blogue_categories' );
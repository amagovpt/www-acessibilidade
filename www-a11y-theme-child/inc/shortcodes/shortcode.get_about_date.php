<?php
function get_about_date(){
    $date = get_the_date($format = '', 11);
    return $date;
}
add_shortcode( 'get_about_date', 'get_about_date' );
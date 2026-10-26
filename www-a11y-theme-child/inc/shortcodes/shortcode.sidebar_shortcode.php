<?php
function get_my_sidebar($atts, $output)
{
    extract(shortcode_atts(array(
        'widget_name' => FALSE
    ), $atts));
    $widget_name = esc_html($widget_name);
    ob_start();
    dynamic_sidebar($widget_name);
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}

add_shortcode('sidebar_shortcode','get_my_sidebar');
<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Path to the shortcodes directory
$ajax_actions_dir = get_stylesheet_directory() . '/inc/ajax-actions/';

// Get all PHP files in the shortcodes directory
$ajax_actions_files = glob( $ajax_actions_dir . 'ajax.*.php' );

// Include each shortcode file
foreach ($ajax_actions_files as $file ) {
    require_once $file;
}
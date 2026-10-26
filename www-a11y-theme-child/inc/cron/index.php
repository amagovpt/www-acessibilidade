<?php
defined('ABSPATH') || exit;

$cron_dir = get_stylesheet_directory() . '/inc/cron/';
$cron_files = glob($cron_dir . 'cron-*.php');

foreach ($cron_files as $file) {
    require_once $file;
}

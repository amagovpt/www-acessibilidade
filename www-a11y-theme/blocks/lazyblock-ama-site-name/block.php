<?php
/**
 * Example Block Template.
 *
 * @var  array  $attributes Block attributes.
 * @var  array  $block Block data.
 * @var  string $context Preview context [editor,frontend].
 */

// Global variable to track if H1 has been output
global $ama_h1_output;

if(is_front_page() && !$ama_h1_output) {
	echo '<h1 class="site-name mb-0">'.$attributes['site-name'].'</h1>';
	$ama_h1_output = true;
} else {
	echo '<span class="site-name mb-0">'.$attributes['site-name'].'</span>';
}


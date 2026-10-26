<?php
/**
 * Divisória Template.
 *
 * @var  array  $attributes Block attributes.
 * @var  array  $block Block data.
 * @var  string $context Preview context [editor,frontend].
 */

// Desabilita o wrapper do bloco
add_filter( $block["slug"].'/frontend_allow_wrapper', '__return_false' );

if($context === 'frontend') {
	print('<hr class="divisoria '.$attributes["className"].'" aria-hidden="true">');
} else {
	print('<hr class="divisoria '.$attributes["className"].'" aria-hidden="true">');
}

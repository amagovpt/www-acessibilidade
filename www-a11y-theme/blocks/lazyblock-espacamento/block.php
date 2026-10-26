<?php
/**
 * Espaçamento template.
 *
 * @var  array  $attributes Block attributes.
 * @var  array  $block Block data.
 * @var  string $context Preview context [editor,frontend].
 */

if($context === 'frontend') {
	// disable block frontend wrapper.
	add_filter( $block["slug"].'/frontend_allow_wrapper', '__return_false' );
	echo '<div class="'.$attributes["className"].' clearfix espacamento-ama"> </div>';

} else {
	echo '<div class="'.$attributes["spacing_classes"].' clearfix"></div>';
}

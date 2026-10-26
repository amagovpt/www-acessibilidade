<?php
/**
 * Indicador Template.
 *
 * @var  array  $attributes Block attributes.
 * @var  array  $block Block data.
 * @var  string $context Preview context [editor,frontend].
 */

// disable block frontend wrapper.
add_filter( $block["slug"].'/frontend_allow_wrapper', '__return_false' );

// Adiciona classes ao bloco para aplicar cores de fundo, texto e outras classes persnalizadas.
$classes = [];

// Classes personalizadas
if( !empty($attributes['className']) ) {
	$classes[] = $attributes['className'];
}

// Cor de fundo
if(!empty($attributes['background-color'])) {
	$classes[] = 'has-background';
	$classes[] = 'has-'.$attributes['background-color']['slug'].'-background-color';
}

// Cor de texto
if(!empty($attributes['text-color'])) {
	$classes[] = 'has-text-color';
	$classes[] = 'has-'.$attributes['text-color']['slug'].'-color';
}

// Constroi o bloco
$block_wrapper  = '<div class="wp-block-lazyblock-indicador wp-block-'.$attributes['blockUniqueClass'].' '.implode(" ", $classes).' '.$attributes["className"].'">%s</div>';

$block_body     =
	'<span class="titulo">'.$attributes["titulo"].'</span>
	<span class="corpo">'.$attributes["texto"].'</span>';

if( $context === 'frontend') {
    $block_body = '<span class="titulo">'.$attributes["titulo"].'</span>';
	$block_body .= '<span class="corpo">'.$attributes["texto"].'</span>';
	echo sprintf($block_wrapper, $block_body);
} else {
    $pattern = get_shortcode_regex();
    if(preg_match_all("/$pattern/", $attributes["titulo"], $matches)) {
        $block_body = '<span class="titulo">'.do_shortcode($attributes["titulo"]).'</span>';
    } else {
        $block_body = '<span class="titulo">'.$attributes["titulo"].'</span>';
    }
    $block_body .= '<span class="corpo">'.$attributes["texto"].'</span>';
	echo sprintf($block_wrapper, $block_body);
}

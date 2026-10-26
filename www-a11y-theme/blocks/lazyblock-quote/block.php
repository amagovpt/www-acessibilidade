<?php
/**
 * Quote template.
 *
 * @var  array  $attributes Block attributes.
 * @var  array  $block Block data.
 * @var  string $context Preview context [editor,frontend].
 */

// Adiciona classes ao bloco para aplicar cores de fundo, texto e outras classes personalizadas.
$classes = [];

// Classes personalizadas
if( !empty($attributes['className']) ) {
	$classes[] = $attributes['className'];
}

// Cor de fundo
if(!empty($attributes['quote_background_color'])) {
	$classes[] = 'has-background';
	$classes[] = 'has-'.$attributes['quote_background_color']['slug'].'-background-color';
}

// Cor de texto
if(!empty($attributes['text_color'])) {
	$classes[] = 'has-text-color';
	$classes[] = 'has-'.$attributes['text_color']['slug'].'-color';
}

// Cor da borda
$border_classes = (!empty($attributes["border_color"]["slug"])) ? 'has-background has-'.$attributes["border_color"]["slug"].'-background-color' : '';

// Class que define se o símbolo da quote aparece ou não
$no_quote = $attributes["hide_symbol"] ? " no-quote" : "";

// Remove a div wrapper por defeito dos lazyblocks
add_filter( $block["slug"].'/frontend_allow_wrapper', '__return_false' );

?>
<blockquote class="ama-quote-wrapper wp-block-<?=$attributes["blockUniqueClass"]?> <?= $attributes["className"]?>">
	<div class="ama-quote-border <?= $border_classes; ?>"></div>
	<div class="ama-quote-text-wrapper <?= implode(" ", $classes) ?>">
		<p class="ama-quote-text <?= $no_quote ?>"><?= $attributes["quote"]; ?></p>
		<?php if($attributes["author"] !== ""): ?>
		<span class="ama-quote-author"><?= $attributes["author"] ?></span>
		<?php endif; ?>
	</div>
</blockquote>

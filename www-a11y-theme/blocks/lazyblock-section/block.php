<?php

/**
 * Section tag.
 *
 * @var  array  $attributes Block attributes.
 * @var  array  $block Block data.
 * @var  string $context Preview context [editor,frontend].
 */

// Desabilita o wrapper do bloco
add_filter($block["slug"] . '/frontend_allow_wrapper', '__return_false');

$tag = (!empty($attributes["elemento-html"])) ? $attributes["elemento-html"] : "div";

// ID da section.
$id = '';
if (is_array($attributes) && array_key_exists("anchor", $attributes) && $attributes["anchor"] !== "") {
    $id = ' id="' . $attributes["anchor"] . '"';
}

// Class container (Bootstrap) para a secção
$container_class = '';
if (is_array($attributes) && array_key_exists("largura", $attributes) && $attributes["largura"] !== "") {
    if (is_array($attributes["largura"]) && array_key_exists("value", $attributes["largura"])) {
        $container_class = $attributes["largura"]["value"];
    }
} else {
    $container_class = 'container';
}

// Guarda as classes para a cor de background da section e do texto
$style_classes = [];

// Cor de fundo
if (!empty($attributes['background-color'])) {
    $style_classes[] = 'has-background';
    $style_classes[] = 'has-' . $attributes['background-color']['slug'] . '-background-color';
}

// Cor de texto
if (!empty($attributes['text-color'])) {
    $style_classes[] = 'has-text-color';
    $style_classes[] = 'has-' . $attributes['text-color']['slug'] . '-color';
}

?>
<<?= $tag; ?> <?= $id ?> class="<?= $container_class ?> wp-block-lazyblock-section wp-block-<?= $attributes["blockUniqueClass"] ?> <?= $attributes["className"] ?> <?= implode(" ", $style_classes) ?>">
    <InnerBlocks />
</<?= $tag; ?>>
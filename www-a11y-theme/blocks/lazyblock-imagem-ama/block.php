<?php
/**
 * Lazyblock para imagens.
 *
 * @var  array  $attributes Block attributes.
 * @var  array  $block Block data.
 * @var  string $context Preview context [editor,frontend].
 */

// TODO: Colocar uma condição que verifique se a imagem tem legenda ou não, para somente imprimir o <figure> com a <figcaption>,
// quando é realmente necessario. Caso contrário, imprimir somente a <img> com o atributo alt.


// Adiciona o atributo width na tag <img> conforme o tamanho da imagem selecionado no bloco(defaults do WordPress).
switch ($attributes['tamanho-imagem']['value']) {
    case '150':
        $width = 'width="150"';
        break;
    case '300':
        $width = 'width="300"';
        break;
    case '1024':
        $width = 'width="1024"';
        break;
    default:
        $width = '';
        break;
}

/*
echo '<pre>Largura: '.print_r($attributes["largura"], true).'</pre>';
echo '<pre>Altura: '.print_r($attributes["altura"], true).'</pre>';
*/
// Define a altura da imagem, caso o utilizador a tenha definido.
if($attributes["largura"]) {
    $width = 'width="'.$attributes["largura"].'"';
}

// Define a altura da imagem, caso o utilizador tenha definido.
$height = ($attributes["altura"] > 0) ?'height="'.$attributes["altura"].'"' : '';

$alt = "";
if( array_key_exists('imagem-alt', $attributes) && $attributes['imagem-alt'] !== '') {
    $alt = $attributes['imagem-alt'];
}

#var_dump($attributes);

if( !empty($attributes['ligacao'])): ?>
        <a href="<?= $attributes['ligacao'] ?>">
            <img alt="<?= $alt; ?>" src="<?= $attributes['imagem-ama']['url'] ?>" class="img-fluid <?= $attributes["classe-personalizadas"]?>" <?= $width; ?>>
        </a>
    <?php else: ?>
        <img alt="<?= $alt; ?>" src="<?= $attributes['imagem-ama']['url'] ?>" class="img-fluid <?= $attributes["classe-personalizadas"]?>" <?= $width; ?> <?= $height ?>>
<?php endif; ?>
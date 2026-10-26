<?php
/**
 * Template Ligação.
 *
 * @var  array  $attributes Block attributes.
 * @var  array  $block Block data.
 * @var  string $context Preview context [editor,frontend].
 */


//echo '<pre>'.print_r($attributes, true).'</pre>';

$id = (!empty($attributes["anchor"])) ? 'id="'.$attributes["anchor"].'"' : '' ;

$target = (!empty($attributes["novo-separador"])) ? 'target="'.$attributes["novo-separador"].'"' : '' ;

?>
<span class="icon-arrow-bullets icon" aria-hidden="true"></span>
<a <?= $id ?> class="<?= $attributes["className"] ?>" role="button" href="<?= $attributes["url"] ?>" <?= $target ?>><?= $attributes["texto"] ?></a>

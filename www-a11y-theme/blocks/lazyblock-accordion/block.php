<?php
/**
 * Accordion Template.
 *
 * @var  array  $attributes Block attributes.
 * @var  array  $block Block data.
 * @var  string $context Preview context [editor,frontend].
 */

//var_dump($attributes);
add_filter( $block["slug"].'/frontend_allow_wrapper', '__return_false' );
?>
<div class="accordion wp-block-lazyblock-accordion wp-block-<?=$attributes["blockUniqueClass"]?> <?= $attributes["className"]?>">
	<div class="accordion-item">
		<h2 class="accordion-header">
			<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panel-<?= $attributes["blockId"]?>" aria-expanded="false">
				<?=$attributes["titulo"]?>
			</button>
		</h2>
		<div id="panel-<?= $attributes["blockId"] ?>" class="accordion-collapse collapse">
			<div class="accordion-body">
				<?php //$attributes["conteudo"] ?>
                <InnerBlocks />
			</div>
		</div>
	</div>
</div>

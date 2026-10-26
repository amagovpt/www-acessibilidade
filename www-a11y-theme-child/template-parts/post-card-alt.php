<?php
// Verificar se o post tem imagem em destaque, caso contrário, verificar se tem imagem associada (meta field)
if(has_post_thumbnail(get_the_ID())) {
    $post_thumbnail_id = get_post_thumbnail_id(get_the_ID());
} else {
    $post_thumbnail_id = (get_post_meta(get_the_ID(), "imagem", true)) ? get_post_meta(get_the_ID(), "imagem", true)["ID"] : 0;
}
?>
<a href="<?= get_permalink() ?>" title="<?= the_title(); ?>" class="post-card-wrapper">
    <article class="post-card">
        <div class="post-thumbnail">
            <?= wp_get_attachment_image($post_thumbnail_id, "fullwidth", false, ["class" => "img-fluid"]) ?>
        </div>
            <div class="post-body">
                <h3 class="post-title">
                    <?= the_title(); ?>
                </h3>
                <p class="post-date">
                    <?= the_date(); ?>
                </p>
            </div>
    </article>
</a>

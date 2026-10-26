<div class="post-card-wrapper">
    <article class="post-card">
        <div class="post-thumbnail">
            <img src="<?= get_the_post_thumbnail_url(); ?>" alt="">
        </div>
            <div class="post-body">
                <h3 class="post-title">
                    <a href="<?= get_permalink() ?>"><?= the_title(); ?></a>
                </h3>
                <p class="post-date">
                    <?= the_date(); ?>
                </p>
            </div>
    </article>
</div>

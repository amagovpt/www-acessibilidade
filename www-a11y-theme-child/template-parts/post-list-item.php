<li class="post-item">
    <article>
        <h3 class="h4 mb-4"><a href="<?= get_permalink(get_the_ID()) ?>"><?= get_the_title() ?></a></h3>
        <p class="post-date"><?= get_the_date("d \d\\e F, Y", get_the_ID()) ?></p>
        <p class="mb-4"><?= get_the_excerpt() ?></p>
        <a class="ama btn btn-secondary" href="<?= get_permalink(get_the_ID()) ?>" title="<?= get_the_title() ?>">Ler mais</a>
    </article>
</li>
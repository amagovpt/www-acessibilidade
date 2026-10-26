<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Atualiza as visualizações do artigo
update_post_views(get_the_ID());

wp_enqueue_style(
        'post',
        get_stylesheet_directory_uri() . '/css/single-post.css',
        [],
        '1.0.0'
);

// Categorias e etiquetas do artigo
$categories = get_the_category(get_the_ID());
$categories_id = [];
foreach ($categories as $category) {
    $categories_id[] = $category->term_id;
}

$tags = get_the_tags(get_the_ID());
if($tags == false){
    $tags = [];
}

// Caso o artigo não tenha uma featured image, é atribuída a imagem alternativa
$image = get_post_meta(get_the_ID(), 'imagem', TRUE);

get_header();
?>
<main class="site-main" id="main">
    <div class="wrapper" id="single-wrapper">
        <div class="container" id="content" tabindex="-1">
            <div class="page-header">
                <nav aria-label="Você está aqui">
                    <ol class="breadcrumb mb-5">
                        <li class="breadcrumb-item">
                            <a href="<?= site_url(); ?>">Início</a>
                        </li>
                        <?php
                        // Verifica se é um post e insere o breadcrumb do post pai
                        if(get_post_type(get_queried_object_id()) == 'post') {

                            // ligação da página de blogue
                            $blog_page = get_option('page_for_posts');

                            if(!empty($blog_page)) {
                                echo '<li class="breadcrumb-item">';
                                echo '<a href="'.get_the_permalink($blog_page).'">'.get_the_title($blog_page).'</a>';
                                echo '</li>';
                            } else {
                                echo '<li class="breadcrumb-item">';
                                echo '<a href="'.site_url("blogue").'">Blogue</a>';
                                echo '</li>';
                            }

                            //Verifica se o post tem um post pai
                            if ( has_post_parent() ) {
                                $post_parent_id = wp_get_post_parent_id();
                                echo '<li class="breadcrumb-item">';
                                echo '<a href="' . get_the_permalink($post_parent_id) . '">' . get_the_title($post_parent_id) . '</a>';
                                echo '</li>';
                            }

                        }
                        ?>
                        <li class="breadcrumb-item active" aria-current="page">
                            <?= get_the_title(); ?>
                        </li>
                    </ol>
                </nav>
            </div>
            <article class="page-content">
                <div class="container-fluid px-0">
                    <div class="row gx-5">
                        <div class="col-12 col-lg-8">
                            <a href="<?= site_url("blogue")?>" class="version" title="Consulte todos os artigos no blogue">Blogue</a>
                            <h1 class="mb-2"><?php the_title(); ?></h1>
                            <div class="last-update py-2">
                                <p class="mb-0"><?= get_the_date('j \d\e F, Y'); ?></p>
                            </div>
                            <?php
                            if (has_post_thumbnail()) {
                                echo '<div class="post featured-image">';
                                the_post_thumbnail();
                                echo '</div>';
                            } elseif($image != '') {
                                echo '<div class="post featured-image">';
                                echo '<img alt="'.$image['post_title'].'" src="'.$image['guid'].'">';
                                echo '</div>';
                            }
                            ?>
                            <hr class="my-3 my-lg-5">
                            <?php the_content(); ?>
                        </div>
                        <aside class="col-12 col-md-4">
                            <div class="sidebar p-4 p-lg-5">
                                <h2>Relacionados</h2>
                                <?php get_related_articles($categories_id, get_the_ID()) ?>
                                <hr>
                                <h2 class="h3">Em destaque</h2>
                                <?php get_articles_highlights() ?>
                                <hr>
                                <h3 class="h5">Categorias</h3>
                                <?= do_shortcode('[get_blogue_categories]'); ?>
                            </div>
                        </aside>
                    </div>
                    <?php
                    // Categorias do artigo
                    if(
                        (is_countable($categories) && count($categories) > 0) ||
                        (is_countable($tags) && count($tags) > 0)
                    ) {
                        echo '<div class="row mt-3 mt-lg-5">';
                        if(is_countable($categories) && count($categories) > 0) {

                            echo '<div class="col-12">';
                            echo '<h2 class="h5">Categorias</h2>';
                            echo '<ul class="list-unstyled list-inline">';
                            foreach ($categories as $category) {
                                echo '<li class="list-inline-item"><a href="'.get_category_link($category->term_id).'">'.$category->name.'</a></li>';
                            }
                            echo '</ul>';
                            echo '</div>';
                        }

                        // Etiquetas do artigo
                        if(is_countable($tags) && count($tags) > 0) {
                            echo '<div class="col-12 mt-3">';
                            echo '<h2 class="h5">Etiquetas</h2>';
                            echo '<ul class="list-unstyled list-inline">';
                            foreach ($tags as $tag) {
                                echo '<li class="list-inline-item"><a href="'.get_category_link($tag->term_id).'">'.$tag->name.'</a></li>';
                            }
                            echo '</ul>';
                            echo '</div>';
                        }
                        echo '</div>';
                    }
                    ?>
                </div>
            </article>
            <div class="page-footer">
                <div class="d-flex justify-content-between">
                    <?= do_shortcode('[partilhar-redes-sociais]'); ?>
                    <div class="last-update py-2">
                        <p class="mb-0">Última atualização a <?= get_the_modified_date('j \d\e F, Y'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php

    $previous = get_previous_post();
    $next = get_next_post();
    ?>
    <div class="container">
        <hr>
        <div class="row">
            <div class="col post-navigation">
                <?php
                if($previous){ ?>
                    <div class="artigo-anterior">
                        <div>Artigo anterior</div>
                        <a href="<?= get_permalink($previous->ID) ?>"><?= $previous->post_title?></a>
                    </div>
                <?php } ?>
                <?php
                if($previous){ ?>
                    <div class="artigo-seguinte">
                        <div>Artigo seguinte</div>
                        <a href="<?= get_permalink($next->ID) ?>"><?= $next->post_title?></a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <section class="container wp-block-lazyblock-section wp-block-lazyblock-section-1XtwDJ mt-3">
        <div class="lazyblock-inner-blocks">
            <div class="wp-block-columns border border-5 border-black p-5 is-layout-flex wp-container-core-columns-is-layout-10 wp-block-columns-is-layout-flex">
                <div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:70%">
                    <h2 class="wp-block-heading">Acessibilidade Web</h2>
                    <p>Na&nbsp;UE&nbsp;o&nbsp;<em>standard</em>&nbsp;que contém os requisitos de acessibilidade aplicado à Web e às aplicações móveis é a Norma EN301549. Ela não é mais do que uma cópia do&nbsp;<em>standard</em>&nbsp;WCAG 2.1&nbsp;conformidade ‘AA’. Em Portugal esses requisitos constam do&nbsp;RNID&nbsp;conforme decretado pelo DL n.º 83/2018.</p>
                    <ul class="wp-block-list ama-list gap-1-5 d-block d-md-flex">
                        <li><a href="https://www.acessibilidade.gov.pt/blogue/categoria-acessibilidade/dl-n-o-83-2018-acessibilidade-dos-sitios-web-e-das-aplicacoes-moveis/">DL nº. 83/2018</a></li>
                        <li><a href="https://www.w3.org/TR/WCAG21/">WCAG 2.1 standard W3C</a></li>
                        <li><a href="https://www.acessibilidade.gov.pt/blogue/categoria-normas/microsoft-publica-videos-sobre-a-norma-europeia-de-acessibilidade-as-tic/">Norma Europeia EN 301549</a></li>
                    </ul>
                </div>
                <div class="wp-block-column  d-flex justify-content-end is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:30%">
                    <div class="lazyblock-imagem-ama-1ywMn0 wp-block-lazyblock-imagem-ama">
                        <img decoding="async" alt="" src="/wp-content/uploads/2024/05/AMA-Chat.svg" class="img-fluid img-fluid" width="150">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="container-fluid p-0 mt-3">
        <div class="row p-0">
            <div class="col p-0">
                <?= do_shortcode('[accessmonitor_wide]'); ?>
            </div>
        </div>
    </div>
</main>
<?php
get_footer();
<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

wp_enqueue_style(
    "fulld-width",
    get_stylesheet_directory_uri() . "/css/full-width.css",
    "",
    "1.0.0",
);

wp_enqueue_script(
    "AccessMonitor",
    get_stylesheet_directory_uri() . "/js/AccessMonitor.js",
    ["jquery"],
    "1.0.0",
    "defer"
);

get_header();
?>
<main class="site-main publicao" id="main">
    <div class="wrapper" id="page-wrapper">
        <div class="container-fluid p-0" id="content" tabindex="-1">
            <div class="container">
                <div class="row">
                    <div class="page-header col">
                        <nav aria-label="Você está aqui">
                            <ol class="breadcrumb mb-5">
                                <li class="breadcrumb-item">
                                    <a href="<?= site_url(); ?>">Início</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="<?= site_url("publicacoes") ?>">Publicações</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <?= the_title(); ?>
                                </li>
                            </ol>
                        </nav>
                        <div class="row">
                            <div class="col-12 mb-3">
                                <a href="<?= site_url("publicacoes")?>" class="version" title="Consulte todos os artigos classificados nesta categoria">Publicações</a>
                            </div>
                            <div class="col-12 col-lg-8<?php echo has_excerpt() ? '' : ' align-self-end'; ?>">
                                <h1><?php the_title(); ?></h1>
                                <?php
                                if ( has_excerpt() ) : ?>
                                    <div class="excerpt">
                                        <?php the_excerpt(); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="d-none d-lg-flex col-lg-4 d-flex justify-content-center featured-image">
                                <div class="featured-image">
                                    <?php
                                        // Verifica se a Publicação tem feature image ou se aplica o ACF do icon de destaque (HTML)
                                        if(has_post_thumbnail()) {
                                            the_post_thumbnail();
                                        } elseif(get_field('ama_icon_destaque')) {
                                            echo get_field('ama_icon_destaque');
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-content">
                <div class="container">
                    <div class="row g-5">
                        <div class="col-12">
                            <?php the_content(); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container mt-5">
                <div class="row">
                    <div class="page-footer col">
                        <div class="d-flex justify-content-between">
                            <?= do_shortcode('[partilhar-redes-sociais]'); ?>
                            <div class="last-update py-2">
                                <p class="mb-0">Última atualização: <?php echo get_the_modified_date('j \d\e F, Y'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col">
                <?= do_shortcode('[accessmonitor_wide]'); ?>
            </div>
        </div>
    </div>
</main>
<?php
get_footer();
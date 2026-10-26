<?php
/**
 * Template name: Página full width
 */
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
<main class="site-main" id="main">
    <div class="wrapper" id="page-wrapper">
        <div class="container-fluid p-0" id="content" tabindex="-1">
            <div class="container">
                <div class="row">
                    <div class="page-header col">
                        <nav aria-label="Você está aqui">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="<?php echo site_url(); ?>">Início</a>
                                </li>
                                <?php if ( has_post_parent() ) : ?>
                                    <?php $post_parent_id = wp_get_post_parent_id(); ?>
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo get_the_permalink( $post_parent_id ); ?>"><?php echo get_the_title( $post_parent_id ); ?></a>
                                    </li>
                                <?php endif; ?>
                                <li class="breadcrumb-item active" aria-current="page">
                                    <?php echo the_title(); ?>
                                </li>
                            </ol>
                        </nav>
                        <div class="row">
                            <div class="col-12 col-lg-8<?php echo has_excerpt() ? '' : ' align-self-end'; ?>">
                                <h1><?php the_title(); ?></h1>
                                <?php
                                if ( has_excerpt() ) : ?>
                                    <div class="excerpt">
                                        <?php the_excerpt(); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <?php
                            if ( has_post_thumbnail() ) : ?>
                                <div class="d-none d-lg-flex col-lg-4 d-flex justify-content-center featured-image">
                                    <div class="featured-image">
                                        <?php the_post_thumbnail(); ?>
                                    </div>
                                </div>
                            <?php elseif(get_field('ama_icon_destaque')): ?>
                                <div class="d-none d-lg-flex col-lg-4 d-flex justify-content-center featured-image">
                                    <div class="featured-image">
                                        <?= get_field('ama_icon_destaque'); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-content">
                <?php the_content(); ?>
            </div>
            <div class="container">
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
    <?= do_shortcode('[accessmonitor_wide]'); ?>
</main>
<?php
get_footer();
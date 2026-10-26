<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

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
        <div class="container" id="content" tabindex="-1">
            <div class="page-header">
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
                        // verificar se o get_field('descricao_pagina') existe, senão, usa o the_excerpt()
                        if(get_field('descricao_pagina')):
                            echo get_field('descricao_pagina');
                        else:
                            echo the_excerpt();
                        endif;
                        ?>
                    </div>
                    <?php
                    if ( has_post_thumbnail() ) : ?>
                    <div class="d-none d-lg-flex col-lg-4 d-flex justify-content-center featured-image">
                        <div class="featured-image">
                            <?php
                            var_dump(get_field('ama_icon_destaque'));
                                if(has_post_thumbnail()) {
                                    the_post_thumbnail();
                                } elseif(get_field('ama_icon_destaque')) {
                                    echo get_field('ama_icon_destaque');
                                }
                            ?>
                        </div>
                    </div>
                    <?php else : ?>
                        <div class="d-none d-lg-flex col-lg-4 d-flex justify-content-center featured-image">
                            <div class="featured-image">
                                <?= get_field("ama_icon_destaque") ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="page-content">
                <?php the_content(); ?>
            </div>
            <div class="page-footer">
                <div class="d-flex justify-content-between">
                    <?= do_shortcode('[partilhar-redes-sociais]'); ?>
                    <div class="last-update py-2">
                        <p class="mb-0">Última atualização: <?php echo get_the_modified_date('j \d\e F, Y'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid p-0">
        <div class="row p-0">
            <div class="col p-0">
                <?= do_shortcode('[accessmonitor_wide]'); ?>
            </div>
        </div>
    </div>
</main>
<?php
get_footer();
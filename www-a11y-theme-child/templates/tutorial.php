<?php
/**
 * Páginas dos tutoriais (apresentação e páginas do tutorial).
 * Aplicado automaticamente pelo filtro ama_tutorial_template() em inc/tutoriais.php.
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

$current_id  = get_queried_object_id();
$tutorial_id = ama_tutorial_id( $current_id );
$is_intro    = $current_id === $tutorial_id;
?>
<main class="site-main" id="main">
    <div class="wrapper" id="page-wrapper">
        <div class="container" id="content" tabindex="-1">
            <?php while ( have_posts() ) : the_post(); ?>
                <?php // O mesmo cabeçalho das páginas Tutoriais/Publicações e das fichas (page.php), como no modelo original. ?>
                <div class="page-header page-header--seccao">
                    <nav aria-label="Você está aqui">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="<?= esc_url( home_url( '/' ) ); ?>">Início</a>
                            </li>
                            <?php foreach ( array_reverse( get_post_ancestors( $current_id ) ) as $ancestor_id ) : ?>
                                <li class="breadcrumb-item">
                                    <a href="<?= esc_url( get_permalink( $ancestor_id ) ); ?>"><?= esc_html( get_the_title( $ancestor_id ) ); ?></a>
                                </li>
                            <?php endforeach; ?>
                            <li class="breadcrumb-item active" aria-current="page"><?= esc_html( get_the_title( $current_id ) ); ?></li>
                        </ol>
                    </nav>
                    <div class="row">
                        <?php // Etiqueta da secção, como nos tutoriais antigos (issue #29). ?>
                        <div class="col-12 page-header-label">
                            <a href="<?= esc_url( get_permalink( ama_tutoriais_root_id() ) ); ?>" class="version">Tutoriais</a>
                        </div>
                        <div class="col-12 col-lg-8 tutorial-header-text">
                            <h1><?php the_title(); ?></h1>
                            <?php
                            // A mesma ordem do page.php: descrição da página e, se não houver, o excerto.
                            if ( get_field( 'descricao_pagina' ) ) :
                                echo get_field( 'descricao_pagina' );
                            elseif ( has_excerpt() ) :
                                the_excerpt();
                            endif;
                            ?>
                        </div>
                        <?php if ( has_post_thumbnail() || get_field( 'ama_icon_destaque' ) ) : ?>
                            <div class="d-none d-lg-flex col-lg-4 justify-content-center featured-image">
                                <div class="featured-image">
                                    <?php
                                    if ( has_post_thumbnail() ) {
                                        the_post_thumbnail();
                                    } else {
                                        echo get_field( 'ama_icon_destaque' );
                                    }
                                    ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="tutorial-layout<?= $is_intro ? ' tutorial-layout--intro' : ''; ?>">
                    <?php // Na apresentação o índice das páginas já está no corpo ("Conteúdo do tutorial"), como no Lab (issue #30). ?>
                    <?= $is_intro ? '' : ama_tutorial_nav( $tutorial_id, $current_id ); ?>

                    <?= $is_intro ? '' : ama_tutorial_toc( $current_id ); ?>

                    <div class="tutorial-content">
                        <?= $is_intro ? ama_tutorial_intro( $tutorial_id ) : ''; ?>

                        <?php the_content(); ?>

                        <?= ama_tutorial_pagination( $tutorial_id, $current_id ); ?>
                    </div>
                </div>

                <?php // Partilha e data no fim da página, alinhada à direita, como no page.php. ?>
                <div class="page-footer">
                    <div class="d-flex justify-content-between">
                        <?= do_shortcode( '[partilhar-redes-sociais]' ); ?>
                        <div class="last-update py-2">
                            <p class="mb-0">Última atualização: <?= esc_html( get_the_modified_date( 'j \d\e F, Y' ) ); ?></p>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</main>
<?php
get_footer();

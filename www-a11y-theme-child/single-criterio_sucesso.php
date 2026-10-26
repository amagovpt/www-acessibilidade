<?php

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Critério de sucesso CSS
wp_enqueue_style(
    "criterio-sucesso",
    get_stylesheet_directory_uri()."/mapa-acessibilidade/assets/css/criterio-sucesso.css",
    "",
    "1.0.0"
);

// Site header
get_header();
?>
    <div class="wrapper" id="single-wrapper">
        <div class="container" id="content" tabindex="-1">
            <main class="site-main" id="main">
                <div class="page-header criterio-sucesso">
                    <nav aria-label="Você está aqui">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="<?= site_url() ?>">Início</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="<?= site_url() ?>/mapa-acessibilidade-digital">Mapa da Acessibilidade Digital</a>
                            <li class="breadcrumb-item active" aria-current="page">
                                <?= the_title() ?>
                                <?php has_current_success_criteria("principio_diretriz", 31); ?>
                            </li>
                        </ol>
                    </nav>
                </div>

                <div class="page-content">
                    <div class="row gx-5">
                        <!-- Sidebar -->
                        <div class="col-md-6 col-lg-4 mb-5">
                            <div class="menu-lateral">
                                <div class="titulo d-flex flex-row justify-content-between">
                                    <h2 class="h5">WCAG 2 Consulta rápida</h2>
                                    <?php // echo '<div class="icon icon-content-menu-left"></div>'; ?>
                                </div>
                                <div class="resultados">
                                    <?= criterios_nav( "principio_diretriz"); ?>
                                </div>
                            </div>
                        </div>
                        <!-- Content area -->
                        <div class="col-md-12 col-lg-8">
                            <span class="badge bg-ama mb-3">WCAG 2 Consulta rápida</span>
                            <h1><?php the_title(); ?></h1>
                            <?php
                            if ( has_post_thumbnail() ) : ?>
                                <div class="d-none d-lg-flex col-lg-4 d-flex justify-content-center featured-image">
                                    <div class="featured-image">
                                        <?php the_post_thumbnail(); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php the_content(); ?>
                            <!-- content tabs -->
                            <ul class="nav nav-tabs flex-column flex-lg-row" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="criterio_sucesso_descricao-tab"
                                            data-bs-toggle="tab" data-bs-target="#criterio_sucesso_descricao-pane" type="button"
                                            role="tab" aria-controls="criterio_sucesso_descricao-pane" aria-selected="true">
                                        <?= get_tab_label("field_66967181939d0"); ?>
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="criterio_sucesso_tecnicas_suficientes-tab"
                                            data-bs-toggle="tab" data-bs-target="#criterio_sucesso_tecnicas_suficientes-pane" type="button"
                                            role="tab" aria-controls="criterio_sucesso_tecnicas_suficientes-pane" aria-selected="false">
                                        <?= get_tab_label("field_6696724e939d1"); ?>
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="criterio_sucesso_tecnicas_de_consultoria-tab"
                                            data-bs-toggle="tab" data-bs-target="#criterio_sucesso_tecnicas_de_consultoria-pane" type="button"
                                            role="tab" aria-controls="criterio_sucesso_tecnicas_de_consultoria-pane" aria-selected="false">
                                        <?= get_tab_label("field_66967265939d2"); ?>
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="criterio_sucesso_falhas-tab"
                                            data-bs-toggle="tab" data-bs-target="#criterio_sucesso_falhas-pane" type="button"
                                            role="tab" aria-controls="criterio_sucesso_falhas-pane" aria-selected="false">
                                        <?= get_tab_label("field_6696727f939d3"); ?>
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="notas-tab"
                                            data-bs-toggle="tab" data-bs-target="#notas-pane" type="button"
                                            role="tab" aria-controls="notas-pane" aria-selected="false">
                                        <?= get_tab_label("notas"); ?>
                                    </button>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="criterio_sucesso_descricao-pane"
                                     role="tabpanel" aria-labelledby="criterio_sucesso_descricao-tab" tabindex="0">
                                    <?= get_field("criterio_sucesso_descricao", get_the_ID() ); ?>
                                </div>
                                <div class="tab-pane fade" id="criterio_sucesso_tecnicas_suficientes-pane"
                                     role="tabpanel" aria-labelledby="criterio_sucesso_tecnicas_suficientes-tab" tabindex="0">
                                    <?= get_field("criterio_sucesso_tecnicas_suficientes", get_the_ID() ); ?>
                                </div>
                                <div class="tab-pane fade" id="criterio_sucesso_tecnicas_de_consultoria-pane"
                                     role="tabpanel" aria-labelledby="criterio_sucesso_tecnicas_de_consultoria-tab" tabindex="0">
                                    <?= get_field("criterio_sucesso_tecnicas_de_consultoria", get_the_ID() ); ?>
                                </div>
                                <div class="tab-pane fade" id="criterio_sucesso_falhas-pane"
                                     role="tabpanel" aria-labelledby="criterio_sucesso_falhas-tab" tabindex="0">
                                    <?= get_field("criterio_sucesso_falhas", get_the_ID() ); ?>
                                </div>
                                <div class="tab-pane fade" id="notas-pane"
                                     role="tabpanel" aria-labelledby="notas-tab" tabindex="0">
                                    <?= get_field("notas", get_the_ID() ); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-footer my-5">
                    <div class="d-flex justify-content-between">
                        <?= do_shortcode('[partilhar-redes-sociais]'); ?>
                        <div class="last-update py-2">
                            <p class="mb-0">Última atualização: 21 de Junho, 2024</p>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <?= do_shortcode('[accessmonitor_wide]'); ?>
    </div>
<?php

// Site footer
get_footer();
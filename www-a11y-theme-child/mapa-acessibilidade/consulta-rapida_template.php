<?php
/**
 * Template Name: Consulta Rápida WCAG 2
 */

wp_enqueue_style(
    "consulta-rapida",
	get_stylesheet_directory_uri()."/mapa-acessibilidade/assets/css/consulta-rapida.css",
    "",
    "1.0.0"
);

wp_enqueue_script(
    "consulta-rapida",
	get_stylesheet_directory_uri()."/mapa-acessibilidade/assets/js/consulta-rapida.js",
    ["jquery"],
    "1.0.0"
);

// Lista de filtros a incluir
$filters = ["nivel", "versao", ""];

get_header(); ?>
    <div class="wrapper pb-0" id="page-wrapper">
		<div class="container-fluid px-0" id="content" tabindex="-1">
			<main class="site-main" id="main">
                <div class="container">
                <div class="page-header">
                    <div class="container">
                    <nav aria-label="Você está aqui">
						<ol class="breadcrumb">
							<li class="breadcrumb-item">
								<a href="<?= site_url(); ?>">Início</a>
							</li>
							<?php if ( has_post_parent() ) : ?>
								<?php $post_parent_id = wp_get_post_parent_id(); ?>
								<li class="breadcrumb-item">
									<a href="<?= get_the_permalink( $post_parent_id ); ?>">
										<?= get_the_title( $post_parent_id ); ?>
									</a>
								</li>
							<?php endif; ?>
							<li class="breadcrumb-item active" aria-current="page">
								<?= the_title(); ?>
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
						<?php endif; ?>
					</div>
                    </div>
					
				</div>
                </div>
				
				<div class="page-content">
					<?php the_content(); ?>
				</div>

                <!-- Filtros -->
                <div class="container mb-5">
                    <div class="row">
                        <div class="col d-flex flex-row justify-content-start flex-wrap">
                            <form id="wcag-form" class="" action="<?= site_url().'/wp-json/acessibilidade/v1/mapa' ?>" method="GET" >
                                <div class="lista-filtros">
	                                <?php

                                    // Mostra as taxonomies (pré-selecionadas)
                                    foreach ( ["nivel", "versao", "declaracao_de_desempenho"] as $taxonomy ) {
                                        echo print_taxonomy_filters( $taxonomy );
                                    }

	                                ?>
                                    <div class="filtro-item">
                                        <fieldset class="wcag-filtros-wrapper">
                                            <legend class="filtros-label">Exibição</legend>
                                            <div class="filtros-resultados">
                                                <?php

                                                // Verifica que os valores de exibição foram enviados para pré-selecioná-los
                                                $exibicao = [];
                                                if( !empty( $_GET ) && array_key_exists( "exibicao", $_GET ) )  {
                                                    $exibicao = $_GET["exibicao"];
                                                }

                                                ?>
                                                <div class="form-check">
                                                    <input name="exibicao[]" class="form-check-input" type="checkbox" value="1"
                                                           id="exibicao-1" <?= ( ( in_array("1", $exibicao) ) ? "checked" : "" ) ?>>
                                                    <label class="form-check-label" for="exibicao-1">Descrições</label>
                                                </div>
                                                <div class="form-check">
                                                    <input name="exibicao[]" class="form-check-input" type="checkbox" value="2"
                                                           id="exibicao-2" <?= ( ( in_array("2", $exibicao) ) ? "checked" : "" ) ?>>
                                                    <label class="form-check-label" for="exibicao-2">Destaques 2.2 SC</label>
                                                </div>
                                                <div class="form-check">
                                                    <input name="exibicao[]" class="form-check-input" type="checkbox" value="3"
                                                           id="exibicao-3" <?= ( ( in_array("3", $exibicao) ) ? "checked" : "" ) ?>>
                                                    <label class="form-check-label" for="exibicao-3">Destacar ligações</label>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>

                                    <?php
                                        $search_filter = "";
                                        if( !empty( $_GET["search"] ) ) {
                                            $search_filter = $_GET["search"];
                                        }
                                    ?>
                                    <div class="filtro-item col-lg-4">
                                        <div class="wcag-filtros-wrapper search">
                                            <div class="filtros-resultados nowrap">
                                                <label class="form-label no-shrink mb-0" for="filtro-search">Pesquisar por: </label>
                                                <input type="text" class="form-control form-control-sm my-0"
                                                       id="filtro-search" name="search" value="<?= $search_filter ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="acoes-filtros">
                                    <button type="submit" class="ama btn btn-primary">Filtrar</button>
                                    <button type="reset" class="btn_reset">Limpar filtros</button>
                                    <div id="consulta-rapida-loading"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php
                // Retorna todos os Princípios, Diretrizes e Critérios de sucesso
                
                $response       = wp_remote_get(site_url().'/wp-json/acessibilidade/v1/mapa');

                $response_body = false;
                if( is_array($response) ) {
                    $response_body = json_decode($response['body']);
                }
                
                ?>
                <div  class="container py-5">
                    <div class="row mb-4">
                        <div class="col" >
                            <?php
                            if($response_body && $response_body->status ==='success') {
                                echo '<h2>Resultados</h2>';
                            }
                            ?>
                            <p id="numero-resultados">
                                <?php

                                if($response_body && $response_body->status ==='success') {
                                    echo $response_body->number_results;
                                }

                                ?>
                            </p>
                        </div>
                    </div>
                    <div id="principios-diretrizes" class="row g-5">
						<?php

                        if($response_body && $response_body->status ==='success') {

                            echo '<div class="col-12">'.$response_body->html.'</div>';
                        } else {
                            echo '<div class="col-12"><p>Não foram encontrados resultados.</p></div>';
                        }

                        ?>
                    </div>
                </div>

				<div class="page-footer">
					<div class="container d-flex justify-content-between">
						<div class="share-post">
							<h2>Partilhar</h2>
							<ul class="d-flex list-inline mb-0">
								<li>
									<button id="fb-icon" type="button" aria-label="Partilhar no Facebook" >
										<span class="icon-share-facebook" aria-hidden="true"></span>
									</button>
								</li>
								<li>
									<button id="tw-icon" type="button" aria-label="Partilhar no Twitter">
										<span class="icon-share-twitter" aria-hidden="true"></span>
									</button>
								</li>
								<li>
									<button id="ld-icon" type="button" aria-label="Partilhar no Linkedin">
										<span class="icon-share-linkedin" aria-hidden="true"></span>
									</button>
								</li>
							</ul>
						</div>
						<div class="last-update py-2">
							<p class="mb-0">Última atualização: <?php echo get_the_modified_date('j \d\e F, Y'); ?></p>
						</div>
					</div>
                    <?= do_shortcode('[accessmonitor_wide]'); ?>
				</div>
			</main>
		</div>
	</div>
<?php
get_footer();
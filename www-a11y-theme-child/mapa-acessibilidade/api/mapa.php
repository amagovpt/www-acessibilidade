<?php

// Registo do endpoint
add_action('rest_api_init', function () {
	register_rest_route('acessibilidade/v1', '/mapa',
		array(
		'methods'               => 'GET',
		'callback'              => 'mapa_acessibilidade_endpoint_handler',
		'permission_callback'   => '__return_true'
	));
});

/**
 * Devolve os Princípios, Diretrizes e Critérios de sucesso em HTML e filtrados.
 *
 * @return array|null
 */
function mapa_acessibilidade_endpoint_handler(): ?array
{
	$response = [
		'status'         => 'error',
		'html'           => '',
		'form_params'    => $_GET,
		'number_results' => ''
	];

	// Contém todos os resultados da consulta de princípios, diretrizes e criterios de sucesso
	$html = '';

	// Contem todos os resultados da consulta de critérios de sucesso.
	$cs_query = '';

	$taxonomy = get_taxonomy( "principio_diretriz" );

	$principios = get_terms([
		"taxonomy"      => $taxonomy->name,
		"orderby"       => "name",
		"order"         => "ASC",
		"parent"        => 0,
		"hide_empty"    => false // important index!
	]);


	$query_results = [];

	// Cria os 4 Principios da acessibilidade
	if( is_countable( $principios ) && count( $principios ) > 0 ) {
		foreach ( $principios as $p ) {
			$print_description = "";

			if( !empty( $_GET ) && array_key_exists( "exibicao", $_GET ) ) {
				if( is_array( $_GET["exibicao"] ) ) {
					if( in_array( "1", $_GET["exibicao"] ) ) {
						$print_description = '<p class="descricao">' . $p->description . '</p>';
					}
				}
			}

			$column =
				'<li>
                    <h3 class="principio">'. $p->name . '</h3>
                    ' . $print_description . '
                    %s
                </li>';

			$diretrizes = '';
			$diretriz   = get_terms([
				"taxonomy"      => $taxonomy->name,
				"orderby"       => "name",
				"order"         => "ASC",
				"parent"        => $p->term_taxonomy_id,
				"hide_empty"    => false // important index!
			]);

			if( is_countable( $diretriz ) && count( $diretriz ) > 0 ) {
				foreach ( $diretriz as $d ) {
					$diretriz_descricao = "";
					if( !empty( $_GET ) && array_key_exists( "exibicao", $_GET ) ) {
						if( is_array( $_GET["exibicao"] ) ) {
							if( in_array( "1", $_GET["exibicao"] ) ) {
								$diretriz_descricao = '<p class="descricao">' . $d->description . '</p>';
							}
						}
					}
					$diretrizes .=
						'<h4 class="diretriz">'. $d->name . '</h4>' . $diretriz_descricao;

					$criterios_sucesso = '';

					// Condições da pesquisa de critérios de sucesso
					$search_query = [
						"post_type"     => "criterio_sucesso",
						"posts_per_page"=> -1,
						"orderby"       => "post_title",
						"order"         => "ASC",
						"tax_query"     => [
							"relation"  => "AND",
							[
								"taxonomy"  => $taxonomy->name,
								"field"     => "slug",
								"terms"     => $d->slug
							]
						]
					];

					// Filtra por texto
					if( isset( $_GET ) && array_key_exists( "search", $_GET ) ) {
						$search_query["s"] = sanitize_text_field( $_GET["search"] );
					}

					// Verifica se o formulário para filtrar foi enviado e adiciona os filtros à pesquisa de posts
					$filterable_taxonomies = ["nivel", "versao"];
					foreach ( $filterable_taxonomies as $taxon ) {
						if( isset( $_GET ) ) {
							if( array_key_exists($taxon, $_GET) && $_GET[$taxon] ) {
								if( is_array( $_GET[$taxon] ) ) {
									$search_query["tax_query"][] = [
										"taxonomy"  => $taxon,
										"field"     => "id",
										"terms"     => $_GET[$taxon] // Aceita arrays
									];
								}
							}
						}
					}

					$cs_query = new WP_Query( $search_query );

					//Junta todos os resultados numa variavel para medir o nº total de resultados
					foreach ($cs_query->posts as $post) {
						$query_results[] = [
								"id" => $post->ID,
								"title" => $post->post_title
							];
					}

					$response['query_results'] = $query_results;

					// Mostra/esconde o icon para destacar ligações
					$link_icon = '';
					if( !empty( $_GET ) && array_key_exists("exibicao", $_GET ) && in_array( "3", $_GET["exibicao"] ) ) {
						$link_icon = '<div class="icon icon-info ms-2"></div>';
					}

					if( is_countable( $cs_query->posts ) && count( $cs_query->posts )>0 ) {
						$natural_order = [];
						foreach( $cs_query->posts as $criterio ) {
							$natural_order[] = ["titulo" => $criterio->post_title, "url" => get_permalink($criterio->ID)];
						}

						// Use the usort function to sort the array by the 'age' key
						usort($natural_order, 'natural_order');

						foreach ( $natural_order as $criterio ) {
							$criterios_sucesso .= '<li><a href="'.$criterio["url"].'" class="criterio-sucesso ">'.$criterio["titulo"].$link_icon.'</a></li>';
						}
					} else {
						$criterios_sucesso = '<p class="descricao">Sem resultados para a pesquisa com os critérios atuais.</p>';
					}

					// Concatena os critérios de sucesso às diretrizes para imprimir o HTML posteriormente
					$diretrizes .= sprintf('<ul class="list-unstyled">%s</ul>', $criterios_sucesso);
				}
			}

			$html .=  sprintf( $column, $diretrizes );
		} // foreach
	}


	$response['status'] = 'success';
	$response['number_results'] = (is_countable($query_results) && count($query_results)>0)? 'A mostrar '.count($query_results).' critério(s) de sucesso.' : 'Sem resultados para mostrar.' ;
	$response['html'] = sprintf('<ul class="list-unstyled grid grid-4">%s</ul>', $html);

	return $response;
}
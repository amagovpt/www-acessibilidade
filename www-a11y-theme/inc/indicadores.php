<?php
/**
 *
 * @param   $args
 *
 * @return  string|null
 */
function ama_indicadores_cb( $args ): ?string {
	// Shortcode attributes
	$opt = shortcode_atts(
		[
			'title'     => 'Selos de usabilidade e acessibilidade em números',
			'link_text' => 'Consulte dados do observatório',
			'link_url'  => '#',
			'indicador' => '31;17;14',
			'descricao' => 'Sítios web com Selo de Usabilidade;Sítios Web com Selo de Usablidade Prata;Sítios Web com Selo de Usablidade Ouro'
		],
		$args
	);

	$title = explode(';', $opt['indicador'] );
	$desc  = explode(';', $opt['descricao'] );

	$output =
		'<div class="container p-0">
	<div class="row mb-5">
		<div class="col-lg-8 d-flex flex-row justify-content-start">
			<h1>'.$opt['title'].'</h1>
		</div>
		<div class="col-lg-4 d-flex flex-row justify-content-lg-end justify-content-start">
			<a href="'.$opt['link_url'].'">'.$opt['link_text'].'</a>
		</div>
	</div>
	<div class="ama-grid">
		<div class="item">
			<h3 class="item-title">'.$title[0].'</h3>
			<p class="item-description">'.$desc[0].'</p>
		</div>
		<div class="item">
			<h3 class="item-title">'.$title[1].'</h3>
			<p class="item-description">'.$desc[1].'</p>
		</div>
		<div class="item">
			<h3 class="item-title">'.$title[2].'</h3>
			<p class="item-description">'.$desc[2].'</p>
		</div>
	</div>
</div>';

	// File dependencies
	wp_enqueue_style(
		'indicadores',
		get_stylesheet_directory_uri().'/css/indicadores.css',
		'',
		'1.0.1'
	);

	return $output;
}

add_shortcode( 'ama-indicadores', 'ama_indicadores_cb' );

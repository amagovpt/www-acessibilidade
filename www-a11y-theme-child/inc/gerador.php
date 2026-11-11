<?php
/**
 * Gerador da Declaração de Acessibilidade e Usabilidade como página WordPress.
 *
 * Antes, o gerador era uma pasta /gerador à parte (amagovpt/a11y-da) com cabeçalho,
 * rodapé e CSS do tema antigo "acessibilidade". Agora:
 * - templates gerador.php (PT) e gerador-en.php (EN) usam o cabeçalho e o rodapé do tema;
 * - o formulário está em template-parts/gerador/formulario-{pt,en}.php;
 * - CSS, JS e fontes próprios do gerador estão em gerador/ e só são carregados nessas páginas.
 *
 * A declaração continua a poder ser carregada por URL através da API em Cloudflare
 * (gerador-api.getstatement.workers.dev), chamada pelo generator.js.
 */

defined( 'ABSPATH' ) || exit;

/**
 * Língua do gerador na página atual: 'pt', 'en' ou '' se não for uma página do gerador.
 */
function ama_gerador_lingua( $post_id = null ) {
	$template = get_page_template_slug( $post_id ? $post_id : get_queried_object_id() );

	if ( 'gerador.php' === $template ) {
		return 'pt';
	}
	if ( 'gerador-en.php' === $template ) {
		return 'en';
	}
	return '';
}

/**
 * Página do gerador na outra língua: a EN é filha da PT.
 */
function ama_gerador_pagina_par( $post_id ) {
	$lingua = ama_gerador_lingua( $post_id );

	if ( 'en' === $lingua ) {
		$pai = wp_get_post_parent_id( $post_id );
		return ( $pai && 'pt' === ama_gerador_lingua( $pai ) ) ? $pai : 0;
	}

	if ( 'pt' === $lingua ) {
		$filhas = get_posts(
			array(
				'post_type'      => 'page',
				'post_parent'    => $post_id,
				'post_status'    => 'publish',
				'posts_per_page' => 1,
				'fields'         => 'ids',
				'meta_key'       => '_wp_page_template',
				'meta_value'     => 'gerador-en.php',
			)
		);
		return $filhas ? (int) $filhas[0] : 0;
	}

	return 0;
}

/**
 * CSS e JS do gerador, só nas páginas do gerador.
 */
function ama_gerador_assets() {
	$lingua = is_page() ? ama_gerador_lingua() : '';
	if ( ! $lingua ) {
		return;
	}

	$dir = get_stylesheet_directory() . '/gerador';
	$uri = get_stylesheet_directory_uri() . '/gerador';
	$ver = function ( $ficheiro ) use ( $dir ) {
		return file_exists( $dir . $ficheiro ) ? (string) filemtime( $dir . $ficheiro ) : null;
	};

	wp_enqueue_style( 'ama-gerador', $uri . '/css/gerador.css', array(), $ver( '/css/gerador.css' ) );

	$generator = 'en' === $lingua ? '/js/generator-en.js' : '/js/generator.js';

	wp_enqueue_script( 'ama-gerador-tabs', $uri . '/js/gerador-tabs.js', array( 'jquery' ), $ver( '/js/gerador-tabs.js' ), true );
	// Os scripts do gerador usam "$"; o jQuery do WordPress está em modo noConflict.
	wp_add_inline_script( 'ama-gerador-tabs', 'window.$ = window.$ || window.jQuery;', 'before' );
	wp_enqueue_script( 'ama-gerador', $uri . $generator, array( 'ama-gerador-tabs' ), $ver( $generator ), true );
	wp_enqueue_script( 'ama-gerador-main', $uri . '/js/main.js', array( 'ama-gerador' ), $ver( '/js/main.js' ), true );
}
add_action( 'wp_enqueue_scripts', 'ama_gerador_assets', 20 );

/**
 * Página EN: <html lang="en">.
 */
function ama_gerador_lang_en( $output ) {
	if ( is_page() && 'en' === ama_gerador_lingua() ) {
		$output = preg_replace( '/lang="[^"]*"/', 'lang="en"', $output );
	}
	return $output;
}
add_filter( 'language_attributes', 'ama_gerador_lang_en', 20 );

/**
 * Cabeçalho comum às duas páginas: breadcrumb, título, descrição e ligação para a outra língua.
 */
function ama_gerador_cabecalho( $lingua ) {
	$id     = get_the_ID();
	$par    = ama_gerador_pagina_par( $id );
	$textos = 'en' === $lingua
		? array(
			'aqui'      => 'You are here',
			'inicio'    => 'Home',
			'descricao' => 'Tool that automatically generates the Accessibility and Usability Statement ready to publish on your website.',
			'outra'     => 'Versão em português',
			'outra_lng' => 'pt-PT',
		)
		: array(
			'aqui'      => 'Você está aqui',
			'inicio'    => 'Início',
			'descricao' => 'Ferramenta que gera automaticamente a Declaração de Acessibilidade e Usabilidade pronta a publicar no seu sítio Web.',
			'outra'     => 'English version',
			'outra_lng' => 'en',
		);

	$descricao = function_exists( 'get_field' ) ? get_field( 'descricao_pagina', $id ) : '';
	if ( ! $descricao && has_excerpt( $id ) ) {
		$descricao = get_the_excerpt( $id );
	}
	if ( ! $descricao ) {
		$descricao = $textos['descricao'];
	}
	?>
	<div class="page-header gerador-header">
		<nav aria-label="<?php echo esc_attr( $textos['aqui'] ); ?>">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>"<?php echo 'en' === $lingua ? ' lang="pt-PT"' : ''; ?>><?php echo esc_html( $textos['inicio'] ); ?></a>
				</li>
				<li class="breadcrumb-item active" aria-current="page"><?php the_title(); ?></li>
			</ol>
		</nav>
		<div class="row">
			<div class="col-12 col-lg-8">
				<h1><?php the_title(); ?></h1>
				<?php echo wp_kses_post( wpautop( $descricao ) ); ?>
			</div>
			<?php if ( $par ) : ?>
			<div class="col-12 col-lg-4 d-flex justify-content-lg-end align-items-end">
				<p class="gerador-lingua mb-3">
					<a href="<?php echo esc_url( get_permalink( $par ) ); ?>" lang="<?php echo esc_attr( $textos['outra_lng'] ); ?>" hreflang="<?php echo esc_attr( $textos['outra_lng'] ); ?>"><?php echo esc_html( $textos['outra'] ); ?></a>
				</p>
			</div>
			<?php endif; ?>
		</div>
	</div>
	<?php
}

/**
 * Página completa do gerador (usada pelos dois templates).
 */
function ama_gerador_pagina( $lingua ) {
	get_header();
	?>
	<main class="site-main" id="main">
		<div class="wrapper" id="page-wrapper">
			<div class="container" id="content" tabindex="-1">
				<?php
				while ( have_posts() ) :
					the_post();
					ama_gerador_cabecalho( $lingua );
				endwhile;
				?>
			</div>
			<?php get_template_part( 'template-parts/gerador/formulario', $lingua ); ?>
		</div>
	</main>
	<?php
	get_footer();
}

<?php
// Exit if accessed directly.
defined('ABSPATH') || exit;

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="icon" type="image/x-icon" href="<?= get_stylesheet_directory_uri() ?>/img/favicon.ico">
	<?php

	// Assistente virtual: só scripts de domínios autorizados (ver ama_ai_agent_markup() em functions.php)
	echo ama_ai_agent_markup();
	wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<header id="wrapper-navbar" aria-label="Cabeçalho da página do <?= get_bloginfo('name') ?>">
		<div class="skip-to-content">
			<div class="container">
				<a class="skip-to-content-link" href="#content"><span>Saltar para o conteúdo principal da página</span></a>
			</div>
		</div>
		<div class="top-bar">
			<div id="accordionTopBar" class="accordion accordion-flush container-fluid p-0">
				<div class="container d-flex justify-content-between top-bar-item">
					<button class="order-2 btn btn-link dark-mode p-1 d-flex align-items-center" id="darkModeBtn">
						<span id="darkModeLabel">Modo Escuro</span><span class="icon-dark icon" aria-hidden="true"></span>
					</button>
					<button id="flushHeading" type="button" class="order-1 btn btn-link btn-ecossistema collapsed d-flex align-items-center p-1" data-bs-toggle="collapse" data-bs-target="#flushEcossistema" aria-expanded="false" aria-controls="flushEcossistema">
						<span class="icon-ed-menu-dots icon" aria-hidden="true"></span>
						<span>Uma ferramenta do ecossistema <span class="fw-bold">acessibilidade.gov.pt</span></span>
						<span class="icon-arrow-drop icon" aria-hidden="true"></span>
					</button>

				</div>
				<div class="container-fluid p-0 accordion-bg">
					<div id="flushEcossistema" class="accordion-collapse collapse" aria-labelledby="flushHeading" role="region" aria-roledescription="Painel de acordeão" data-bs-parent="#accordionTopBar">
						<div class="accordion-body">
							<div class="container">
								<div class="row px-3">
									<div class="col-12 col-lg-6 align-self-center">
										<div class="d-flex justify-content-between">
											<?php dynamic_sidebar('title-ecossistema-ama'); ?>
										</div>
									</div>
									<div class="col-12 col-lg-6 align-self-center">
										<?php dynamic_sidebar('description-ecossistema-ama'); ?>
									</div>
								</div>
								<hr class="mt-4 mb-5" aria-hidden="true">
								<div class="row px-3">
									<div class="col-12 col-lg-4">
										<?php dynamic_sidebar('left-column-ecossistema-ama'); ?>
									</div>
									<div class="col-12 col-lg-4">
										<?php dynamic_sidebar('center-column-ecossistema-ama'); ?>
									</div>
									<div class="col-12 col-lg-4">
										<?php dynamic_sidebar('right-column-ecossistema-ama'); ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="widgets-bar">
			<div class="container">
				<div class="row">
					<div class="col-12 col-lg-6 align-self-center">
						<div class="d-flex justify-content-between">
							<?php if (! is_front_page()) : ?>
								<a href="<?php echo site_url(); ?>">
								<?php endif; ?>
								<?php dynamic_sidebar('title'); ?>
								<?php if (! is_front_page()) : ?>
								</a>
							<?php endif; ?>
							<div class="d-flex d-lg-none flex-column align-items-center">
								<button type="button" class="open-mobile-menu">
									<span class="icon-hamburguer-menu-round icon" aria-hidden="true"></span>
									<span class="visually-hidden">Abrir menu de navegação</span>
								</button>
								<p class="mobile-menu-label">Menu</p>
							</div>
						</div>
					</div>
					<div class="col-12 col-lg-6 align-self-center">
						<?php dynamic_sidebar('description'); ?>
					</div>
				</div>
			</div>
		</div>

		<div class="navigation">
			<div class="container">
				<div class="mobile-overlay">
					<div class="mobile-overlay-content">
						<div class="widgets-bar-mobile d-lg-none">
							<div class="d-flex justify-content-between align-items-start">
								<?php if (! is_front_page()) : ?>
									<a href="<?php echo site_url(); ?>">
									<?php endif; ?>
									<?php dynamic_sidebar('Title'); ?>
									<?php if (! is_front_page()) : ?>
									</a>
								<?php endif; ?>
								<div class="d-flex d-lg-none">
									<button type="button" class="close-mobile-menu">
										<span class="icon-close-round icon" aria-hidden="true"></span>
										<span class="visually-hidden">Fechar menu de navegação</span>
									</button>
								</div>
							</div>
						</div>
						<nav class="navbar py-0" aria-label="Menu principal do <?= get_bloginfo('name') ?>">
							<?php
							wp_nav_menu(
								array(
									'theme_location'  => 'primary',
									'menu_class' => 'main-menu navbar-nav',
								)
							);
							?>
						</nav>
					</div>
				</div>
				<div class="search" role="search">
					<div class="d-none d-lg-block">
						<div class="dropdown">
							<button aria-haspopup="dialog" class="ama btn btn-secondary d-flex flex-row align-items-center" type="button" id="searchDropdown" data-bs-toggle="dropdown" aria-expanded="false">
								<span class="icon-search icon" aria-hidden="true"></span>
								<span>Pesquisar</span>
							</button>
							<div class="dropdown-menu dropdown-menu-end p-1" aria-labelledby="searchDropdown">
								<form method="get" class="form-search-bar" action="<?= esc_url(home_url('/')); ?>">
									<label for="search-input" class="ama">Pesquisar por:</label>
									<input type="search" id="search-input" class="ama form-control" value="<?= get_search_query(); ?>" name="s">
									<button type="submit" class="search-submit">
										<span class="icon-search icon" aria-hidden="true"></span>
										<span class="visually-hidden">Pesquisar</span>
									</button>

								</form>
							</div>
						</div>
					</div>
					<div class="d-lg-none">
						<?= AMA_get_search_form(); ?>
					</div>
				</div>
			</div>
		</div>
	</header>
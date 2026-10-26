<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();

$search = get_search_query();
?>
    <div class="wrapper" id="search-wrapper">
        <div class="container" id="content" tabindex="-1">
            <main class="site-main" id="main">
                <div class="page-header">
                    <nav aria-label="Você está aqui">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="<?php echo site_url(); ?>">Início</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Pesquisa
                            </li>
                        </ol>
                    </nav>

                    <div class="row">
                        <div class="col-12 col-lg-8 align-self-end">
                            <h1 class="mb-3"><?php echo (!empty($search) ? "Pesquisou por : ".$search : "Pesquisa") ?></h1>
                            <div class="d-block d-md-flex">
                                <form role="search" method="get" class="d-none d-lg-block search-form my-4" action="<?= site_url(); ?>">
                                    <label for="search-field" class="mb-2">Pesquisar por:</label>
                                    <div class="search input-group">
                                        <input id="search-field" type="search" class="search-field" placeholder="Pesquisar por:" value="<?= get_search_query(); ?>" name="s" />
                                        <button type="submit" class="search-submit">
                                            <span class="icon-search icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Pesquisar</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <?php if ( get_search_query() !== '' ) : ?>
                                <p><?php echo $wp_query->found_posts; ?> <?php echo $wp_query->found_posts == 1 ? 'resultado encontrado' : 'resultados encontrados'; ?></p>
                            <?php else : ?>
                                <p>0 resultados encontrados</p>
                            <?php endif; ?>
                        </div>

                        <div class="d-none d-lg-flex col-lg-4 d-flex justify-content-center featured-image">
                            <div class="featured-image">
                                <span class="icon-xl-search-results icon" aria-hidden="true"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="page-content">
                    <?php if ( have_posts() && get_search_query() !== '' ) : ?>
                        <ul style="padding: 0; margin: 0; list-style: none;">
                            <?php while ( have_posts() ) : the_post(); ?>
                                <li style="padding: 40px 0; border-bottom: 1px solid #333333;">
                                    <a href="<?php the_permalink(); ?>">
                                        <h3><?php the_title(); ?></h3>
                                    </a>
                                    <div class="mb-3" style="font-size: 1rem;">
                                        <?php echo get_the_modified_date('j \d\e F, Y'); ?>
                                    </div>
                                    <?php if ( has_excerpt() ) : ?>
                                        <div class="excerpt">
                                            <?php the_excerpt(); ?>
                                        </div>
                                    <?php endif; ?>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                        <?php ama_pagination(); ?>
                    <?php else : ?>
                        <p>Não foram encontrados resultados para esta pesquisa.</p>
                    <?php endif; ?>
                </div>
            </main>
        </div>
    </div>
<?php
get_footer();
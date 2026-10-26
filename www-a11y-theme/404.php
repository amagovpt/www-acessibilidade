<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

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
                            <h1>Página não encontrada</h1>
                            <p>
                                Desculpe, a página que procura não foi encontrada. Pode ter sido removida, o seu nome
                                alterado ou estar temporariamente indisponível. Recomendamos que comece novamente a
                                partir da página inicial. Por favor, entre em contacto connosco se o problema persistir
                                ou não encontrar a informação que procura.
                            </p>
                        </div>
                        <div class="d-none d-lg-flex col-lg-4 d-flex justify-content-center featured-image">
                            <div aria-hidden="true" class="icon-xl-alert icon"></div>
                        </div>
                    </div>
                </div>
                <div class="page-content">
                    <ul class="list-unstyled">
                        <li><a href="<?= site_url(); ?>" class="ama btn btn-primary">Ir para a página inicial<span aria-hidden="true" class="icon-arrow-bullets ms-2"></span></a></li>
                    </ul>
                </div>
                <div class="page-footer">
                    <div class="d-flex justify-content-between">
                        <div class="share-post">
                            <h2>Partilhar</h2>
                            <ul class="d-flex list-inline mb-0">
                                <li>
                                    <button id="fb-icon" type="button" role="button" aria-label="Partilhar no Facebook" >
                                        <span class="icon-share-facebook" aria-hidden="true"></span>
                                    </button>
                                </li>
                                <li>
                                    <button id="tw-icon" type="button" role="button" aria-label="Partilhar no Twitter">
                                        <span class="icon-share-twitter" aria-hidden="true"></span>
                                    </button>
                                </li>
                                <li>
                                    <button id="ld-icon" type="button" role="button" aria-label="Partilhar no Linkedin">
                                        <span class="icon-share-linkedin" aria-hidden="true"></span>
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
<?php
get_footer();
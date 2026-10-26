<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
?>

    <main class="site-main" id="main">
        <div class="wrapper" id="single-wrapper">
            <div class="container" id="content" tabindex="-1">
                <div class="page-header">
                    <nav aria-label="Você está aqui">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="<?php echo site_url(); ?>">Início</a>
                            </li>
                            <?php
                            // Verifica se é um post e insere o breadcrumb do post pai
                            if(get_post_type(get_queried_object_id()) == 'post') {
                                // ligação da página de blogue
                                $blog_page = get_option('page_for_posts');

                                if(!empty($blog_page)) {
                                    echo '<li class="breadcrumb-item">';
                                    echo '<a href="'.get_the_permalink($blog_page).'">'.get_the_title($blog_page).'</a>';
                                    echo '</li>';
                                }

                                //Verifica se o post tem um post pai
                                if ( has_post_parent() ) {
                                    $post_parent_id = wp_get_post_parent_id();
                                    echo '<li class="breadcrumb-item">';
                                    echo '<a href="' . get_the_permalink($post_parent_id) . '">' . get_the_title($post_parent_id) . '</a>';
                                    echo '</li>';
                                }

                            }
                            ?>
                            <li class="breadcrumb-item active" aria-current="page">
                                <?= get_the_title(); ?>
                            </li>
                        </ol>
                    </nav>

                    <div class="row">
                        <div class="col-12 col-lg-8">
                            <h1><?php the_title(); ?></h1>
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

                <div class="page-content">
                    <?php the_content(); ?>
                </div>

                <div class="page-footer">
                    <div class="d-flex justify-content-between">
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
                </div>
            </div>
        </div>
    </main>
<?php
get_footer();
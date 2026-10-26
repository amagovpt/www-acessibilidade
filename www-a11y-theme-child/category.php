<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$categoria = get_queried_object();
//var_dump($categoria);

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
                            // ligação da página de blogue
                            $blog_page = get_option('page_for_posts');

                            if(!empty($blog_page)) {
                                echo '<li class="breadcrumb-item">';
                                echo '<a href="'.get_the_permalink($blog_page).'">'.get_the_title($blog_page).'</a>';
                                echo '</li>';
                            } else {
                                echo '<li class="breadcrumb-item">';
                                echo '<a href="'.site_url("blogue").'">Blogue</a>';
                                echo '</li>';
                            }
                            ?>
                            <li class="breadcrumb-item active" aria-current="page">
                                <?= $categoria->name ?>
                            </li>
                        </ol>
                    </nav>

                    <div class="row">
                        <div class="col-12 col-lg-8">
                            <h1>Blogue acessibilidade.gov.pt</h1>
                            <h2><?= $categoria->name ?></h2>
                        </div>
                        <div class="d-none d-lg-flex col-lg-4 d-flex justify-content-center featured-image">
                            <div class="featured-image">
                                <div aria-hidden="true" class="icon-xl-bulb icon"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-content">
                    <?php
                    // Query para os 3 cartões de destaque
                    $destaques = new WP_Query([
                        'post_type'         => 'post',
                        'post_status'       => 'publish',
                        'posts_per_page'    => 3,
                        'orderby'           => 'post_date',
                        'order'             => 'DESC',
                        'category_name'     => $categoria->slug,
                        'sticky'            => true,
                    ]);

                    if($destaques->have_posts()) {
                        echo '<h2 class="visually-hidden">Artigos em destaque</h2>';
                        echo '<div class="container-fluid px-0">';
                        echo '<ul class="grid grid-3 gap-40 list-unstyled">';

                        ob_start();
                        foreach($destaques->posts as $post){
                            $destaques->the_post();
                            echo '<li class="post-card-wrapper">';
                            echo get_template_part('template-parts/post-card', 'alt');
                            echo '</li>';
                        }

                        echo ob_get_clean();
                        echo '</ul>';
                        echo '</div>';
                    }
                    wp_reset_postdata();
                    ?>
                </div>
                <div class="container px-0 mt-5">
                    <div class="row gx-5">
                        <div class="col-12 col-md-8">
                            <?php
                            // Resto de artigos desta categoria

                            $page           = get_query_var('paged') ? get_query_var('paged') : 1;
                            $posts_per_page = get_option('posts_per_page');

                            $params = [
                                'post_type'         => 'post',
                                'post_status'       => 'publish',
                                'posts_per_page'    => 10,
                                'paged'             => $page,
                                'orderby'           => 'post_date',
                                'order'             => 'DESC',
                                'category_name'     => $categoria->slug,
                                'ignore_sticky_posts' => 1,
                            ];

                            $posts = new WP_Query($params);
                            $pagination = AMA_pagination_v2($posts, $page);

                            if(sizeof($posts->posts) > 0) {
                                echo '<h2 class="visually-hidden">Artigos de '. $categoria->name.'</h2>';
                                echo '<ul class="post-list list-unstyled" data-categoria="'.$categoria->slug.'">';

                                ob_start();
                                foreach($posts->posts as $post){
                                    $posts->the_post();
                                    echo get_template_part('template-parts/post-list', 'item');
                                }

                                echo ob_get_clean();
                                echo '</ul>';
                            }

                            wp_reset_postdata();
                            echo '<div id="paginacao">'.$pagination.'</div>';
                            ?>
                        </div>
                        <aside class="col-12 col-md-4">
                            <div class="sidebar p-4 p-lg-5">
                                <h3 class="h5">Mais vistos</h3>
                                <hr>
                                <?= do_shortcode('[get_most_views]'); ?>
                                <h3 class="h5">Categorias</h3>
                                <hr>
                                <?= do_shortcode('[get_blogue_categories]'); ?>
                            </div>
                        </aside>
                    </div>
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
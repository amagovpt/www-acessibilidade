<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Atualiza as visualizações do artigo
update_post_views(get_the_ID());

wp_enqueue_style(
        'post',
        get_stylesheet_directory_uri() . '/css/single-post.css',
        [],
        '1.0.0'
);

// Categorias e etiquetas do artigo
$categories = get_the_category(get_the_ID());
$categories_id = [];
foreach ($categories as $category) {
    $categories_id[] = $category->term_id;
}

$tags = get_the_tags(get_the_ID());
if($tags == false){
    $tags = [];
}

// Caso o artigo não tenha uma featured image, é atribuída a imagem alternativa
$image = get_post_meta(get_the_ID(), 'imagem', TRUE);

get_header();
?>
<main class="site-main" id="main">
    <div class="wrapper" id="single-wrapper">
        <div class="container" id="content" tabindex="-1">
            <div class="page-header">
                <nav aria-label="Você está aqui">
                    <ol class="breadcrumb mb-5">
                        <li class="breadcrumb-item">
                            <a href="<?= site_url(); ?>">Início</a>
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
                            } else {
                                echo '<li class="breadcrumb-item">';
                                echo '<a href="'.site_url("blogue").'">Blogue</a>';
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
            </div>
            <article class="page-content">
                <div class="container-fluid px-0">
                    <div class="row gx-5">
                        <div class="col-12 col-lg-8">
                            <a href="<?= site_url("blogue")?>" class="version" title="Consulte todos os artigos no blogue">Blogue</a>
                            <h1 class="mb-2"><?php the_title(); ?></h1>
                            <div class="last-update py-2">
                                <p class="mb-0"><?= get_the_date('j \d\e F, Y'); ?></p>
                            </div>
                            <?php
                            if (has_post_thumbnail()) {
                                echo '<div class="post featured-image">';
                                the_post_thumbnail();
                                echo '</div>';
                            } elseif($image != '') {
                                echo '<div class="post featured-image">';
                                echo '<img alt="'.$image['post_title'].'" src="'.$image['guid'].'">';
                                echo '</div>';
                            }
                            ?>
                            <hr class="my-3 my-lg-5">
                            <?php the_content(); ?>
                        </div>
                        <aside class="col-12 col-md-4">
                            <div class="sidebar p-4 p-lg-5">
                                <h2>Relacionados</h2>
                                <?php get_related_articles($categories_id, get_the_ID()) ?>
                            </div>
                        </aside>
                    </div>
                    <?php
                    // Categorias do artigo
                    if(
                        (is_countable($categories) && count($categories) > 0) ||
                        (is_countable($tags) && count($tags) > 0)
                    ) {
                        echo '<div class="row mt-3 mt-lg-5">';
                        if(is_countable($categories) && count($categories) > 0) {

                            echo '<div class="col-12">';
                            echo '<h2 class="h5">Categorias</h2>';
                            echo '<ul class="list-unstyled list-inline">';
                            foreach ($categories as $category) {
                                echo '<li class="list-inline-item"><a href="'.get_category_link($category->term_id).'">'.$category->name.'</a></li>';
                            }
                            echo '</ul>';
                            echo '</div>';
                        }

                        // Etiquetas do artigo
                        if(is_countable($tags) && count($tags) > 0) {
                            echo '<div class="col-12 mt-3">';
                            echo '<h2 class="h5">Etiquetas</h2>';
                            echo '<ul class="list-unstyled list-inline">';
                            foreach ($tags as $tag) {
                                echo '<li class="list-inline-item"><a href="'.get_category_link($tag->term_id).'">'.$tag->name.'</a></li>';
                            }
                            echo '</ul>';
                            echo '</div>';
                        }
                        echo '</div>';
                    }
                    ?>
                </div>
            </article>
            <div class="page-footer">
                <div class="d-flex justify-content-between">
                    <?= do_shortcode('[partilhar-redes-sociais]'); ?>
                    <div class="last-update py-2">
                        <p class="mb-0">Última atualização a <?= get_the_modified_date('j \d\e F, Y'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php ama_pre_rodape('mt-3'); ?>
</main>
<?php
get_footer();
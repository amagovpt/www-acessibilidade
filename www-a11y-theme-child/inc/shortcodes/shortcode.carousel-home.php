<?php

function carousel_home_cb(): ?string
{
    $output = "";
    ob_start(); ?>
<div class="lbc-destaques-top-container">
    <h2 id="lbc-destaques-module-title">Em destaque</h2>
    <div id="lbc-carousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="false">
        <div class="carousel-inner" id="lbc-destaques-container">
            <div id="lbc-destaques-main-container">
                <div id="lbc-destaques-controls">
                    <button class="carousel-control-prev" type="button" data-bs-target="#lbc-carousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#lbc-carousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
                <div id="lbc-destaques-right-side">
                    <div class="carouse-item active">
                        <div class="lbc-destaques-titles">
                            <h3>O meu título</h3>
                        </div>
                        <div class="lbc-destaques-imgs">
                            <img src="https://via.placeholder.com/150" alt="Imagem de destaque">
                        </div>
                    </div>
                    <div class="carouse-item">
                        <div class="lbc-destaques-titles">
                            <h3>O meu título 2</h3>
                        </div>
                        <div class="lbc-destaques-imgs">
                            <img src="https://via.placeholder.com/150" alt="Imagem de destaque">
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<?php
    $output = ob_get_clean();
    return $output;
}
add_shortcode("carousel-home", "carousel_home_3_cb");

function carousel_home_2_cb(): ?string
{
    $output = "";
    ob_start(); ?>
    <div id="lbc-carousel" class="carousel slide" data-bs-ride="carousel" style="display: block">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="lbc-destaques-titles">
                    <h3>O meu título</h3>
                </div>
                <div class="lbc-destaques-imgs">
                    <img src="https://via.placeholder.com/150" alt="Imagem de destaque">
                </div>
            </div>
            <div class="carousel-item">
                <div class="lbc-destaques-titles">
                    <h3>O meu título 2</h3>
                </div>
                <div class="lbc-destaques-imgs">
                    <img src="https://via.placeholder.com/150" alt="Imagem de destaque">
                </div>
            </div>
            <div id="lbc-destaques-controls" style="background-color: darkred;">
                <button class="carousel-control-prev" type="button" data-bs-target="#lbc-carousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#lbc-carousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>
    <?php
    $output = ob_get_clean();
    return $output;
}

/**
 * Shortcode que apresenta um carrossel com os últimos 5 posts, para ser utilizado na homepage.
 *
 * @return string|null
 */
function carousel_home_3_cb(): ?string
{
    $output = "";
    ob_start(); ?>
    <div id="AMA-home-carousel" class="ama carousel slide" data-bs-ride="carousel" style="display: block">
        <div class="carousel-inner">
            %s
            <div class="slider-controls">
                <button class="carousel-control-prev" type="button" data-bs-target="#AMA-home-carousel" data-bs-slide="prev">
                    <span class="visually-hidden">Slide anterior</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#AMA-home-carousel" data-bs-slide="next">
                    <span class="visually-hidden">Próximo slide</span>
                </button>
            </div>
        </div>
    </div>
    <?php
    $output = ob_get_clean();

    $carousel_items = "";

    // Get the last 5 posts.
    $args = [
        "numberposts"   => 5,
        "post_status"   => "publish",
        "sticky"        => true,
        "orderby"       => "post_date",
        "order"         => "DESC",
    ];

    $posts = wp_get_recent_posts($args);
    if($posts) {
        for($i = 0; $i < count($posts); $i++) {
            // Informação do post
            $post           = $posts[$i];
            $post_id        = $post['ID'];
            $post_title     = $post['post_title'];

            if($post['post_excerpt']) {
                $post_excerpt = wp_trim_words($post['post_excerpt'], 20);
            } else {
                $post_excerpt = wp_trim_words($post['post_content'], 20);
            }


            // Verificar se o post tem imagem em destaque, caso contrário, verificar se tem imagem associada (meta field)
            if(has_post_thumbnail($post_id)) {
                $post_thumbnail_id = get_post_thumbnail_id($post_id);
            } else {
                $post_thumbnail_id = (get_post_meta($post_id, "imagem", true)) ? get_post_meta($post_id, "imagem", true)["ID"] : 0;
            }

            $carousel_items .= sprintf(
                '<div class="carousel-item %s">
                            <div class="container">
                                <div class="row">
                                    <div class="col-12 col-md-6 col-lg-7 first-column order-md-2">
                                        '.wp_get_attachment_image($post_thumbnail_id, "fullwidth", false, ["class" => "img-fluid feature-image"]).'
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-5 second-column order-md-1">
                                        <h2 class="mb-3 h3"><a href="'.get_permalink($post_id).'" title="">%s</a></h2>
                                        <p class="mb-3">'.$post_excerpt.'</p>
                                        <a href="'.get_permalink($post_id).'" class="ama btn btn-primary">Ler mais<span class="visually-hidden"> sobre '.$post_title.'</span></a>
                                    </div>                                    
                                </div>
                            </div>
                        </div>',
                $i === 0 ? 'active' : '',
                $post_title
            );
        }
    }


    return sprintf($output, $carousel_items);
}


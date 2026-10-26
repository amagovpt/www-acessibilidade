<?php

/**
 * Mostra em destaque o último post do blogue.
 *
 * @return string|null
 */
function get_highlight_blogue(): ?string {
    $output = '';
    $home = home_url();
    $articles_params = array(
        'limit'         => 1,
        /*'orderby'     => 'destaque.meta_value DESC, post_date DESC',*/
        'orderby'       => 'post_date DESC',
        'post_status'   => 'publish',
        'where'         => 'destaque.meta_value = 1'
    );
    $articles           = pods( 'post' , $articles_params);
    $highlight_article  = pods( 'post' , $articles_params);
    $highlight_article->fetch();
    $post_date          = date($highlight_article->display('post_date'));
    $date               = get_the_date($format="",  $highlight_article->display('ID'));
    $category_highlight = get_the_category($highlight_article->display('ID'));
    $descricao          = get_the_excerpt($highlight_article->display('ID'));

    $output = '';
    ob_start();
    ?>

    <h2 class="visually-hidden">Destaque principal</h2>
    <div class="grid grid-sm-1 grid-lg-2 gap-5">
        <div class="d-flex flex-column justify-content-center" id="blogue_right">
            <h3 class="h2 mb-2"><a href="<?= get_permalink($highlight_article->display('ID')) ?>"><?= (wp_trim_words($highlight_article->display('post_title'), 15)) ?></a></h3>
            <span class="mb-3"><?= $date ?></span>
            <p class="mb-3"><?=  (wp_trim_words( $descricao, 20)) ?></p>
            <div>
                <a class="ama btn btn-secondary" href="<?= get_permalink($highlight_article->display('ID')) ?>" title="<?= $highlight_article->display('post_title') ?>">Ler mais</a>
            </div>
        </div>
        <div class="d-flex align-items-center" id="blogue_left">
            <?php 
            if(has_post_thumbnail($highlight_article->display('ID'))){
                echo get_the_post_thumbnail($highlight_article->display('ID'), 'large', ['class' => 'img-fluid']);
            }            
            ?>
        </div>
    </div>

    <?php
    $output = ob_get_clean();
    return $output;

    /*
    return '<h2 class="visually-hidden">Destaque principal</h2>
                <div class="grid grid-sm-1 grid-lg-2 gap-5">
                    <div class="d-flex flex-column justify-content-center" id="blogue_right">
                        <h3 class="h2 mb-2"><a href="'.$home.'/blogue/'.$category_highlight[0]->slug.'/'.$highlight_article->display('post_name').'/">'.wp_trim_words($highlight_article->display('post_title'), 15).'</a></h3>
                        <span class="mb-3">'.$date.'</span>
                        <p class="mb-3">'. wp_trim_words( $descricao, 20).'</p>
                        <div>
                            <a class="ama btn btn-secondary" href="'.$home.'/blogue/'.$category_highlight[0]->slug.'/'.$highlight_article->display('post_name').'/" title="'.$highlight_article->display('post_title').'">Ler mais</a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center" id="blogue_left">
                        <img alt="'.$alt.'" src="'.$image.'"/>
                    </div>
                </div>';

                */
}
add_shortcode( 'get_highlight_blogue', 'get_highlight_blogue' );
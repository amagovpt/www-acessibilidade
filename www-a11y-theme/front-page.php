<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
?>
<main class="site-main" id="main">
    <div class="wrapper" id="index-wrapper">
        <div class="container-fluid p-0" id="content" tabindex="-1">
            <?php
            $sticky = get_option( 'sticky_posts' );

            if ( count( $sticky ) > 0 ) :

            $post = new WP_Query( array(
                'posts_per_page' => 1,
                'post__in' => get_option( 'sticky_posts' ),
                'ignore_sticky_posts' => 1,
            ) );

            if ( $post->have_posts() ) : $post->the_post(); ?>
                <section class="sticky-post">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 col-md-6 align-self-center">
                                <a href="<?php echo get_the_permalink(); ?>"><h2><?php echo get_the_title(); ?></h2></a>
                                <p><?php echo get_the_excerpt(); ?> </p>
                            </div>
                            <div class="col-12 col-md-6 align-self-center">
                                <?php echo get_the_post_thumbnail(); ?>
                            </div>
                        </div>
                        <hr class="my-5" aria-hidden="true">
                    </div>
                </section>
            <?php endif;
            endif;
            wp_reset_postdata(); ?>
            <?php the_content(); ?>
        </div>
    </div>
</main>
<?php
get_footer();
<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
?>
<main class="site-main" id="main">
    <div class="wrapper" id="index-wrapper">
        <div class="container-fluid p-0" id="content" tabindex="-1">
            <?php the_content(); ?>
        </div>
    </div>
</main>
<?php
get_footer();
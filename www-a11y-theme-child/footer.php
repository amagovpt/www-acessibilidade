<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

?>

<?php wp_footer(); ?>

<footer>
    <div class="container py-4">
        <nav aria-label="menu de rodapé do acessibilidade.gov.pt">
        <?php 
        wp_nav_menu(
            array(
                'theme_location'  => 'footer',
                'menu_class' => 'footer-menu',
            )
        ); ?>
        </nav>
        
        <div class="footer-logos">
            <?php dynamic_sidebar( 'Footer' ); ?>
        </div>
        <p class="mt-3"><?= ama_cookie_settings_button() ?></p>
        <?php dynamic_sidebar( 'Copyright' ); ?>
    </div>
</footer>

</body>

</html>
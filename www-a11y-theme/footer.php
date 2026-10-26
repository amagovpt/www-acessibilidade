<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

?>

<?php wp_footer(); ?>

<footer>
    <div class="container py-4">
        <nav aria-label="Menu de rodapé do selo.usabilidade.gov.pt">
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

        <div class="logo-selo">
            <img src="<?php echo get_template_directory_uri() . '/img/selo-ouro.svg'; ?>" alt="Selo Ouro de Usabilidade e Acessibilidade">
        </div>

        <?php dynamic_sidebar( 'Copyright' ); ?>
    </div>
</footer>

</body>

</html>
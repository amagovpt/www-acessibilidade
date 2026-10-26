<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$aria_label = '';
if ( isset( $args['aria_label'] ) && ! empty( $args['aria_label'] ) ) {
	$aria_label = 'aria-label="' . esc_attr( $args['aria_label'] ) . '"';
}
?>

<form role="search" class="search-form" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" <?php echo $aria_label; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped above. ?>>
		<label for="site-search">Pesquisar por:</label>
		<div class="input-group">
		<input type="search" class="search-field" id="site-search" name="s" value="<?php the_search_query(); ?>" placeholder="Pesquisa...">
		<button type="submit" class="search-submit">
			<span class="icon-search icon" aria-label="Pesquisar" role="img"></span>
		</button>
	</div>
</form>
<?php

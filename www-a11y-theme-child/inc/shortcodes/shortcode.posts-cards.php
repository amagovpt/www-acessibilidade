
<?php

/**
 * Shortcode para mostrar os artigos em cartões.
 *
 * @param array $attrs Atributos do shortcode.
 * @return string
 */
function posts_cards_cb( $attrs ): string {
    global $wpdb;

    $attrs = shortcode_atts(
        [
            'total' => 3,
        ],
        $attrs,
        'posts-cards'
    );

    $total = max( 1, absint( $attrs['total'] ) );

    // Selecionar apenas artigos publicados e destacados.
    $query = $wpdb->prepare(
        "
        SELECT DISTINCT POST.ID, POST.post_title, POST.post_date
        FROM {$wpdb->posts} AS POST
        INNER JOIN {$wpdb->postmeta} AS META
            ON POST.ID = META.post_id
        WHERE POST.post_type = %s
          AND POST.post_status = %s
          AND META.meta_key = %s
          AND META.meta_value = %s
        ORDER BY POST.post_date DESC
        LIMIT %d
        ",
        'post',
        'publish',
        'destaque',
        '1',
        $total
    );

    $posts = $wpdb->get_results( $query );

    $html = '';

    if ( $posts ) {
        foreach ( $posts as $item ) {

            // Obter a imagem destacada ou a imagem associada ao artigo.
            if ( has_post_thumbnail( $item->ID ) ) {
                $thumbnail_id = get_post_thumbnail_id( $item->ID );
            } else {
                $imagem = get_post_meta( $item->ID, 'imagem', true );
                $thumbnail_id = is_array( $imagem )
                    ? absint( $imagem['ID'] ?? 0 )
                    : 0;
            }

            $html .= '
                <li class="post-card-wrapper">
                    <article class="post-card">
                        <div class="post-thumbnail">'
                            . wp_get_attachment_image(
                                $thumbnail_id,
                                'fullwidth',
                                false,
                                [ 'class' => 'img-fluid' ]
                            ) .
                        '</div>
                        <div class="post-body">
                            <h3 class="post-title">
                                <a href="' . esc_url( get_permalink( $item->ID ) ) . '">'
                                    . esc_html( get_the_title( $item->ID ) ) .
                                '</a>
                            </h3>
                            <p class="post-date">'
                                . esc_html( get_the_date( 'd \d\\e F, Y', $item->ID ) ) .
                            '</p>
                        </div>
                    </article>
                </li>';
        }
    }

    return sprintf(
        '<div class="container py-5">
            <div class="row">
                <div class="col p-0">
                    <ul class="grid grid-1 grid-md-3 gap-40 list-unstyled">%s</ul>
                </div>
            </div>
        </div>',
        $html
    );
}

add_shortcode( 'posts-cards', 'posts_cards_cb' );

<?php
/**
 * Mostra as ferramentas disponíveis em formato grelha.
 *
 * Este shortcode é utilizado na página de Ferramentas.
 * Primeiramente são listadas as categorias de ferramentas disponíveis, e depois as ferramentas em si.
 * Por cada elemento da lista de categorias de ferramentas, são listadas as ferramentas associadas a essa categoria.
 *
 * @return string|null
 */
function get_tools_cb() : ?string
{
    $html = '';

    // Retorna todas as categorias de ferramentas
    $categorias_ferramentas = get_terms( 'categoria_ferramenta' );

    if(is_wp_error($categorias_ferramentas) || empty($categorias_ferramentas)) {
        return null;
    }

    foreach($categorias_ferramentas as $categoria) {
        // Retorna todas as ferramentas associadas a uma categoria
        $ferramentas = get_posts([
            'posts_per_page' => -1,
            'post_type'     => 'ferramentas',
            'post_status'   => 'publish',
            'tax_query'     => [
                [
                    'taxonomy'  => 'categoria_ferramenta',
                    'field'     => 'term_id',
                    'terms'     => $categoria->term_id,
                    'orderby'   => 'post_date DESC',
                ]
            ]
        ]);

        // Salta para a próxima categoria se não existirem ferramentas associadas
        if(is_wp_error($ferramentas) || empty($ferramentas)) {
            continue;
        }

        // Apresenta o título e descrição da categoria de ferramenta
        $html .= '<div class="row mb-5">';
        $html .= '<div class="col-12">';
        $html .= '<h3>' . $categoria->name . '</h3>';
        $html .= '<p>' . $categoria->description . '</p>';


        // Apresenta as ferramentas associadas à categoria
        $ferramentas_hmtl = '';

        foreach ($ferramentas as $ferramenta) {

            $ferramenta_descricao = get_post_meta($ferramenta->ID, 'descricao', true);
            $ferramentas_hmtl .= '<li>';
            $ferramentas_hmtl .= '<h4 class="h5"><a href="' . $ferramenta->link . '">' . $ferramenta->post_title . '</a></h4>';
            $ferramentas_hmtl .= $ferramenta_descricao ?? '';
            $ferramentas_hmtl .= '</li>';
        }

        $html .= sprintf('<ul class="ama-list grid grid-2">%s</ul>', $ferramentas_hmtl);

        $html .= '</div>';
        $html .= '</div>';

    }

    return  sprintf('<div id="ferramentas" class="container p-0">%s</div>', $html);
}
add_shortcode( 'get_tools', 'get_tools_cb' );
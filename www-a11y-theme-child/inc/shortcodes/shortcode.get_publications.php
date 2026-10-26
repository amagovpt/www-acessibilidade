<?php

/**
 * Mostra as publicações disponíveis em formato grelha.
 * 
 * Este shortcode é utilizado na página de Publicações.
 * Primeiramente são listadas as categorias de publicações disponíveis, e depois as publicações em si.
 * Por cada elemento da lista de categorias de publicações, são listadas as publicações associadas a essa categoria.
 * 
 * @return string|null
 */
function get_publications(): ?string 
{
    $home = home_url();
    $output = '';
    $publications_categories = get_terms( 'categoria_publicacao' );
    $y = 0;
    foreach($publications_categories as $category){
        $publications_array = get_posts([
                'posts_per_page'    => -1,
                'post_type'         => 'publicacoes',
                'post_status'       => 'publish',
                'tax_query'         => [
                    [
                        'taxonomy'  => 'categoria_publicacao',
                        'field'     => 'term_id',
                        'terms'     => $category->term_id,
                        'orderby'   => 'post_date DESC',
                    ]
                ]
            ]);
        $output .= '<div class="row no-gutters tools_list">
                        <div class="d-lg-block d-inline-flex justify-content-between tool_category" data-target="#publication_list'.$y.'">
                            <h3>'.$category->name.'</h3>
                            <div class="d-lg-none d-flex align-items-start"><div aria-hidden="true" class="icon-arrow-drop"></div></div>
                                <div class="d-lg-block d-none categories_description">'.$category->description.'</div>
                            </div>
                            <div class="row no-gutters w-100" id="publication_list'.$y.'">
                                  <div class="col-12 col-lg-6 left_list">
                                    <div class="d-lg-none d-block categories_description">'.$category->description.'</div>
                                    <ul class="list-group no-gutters press_list">';
        $count = count($publications_array);
        for($x=0;$x<$count;$x=$x+2){
            $output .= '<li class="list-group-item border-0 d-flex">
		        		        <div class="icon-arrow-bullets list_arrow_link" aria-hidden="true"></div>
		        		        <div class="list_link">
		        		            <a class="d-block" href="'.$home.'/publicacao/'.$publications_array[$x]->post_name.'">'.$publications_array[$x]->post_title.'</a>
		        		            <div class="item-description">'.$publications_array[$x]->descricao.'</div>
		        		        </div>
		        		    </li>';
        }
        $output .=  '</ul>
		    		</div>
		    		<div class="col-12 col-lg-6 right_list">
		    		<ul class="list-group no-gutters press_list">';

        for($x=1;$x<$count;$x=$x+2){
            $output .= '<li class="list-group-item border-0 d-flex">
		       			        <div class="icon-arrow-bullets list_arrow_link" aria-hidden="true"></div>
		       			        <div class="list_link">
		       			            <a class="d-block" href="'.$home.'/publicacao/'.$publications_array[$x]->post_name.'">'.$publications_array[$x]->post_title.'</a>
		       			            <div class="item-description">'.$publications_array[$x]->descricao.'</div>
		       			        </div>
		       			    </li>';
        }
        $output .= '</ul>
		    		</div>
		    	</div>
		    </div>';
        $y++;
    }
    return $output;
}

/**
 * Mostra as publicações disponíveis em formato grelha.
 *
 * Este shortcode é utilizado na página de Publicações.
 * Primeiramente são listadas as categorias de publicações disponíveis, e depois as publicações em si.
 * Por cada elemento da lista de categorias de publicações, são listadas as publicações associadas a essa categoria.
 *
 * @return string|null
 */
function get_publications_cb() : ?string
{
    $html = '';

    // Retorna todas as categorias de ferramentas
    $categorias_publicacoes = get_terms( 'categoria_publicacao' );

    if(is_wp_error($categorias_publicacoes) || empty($categorias_publicacoes)) {
        return null;
    }

    foreach ($categorias_publicacoes as $categoria) {
        $publicacoes = get_posts([
            'posts_per_page' => -1,
            'post_type'     => 'publicacoes',
            'post_status'   => 'publish',
            'tax_query'     => [
                [
                    'taxonomy'  => 'categoria_publicacao',
                    'field'     => 'term_id',
                    'terms'     => $categoria->term_id,
                    'orderby'   => 'post_date DESC',
                ]
            ]
        ]);

        // Salta para a próxima categoria se não existirem ferramentas associadas
        if(is_wp_error($publicacoes) || empty($publicacoes)) {
            continue;
        }

        // Apresenta o título e descrição da categoria da publicação
        $html .= '<div class="row">';
        $html .= '<div class="col-12">';
        $html .= '<h3 class="mb-3">' . $categoria->name . '</h3>';
        $html .= '<p class="mb-4">' . $categoria->description . '</p>';

        // Apresenta as publicações associadas à categoria
        $publicacoes_html  = '';
        foreach ($publicacoes as $publicacao) {

            $ferramenta_descricao = get_post_meta($publicacao->ID, 'descricao', true);
            $publicacoes_html .= '<li>';
            $publicacoes_html .= '<h4 class="h5"><a href="' . get_permalink($publicacao->ID) . '">' . $publicacao->post_title . '</a></h4>';
            $publicacoes_html .= $ferramenta_descricao ?? '';
            $publicacoes_html .= '</li>';
        }

        $html .= sprintf('<ul class="ama-list grid grid-2">%s</ul><hr class="my-5">', $publicacoes_html);

        $html .= '</div>';
        $html .= '</div>';


        // Apresenta as ferramentas associadas à categoria
        $ferramentas_hmtl = '';
    }

    return  sprintf('<div id="publicacoes" class="container p-0">%s</div>', $html);
}
add_shortcode( 'get_publications', 'get_publications_cb' );
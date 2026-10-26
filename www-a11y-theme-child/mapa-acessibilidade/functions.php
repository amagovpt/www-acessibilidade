<?php
/**
 * Verifica se termo atual contem o critério de sucesso.
 *
 * @param $term_id
 * @param $taxonomy
 * @return bool
 */
function has_current_item($term_id, $taxonomy): bool
{
    // Item atual
    $post_id = get_queried_object_id();

    $terms = get_terms( array(
        'taxonomy' => $taxonomy,
        'child_of' => $term_id
    ) );

    $term_ids = array( $term_id );
    foreach ( $terms as $term ) {
        $term_ids[] = $term->term_taxonomy_id;
    }

    $args = [
        "post_type"         => "criterio_sucesso",
        "orderby"           => "post_title",
        "order"             => "ASC",
        "posts_per_page"    => -1,
        "tax_query" => [
            [
                "taxonomy"          => $taxonomy,
                "field"             => "id",
                "terms"             => $term_ids,
                "include_children"  => true
            ]
        ]
    ];

    $query = new WP_Query( $args );

    $posts = [];
    if(is_countable($query->posts) && count($query->posts)>0) {
        foreach ($query->posts as $post) {
            $posts[] = $post->ID;
        }
    } else {
        return false;
    }

    return in_array($post_id, $posts);

}


/**
 * Devolve as ligações dos critérios de sucesso associados ao termo especificado.
 *
 * @param $taxonomy_name
 * @param $term_id
 * @return string|null
 */
function criterio_sucesso_children( $taxonomy_name, $term_id ): ?string {

    $output = "";

    $criterio_sucesso = new WP_Query([
        "post_type"         => "criterio_sucesso",
        "orderby"           => "post_title",
        "order"             => "ASC",
        "posts_per_page"    => -1,
        "tax_query"         => [ [
            "taxonomy"  => $taxonomy_name,
            "field"     => "id",
            "terms"     => $term_id
        ] ]
    ]);

    if( is_countable( $criterio_sucesso->posts ) && count( $criterio_sucesso->posts)>0 )
    {
        $natural_order = [];
        foreach( $criterio_sucesso->posts as $criterio )
        {
            $natural_order[] = ["titulo"=>$criterio->post_title, "url"=> get_permalink( $criterio->ID ) ];
        }

        foreach( $criterio_sucesso->posts as $criterio )
        {
            $current_item = (get_queried_object_id() === $criterio->ID) ? ' current ' : '';
            $output .= '<li><a href="' . get_permalink( $criterio->ID ) . '" class="criterio-sucesso '.$current_item.'">' . $criterio->post_title . '</a></li>';
        }
    }

    return sprintf("<ul class='no-bullets'>%s</ul>", $output );
}

/**
 *
 * @param $parent_id
 * @param $taxonomy_name
 *
 * @return string|null
 */
function principios_diretriz_nav_children( $parent_id, $taxonomy_name ): ?string {

    $diretrizes  = '';

    $terms = get_terms([
        "taxonomy"   => $taxonomy_name,
        "hide_empty" => false,
        "parent"     => $parent_id
    ]);


    if( is_countable( $terms ) && count( $terms )>0 )
    {
        foreach ( $terms as $term ) {
            $directriz = has_current_item($term->term_taxonomy_id, $term->taxonomy);
            $collapse = [
                "btn_class"     => "collapsed",
                "flush_class"   => "collapse",
                "aria"          => "false"
            ];

            if (has_current_item($term->term_taxonomy_id, $term->taxonomy))
            {
                $collapse["btn_class"]      = "";
                $collapse["flush_class"]    = "collapse show";
                $collapse["aria"]           = "true";
            }

            $accordion =
                '<div class="accordion-item">
                    <h2 class="accordion-header" id="flush-'.$taxonomy_name.'-'.$term->term_taxonomy_id.'">
                      <button class="accordion-button '.$collapse["btn_class"].'" type="button" 
                          data-bs-toggle="collapse" data-bs-target="#flush-collapse-'.$taxonomy_name.'-'.$term->term_taxonomy_id.'" aria-expanded="'.$collapse["aria"].'" 
                          aria-controls="flush-collapseOne">' . $term->name . '</button>
                    </h2>
                    <div id="flush-collapse-'.$taxonomy_name.'-'.$term->term_taxonomy_id.'" class="accordion-collapse '.$collapse["flush_class"].'" 
                        aria-labelledby="flush-collapse-'.$taxonomy_name.'-'.$term->term_taxonomy_id.'" data-bs-parent="#flush-collapse-'.$taxonomy_name.'-'.$term->term_taxonomy_id.'">
                      <div class="accordion-body p-0">'.criterio_sucesso_children( $taxonomy_name, $term->term_taxonomy_id ).'</div>
                    </div>
                </div>';


            $diretrizes .= sprintf('<div class="accordion accordion-flush" id="wrapper-flush-'.$taxonomy_name.'-'.$term->term_taxonomy_id.'">%s</div>', $accordion);
        }
    }

    return $diretrizes;
}

/**
 * Cria um nav para os critérios de sucesso, ordenados por ordem alfabética
 *
 * @param $taxonomy_name
 * @return string|null
 */
function criterios_nav( $taxonomy_name ): ?string
{
    $output = '<div class="accordion accordion-flush" id="principiosTree">%s</div>';

    $principios = '';

    // Termos de nivel 0 (Principios)
    $terms = get_terms( [
        'taxonomy'      => $taxonomy_name,
        'hide_empty'    => false,
        'parent'        => 0
    ] );

    if( is_countable( $terms ) && count( $terms )>0 ) {
        foreach ( $terms as $term ) {
            $collapse = [
                "btn_class"     => "collapsed",
                "flush_class"   => "collapse",
                "aria"          => "false"
            ];
            if (has_current_item($term->term_taxonomy_id, $term->taxonomy)) {
                $collapse["btn_class"]      = "";
                $collapse["flush_class"]    = "collapse show";
                $collapse["aria"]           = "true";
            }
            $principios .=
                '<div class="accordion-item">
                    <h2 class="accordion-header" id="flush-'.$taxonomy_name.'-'.$term->term_taxonomy_id.'">
                      <button class="accordion-button collapsed '.$collapse["btn_class"].'" type="button" 
                          data-bs-toggle="collapse" data-bs-target="#flush-collapse-'.$taxonomy_name.'-'.$term->term_taxonomy_id.'" aria-expanded="'.$collapse["flush_class"].'" 
                          aria-controls="flush-collapseOne">' . $term->name . '</button>
                    </h2>
                    <div id="flush-collapse-'.$taxonomy_name.'-'.$term->term_taxonomy_id.'" class="accordion-collapse '.$collapse["flush_class"].'" 
                        aria-labelledby="flush-collapse-'.$taxonomy_name.'-'.$term->term_taxonomy_id.'" data-bs-parent="#principiosTree">
                      <div class="accordion-body">'.principios_diretriz_nav_children( $term->term_taxonomy_id, $taxonomy_name).'</div>
                    </div>
                </div>';
        }
    }

    return sprintf( $output, $principios );
}

/**
 * Devolve o nome da tab do Advanced Custom Field usado nas tabs do critério de sucesso.
 *
 * @param $acf_name
 * @return string|bool
 */
function get_tab_label ($acf_name)
{

    // Se o nome do campo acf está vazio, devolve falso
    if(empty($acf_name)) return false;

    $field_name = $acf_name;
    $field      = get_field_object($field_name);

    // O campo não existe, devolve falso
    if(!$field) return false;

    // Devolve a etiqueta do campo
    return $field["label"];

}

function has_current_success_criteria($taxonomy, $id=0): bool {

    if(empty($id) || $id == 0) {
        $id = get_the_ID();
    }

    $current_item = get_the_terms($id, $taxonomy);

    return true;
}

/**
 * Cria uma lista de filtros com os termos de uma taxonomia
 *
 * @param   string $taxonomy_name
 * @return  string|null
 */
function print_taxonomy_filters( string $taxonomy_name ): ?string
{
    $taxonomy = get_taxonomy( $taxonomy_name );
    if( !$taxonomy ) return "";

    $filter_wrapper =
        '<fieldset class="wcag-filtros-wrapper ">
        <legend class="filtros-label">' . $taxonomy->label . '</legend>
            <div class="filtros-resultados">%s</div>            
        </fieldset>';

    $filters    = '';
    $terms      = get_terms( $taxonomy->name, ["hide_empty" => false] );

    if( is_countable( $terms ) && count( $terms )>0 ) {
        foreach ($terms as $term ) {
            $checked = ' checked';
            if( !empty( $_GET ) ) {
                if( array_key_exists( $taxonomy->name, $_GET ) ) {
                    $is_checked = in_array( $term->term_taxonomy_id, $_GET[$taxonomy->name]);
                    if( !$is_checked ) {
                        $checked = '';
                    }
                } else {
                    $checked = '';
                }
            }

            $tooltip = ( !empty( $term->description ) ) ? '<div class="term-descricao icon icon-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="'.$term->description.'"></div>' : "";

            $filters .=
                '<div class="form-check">
                      <input name="'.$taxonomy->name.'[]" class="form-check-input" 
                        type="checkbox" value="' . $term->term_taxonomy_id . '" 
                        id="' . $taxonomy_name.'-' . $term->term_taxonomy_id. '" '.$checked.'>
                      <label class="form-check-label" for="' . $taxonomy_name.'-' . $term->term_taxonomy_id. '">
                       ' . $term->name . '
                      </label>
                      ' . $tooltip . '
                  </div>';
        }
    }

    return sprintf($filter_wrapper, $filters);

}

/**
 * Função de callback para ajudar com a ordenação natural de ‘strings’
 *
 * @param $a
 * @param $b
 *
 * @return bool|int
 */
function natural_order($a, $b) {
    return version_compare($a["titulo"], $b["titulo"]);
}
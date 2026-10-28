<?php
require_once get_stylesheet_directory() . '/inc/github-tutos-sync.php';
require_once get_stylesheet_directory() . '/inc/security.php';
require_once get_stylesheet_directory() . '/inc/tutoriais.php';
require_once get_stylesheet_directory() . '/inc/publicacoes.php';
require_once get_stylesheet_directory() . '/inc/cookie-consent.php';
require_once get_stylesheet_directory() . '/inc/helper-functions.php';
require_once get_stylesheet_directory() . '/settings/index.php';
require_once get_stylesheet_directory() . '/inc/cron/index.php';

/**
 * Carrega a folha de estilos do tema filho.
 *
 * Prioridade definida a 11, para garantir que o estilo do tema filho sobrescreve o estilo do tema pai.
 * Principalmente, porque o Bootstrap é carregado com prioridade 10, e sobrescrevia alguns estilos do tema AMA.
 *
 * @return void
 */
function child_theme_enqueue_stylesheet(): void
{
    wp_enqueue_style(
        'parent-style',
        get_template_directory_uri().'/style.css',
        '',
        '1.0.1',
    );

    wp_enqueue_style(
        'www-a11y-theme-child-style',
        get_stylesheet_uri(),
        ['parent-style'],
        '1.0.1',
    );

    wp_enqueue_style(
        'acessibilidade-theme-style',
        get_stylesheet_directory_uri() . "/css/acessibilidade-theme.css",
        ['parent-style'],
        '1.0.1',
    );

}
add_action( 'wp_enqueue_scripts', 'child_theme_enqueue_stylesheet', 11 );

/**
 * Carrega ficheiros de funcionalidades.
 *
 * @return void
 */
function AMA_inlcudes(): void
{
    // Carrega os ficheiros com shortcodes
    include_once get_stylesheet_directory() . '/inc/shortcodes/index.php';

    // Carrega os ficheiros com funcções assíncronas
    include_once get_stylesheet_directory() . '/inc/ajax-actions/index.php';

    // Carrega os ficheiros do Mapa da Acessibilidade
    include_once get_stylesheet_directory() . '/mapa-acessibilidade/mapa-acessibilidade.php';

    wp_enqueue_script(
        "AccessMonitorValidador",
        get_stylesheet_directory_uri() . "/js/AccessMonitor.js",
        ["jquery"],
        "1.0.0",
    );

    // Ficheiros JS
    wp_enqueue_script(
        "AMA-js",
        get_stylesheet_directory_uri() . "/js/AMA.js",
        ["jquery"],
        "1.0.0",
    );

    $AMA_global_params = [
        'ajax_url'      => admin_url( 'admin-ajax.php' ),
        'current_url'   => get_permalink(),
    ];

    wp_localize_script(
    'AMA-js',
    'AMA',
        $AMA_global_params,
    );

    wp_enqueue_script(
        "post-pagination",
        get_stylesheet_directory_uri() . "/js/PostPagination.js",
        ["jquery", "AMA-js"]
    );

    wp_enqueue_script(
        "acessibilidade-index",
        get_stylesheet_directory_uri() . "/js/index.js",
        ["jquery"]
    );
}
add_action("init", "AMA_inlcudes");

/**
 * Páginas com lista AJAX do blogue no conteúdo (ex.: bloco HTML com id="articles_list")
 * não usam o template templates/blogue.php do pai, que injeta os inputs ocultos e chama
 * app.bloguePagination. Isto replica o necessário no rodapé quando o conteúdo o pede.
 */
function ama_blogue_list_inject_meta_and_script(): void
{
    if ( ! is_singular( 'page' ) ) {
        return;
    }

    global $post;
    if ( ! $post instanceof WP_Post ) {
        return;
    }

    if ( strpos( $post->post_content, 'articles_list' ) === false ) {
        return;
    }

    $counts = wp_count_posts( 'post' );
    $total  = isset( $counts->publish ) ? (int) $counts->publish : 0;
    $pages  = $total > 0 ? (int) max( 1, ceil( $total / 7 ) ) : 1;

    $ajax_url = admin_url( 'admin-ajax.php' );

    echo '<div class="visually-hidden" aria-hidden="true">';
    printf(
        '<input type="hidden" name="total_pages" id="total_pages" value="%d">',
        $pages
    );
    printf(
        '<input type="hidden" name="total_articles" id="total_acticles" value="%d">',
        $total
    );
    echo '<input type="hidden" name="current_page" id="current_page" value="1">';
    echo '</div>';
    ?>
    <script>
    jQuery(function () {
        if (typeof app === 'undefined') {
            return;
        }
        if (typeof app.init === 'function') {
            app.init();
        }
        if (typeof app.initSlick === 'function') {
            app.initSlick();
        }
        if (typeof app.initSlickResize === 'function') {
            app.initSlickResize();
        }
        if (typeof app.bloguePagination === 'function') {
            app.bloguePagination(<?php echo wp_json_encode( $ajax_url ); ?>);
        }
        if (typeof app.articlesHighlightClick === 'function') {
            app.articlesHighlightClick();
        }
    });
    </script>
    <?php
}

add_action( 'wp_footer', 'ama_blogue_list_inject_meta_and_script', 99 );


/**
 * Adiciona o índice de conteúdos de um artigo.
 *
 * Lê todos os títulos h2 e h3 com ID definido e cria um índice de conteúdos.
 *
 * @param $atts
 * @return string
 */
function ama_index_menu_2lvls( $atts = [] ) {

    $shortcode_atts = shortcode_atts(
        array(
            'esconder_numeracao' => false,
        ), $atts
    );

    $content = get_the_content();

    $list_tag = ($atts["esconder_numeracao"]) ? 'ul' : 'ol';

    // Match both h2 and h3 elements
    preg_match_all('@<h(2|3)[^>]*id=[\'"](.*?)[\'"][^>]*>(.*?)<\/h(2|3)>@i', $content, $matches, PREG_SET_ORDER);

    $menu = '';
    $previousTag = '';

    if ( !empty($matches) ) {
        $menu .= '<div class="indice">';
        $menu .= '<h2>Índice de conteúdos</h2>';
        $menu .= "<$list_tag>";
        $class = $shortcode_atts['esconder_numeracao'] ? ' class="hide-bullets"' : '';

        foreach ($matches as $match) {
            $tag     = $match[1];
            $id      = $match[2];
            $heading = $match[3];

            if ($tag == '2') {
                if ($previousTag == '3') {
                    // Close previous <ul> for h3 elements
                    $menu .= "</$list_tag>";
                }

                $menu .= '<li><a href="#' . $id . '">' . $heading . '</a>';
                $previousTag = '2';

            } elseif ($tag == '3') {

                if ($previousTag != '3') {
                    // Start a new <ul> for h3 elements
                    $menu .= "<$list_tag " . $class . '>';
                }

                $menu .= '<li><a href="#' . $id . '">' . $heading . '</a></li>';
                $previousTag = '3';
            }
        }

        if ($previousTag == '3') {
            // Close the last <ul> for h3 elements

            $menu .= "</$list_tag></li>";
        }
        $menu .= "</$list_tag>";
        $menu .= '</div>';
    }

    return $menu;
}
add_shortcode( 'indice_2lvls', 'ama_index_menu_2lvls' );


function enable_gutenberg_for_my_publicacoes_cb($current_status, $post_type) {
    // Replace 'your_cpt' with the slug of your custom post type
    if ($post_type === 'publicacoes') {
        return true;
    }
    return $current_status;
}
add_filter('use_block_editor_for_post_type', 'enable_gutenberg_for_my_publicacoes_cb', 10, 2);


function paginate_content_ama($max_pages = 1, $nav_aria_label = ""): ?string
{
    $output = '';

    // Obtém as ligações de paginação
    $page_links = paginate_links(
        [
            'total'     => $max_pages,
            'prev_text' => __('&lt;'),
            'next_text' => __('&gt;'),
            'type'      => 'array',
        ]
    );

    if( is_array( $page_links ) && count($page_links) > 0 ) {
        $pages = '';

        // Ligação para a 1ª página
        if (get_query_var('paged') > 1) {
            $first_page_link = paginate_links([
                'total' => $max_pages,
                'prev_text' => '&laquo;',
                'type' => 'array',
            ]);

            $pages .= sprintf('<li class="page-item first-page" aria-label="Primeira página">%s</li>', $first_page_link[0]);
        }

        // Add pagination links
        foreach ($page_links as $link) {
            // Verifica se a ligação é para a página atual e adiciona o atributo aria-current
            $aria_attrs = '';
            if (strpos($link, 'current') !== false) {
                $aria_attrs .= ' aria-current="page"';
                $link = strip_tags($link);
            }

            // Check if it's the next page
            if (strpos($link, 'next') !== false) {
                $link = str_replace('next page-numbers', 'next page-numbers', $link);
                $aria_attrs .= ' aria-label="Próxima página"';
            }

            // Check if it's the previous page
            if (strpos($link, 'prev') !== false) {
                $link = str_replace('next page-numbers', 'next page-numbers', $link);
                $aria_attrs .= ' aria-label="Página anterior"';
            }

            // Verifica se a ligação tem a classe dots
            if (strpos($link, 'dots') !== false) {
                $aria_attrs .= ' aria-hidden="true"';
            }

            // Adiciona a ligação à paginação
            $pages .= sprintf('<li class="page-item"%s>%s</li>', $aria_attrs, $link);
        }

        // Ligação para a última página
        if (get_query_var('paged') < $max_pages) {
            $last_page_link = paginate_links([
                'total' => $max_pages,
                'next_text' => "&raquo;", // Alterando para 'next_text' para a seta da direita
                'type' => 'array',
            ]);

            // Adiciona a ligação à paginação
            $pages .= '<li class="page-item last-page" aria-label="Última página"><a href="' . get_permalink(get_queried_object_id()) . 'page/' . $max_pages . '">&raquo;</a></li>';
        }

        // Output HTML
        $output .= sprintf('<nav aria-label="'.$nav_aria_label.'"><ul class="ama paginacao mt-5">%s</ul></nav>', $pages);

        return $output;
    } else {
        return null;
    }
}

// 1. Add the AJAX handler function

/**
 * AJAX handler to get all posts.
 *
 * @return void
 */
function ajax_get_all_posts(): void
{
    $attrs = [
        "total" => isset($_POST['total']) ? intval($_POST['total']) : 10,
    ];

    $current_page = isset($_POST['page']) ? intval($_POST['page']) : 1;

    $posts = new WP_Query([
        'post_type'         => 'post',
        'post_status'       => 'publish',
        'posts_per_page'    => $attrs['total'],
        'orderby'           => 'post_date',
        'order'             => 'DESC',
        'paged'             => $current_page
    ]);

    if (is_wp_error($posts)) {
        wp_send_json_error("Is error");
    }

    if(!$posts->have_posts()) {
        wp_send_json_error("No posts");
    }

    $output = '';

    while($posts->have_posts()) {
        $posts->the_post();
        ob_start();
        get_template_part('template-parts/post-list', 'item');
        $output .= ob_get_clean();
    }

    wp_reset_postdata();

    $output = sprintf('<ul class="post-list">%s</ul>', $output);
    //$output .= paginate_content_ama($posts->max_num_pages);
    $result = [
        'content'       => $output,
        'total_pages'   => $posts->max_num_pages,
        'pagination'    => paginate_content_ama($posts->max_num_pages),
    ];

    wp_send_json_success($result);
}
add_action('wp_ajax_get_all_posts', 'ajax_get_all_posts');
add_action('wp_ajax_nopriv_get_all_posts', 'ajax_get_all_posts');

/**
 * Atualiza o número de visualizações de um artigo.
 *
 * @param $post_id
 * @return void
 */
function update_post_views($post_id): void
{
    $views = get_post_meta($post_id, 'visualizacoes', FALSE);
    $views = intval($views[0])+1;
    update_post_meta(get_the_ID(), 'visualizacoes', $views);
}

/**
 * Obtém os artigos relacionados.
 *
 * @param array $categories_IDs
 * @param int $post_ID
 * @return void
 */
function get_related_articles(array $categories_IDs, int $post_ID): void
{
    if(empty($categories_IDs) || empty($post_ID)) {
        return;
    }

    $output = '';

    $related_articles = new WP_Query(array(
        'post_type'         => 'post',
        'posts_per_page'    => 5,
        'order'             => 'DESC',
        'meta_key'          => 'destaque',
        'orderby'           => 'destaque',
        'post_status'       => 'publish',
        'category__in'      =>  $categories_IDs,
    ));
    $aux = 0;
    foreach($related_articles->posts as $related){
        if($related->ID != $post_ID){
            if($aux < 4){
                $post_date = $related->post_date;
                $output .= '<li class="item">
                                <h3><a href="'.get_permalink($related->ID).'">'.$related->post_title.'</a></h3>
                                <div class="post-date">'.get_the_date("d \d\\e F, Y", $related->ID).'</div>
                            </li>';
            }
            $aux++;
        }
        else{
            $aux--;
        }
    }
    echo sprintf('<ul class="sidebar-list">%s</ul>', $output);
}

function get_articles_highlights()
{
    $output = '';
    $articles_params = array(
        'limit'     => 4,
        'orderby'   => 'destaque.meta_value DESC, post_date DESC',
        'post_status' => 'publish'
    );
    $articles = pods( 'post' , $articles_params);
    while ( $articles->fetch() ){
        $post_date = $articles->display('post_date');
        $date = get_the_date($format="",  $articles->display('ID'));
        $highlight_category = get_the_category($articles->display('ID'));
        $output .= '<li class="item">
                        <h3><a href="'.get_permalink($articles->display('ID')).'">'.$articles->display("post_title").'</a></h3>
                        <div class="post-date">'.get_the_date("d \d\\e F, Y", $articles->display('ID')).'</div>
                    </li>';
    }
    echo sprintf('<ul class="sidebar-list">%s</ul>', $output);
}

/**
 * Adiciona a paginação de artigos.
 *
 * @param WP_Query $query
 * @param int $current_page
 * @return string|null
 */
function AMA_pagination_v2(WP_Query $query, int $current_page = 1): ?string
{
    $total_pages    = $query->max_num_pages;
    $total_posts    = $query->found_posts;
    $posts_per_page = $query->get('posts_per_page');
    $next_page      = (($current_page + 1) > $total_pages) ? $total_pages : $current_page + 1;
    $prev_page      = ($current_page >= 2) ? ($current_page - 1) : 1;

    $html = '';
    ob_start(); ?>
    <div class="container-fluid paginacao-artigos px-0 mt-4">
        <div class="row">
            <div class="col-12">
                <?php

                if($current_page == 1) {
                    $x = 1;
                    $y = $posts_per_page;
                }
                else{
                    $x = ($current_page - 1) * $posts_per_page + 1;
                    $y = $current_page * $posts_per_page;
                }

                echo sprintf('<p class="total-posts">A mostrar %d-%d de %d artigos</p>', $x, $y, $total_posts);
                ?>
            </div>
            <div class="col-12">
                <ul class="paginas" data-categoria="acessibilidade">
                    <li>
                        <?php
                        if($current_page == 1) {
                            echo '<button aria-label="Primeira página" class="page-item first" data-pagina="1" disabled></button>';
                        } else {
                            echo '<button aria-label="Primeira página" class="page-item first" data-pagina="1"></button>';
                        }
                        ?>
                    </li>
                    <li>
                        <?php
                        if($current_page == 1) {
                            echo '<button aria-label="Página anterior" class="page-item prev" data-pagina="1" disabled></button>';
                        } else {
                            echo '<button aria-label="Página anterior" class="page-item prev" data-pagina="'.$prev_page.'"></button>';
                        }

                        ?>
                    </li>
                    <?php
                    // Determine the range of numeric buttons to display
                    $start = max(1, $current_page - 1);
                    $end = min($total_pages, $current_page + 1);

                    if ($start > 1) {
                        echo '<li><button class="page-item" data-pagina="1">1</button></li>';
                    }

                    for ($i = $start; $i <= $end; $i++) {
                        $active = ($i == $current_page) ? ' aria-current="page"' : '';
                        echo sprintf('<li><button class="page-item" data-pagina="%d"%s>%d</button></li>', $i, $active, $i);
                    }

                    if ($end < $total_pages) {
                        echo sprintf('<li><button class="page-item" data-pagina="%d">%d</button></li>', $total_pages, $total_pages);
                    }
                    ?>
                    <li>
                        <?php
                        if($current_page == $total_pages) {
                            echo '<button aria-label="Página seguinte" class="page-item next" data-pagina="'.$total_pages.'" disabled></button>';
                        } else {
                            echo '<button aria-label="Página seguinte" class="page-item next" data-pagina="'.$next_page.'"></button>';
                        }
                        ?>
                    </li>
                    <li>
                        <?php
                        if($current_page == $total_pages) {
                            echo '<button aria-label="Útima página" class="page-item last" data-pagina="'.$total_pages.'" disabled></button>';
                        } else {
                            echo '<button aria-label="Útima página" class="page-item last" data-pagina="'.$total_pages.'"></button>';
                        }
                        ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <?php
    $html .= ob_get_clean();

    return $html;
}
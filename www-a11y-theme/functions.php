<?php
// Exit if accessed directly.
defined('ABSPATH') || exit;
// Enable HTML5 support for WordPress elements
add_theme_support('html5', ['comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'style', 'script']);

function ama_scripts()
{
    $the_theme = wp_get_theme();
    $theme_version = $the_theme->get('Version');

    wp_enqueue_style('bootstrap-5-css', '//cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css', array(), '5.0.2');
    wp_enqueue_style('ama-style', get_stylesheet_uri(), array(), $theme_version);

    wp_enqueue_script('bootstrap-5-js-bundle', '//cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js', array(), '5.0.2');
    wp_enqueue_script('ama-scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), $theme_version);
}
add_action('wp_enqueue_scripts', 'ama_scripts');

add_post_type_support('page', 'excerpt');

function ama_theme_setup()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');

    register_nav_menus(
        array(
            'primary' => 'Menu principal',
            'footer' => 'Menu de rodapé',
        )
    );
}
add_action('after_setup_theme', 'ama_theme_setup');

function ama_widgets()
{
    register_sidebar(array(
        'name'          => 'Title',
        'id'            => 'title',
        'before_widget' => '<div class="site-title">',
        'after_widget'  => '</div>',
        'before_title'  => '',
        'after_title'   => '',
    ));

    register_sidebar(array(
        'name'          => 'Description',
        'id'            => 'description',
        'before_widget' => '<div class="site-description">',
        'after_widget'  => '</div>',
        'before_title'  => '',
        'after_title'   => '',
    ));

    register_sidebar(array(
        'name'          => 'Title Ecossistema AMA',
        'id'            => 'title-ecossistema-ama',
        'before_widget' => '<div class="title-ecosssistema-ama">',
        'after_widget'  => '</div>',
        'before_title'  => '',
        'after_title'   => '',
    ));

    register_sidebar(array(
        'name'          => 'Description Ecossistema AMA',
        'id'            => 'description-ecossistema-ama',
        'before_widget' => '<div class="description-ecossistema-ama">',
        'after_widget'  => '</div>',
        'before_title'  => '',
        'after_title'   => '',
    ));

    register_sidebar(array(
        'name'          => 'Left Column Ecossistema AMA',
        'id'            => 'left-column-ecossistema-ama',
        'before_widget' => '<div class="left-column-ecossistema-ama">',
        'after_widget'  => '</div>',
        'before_title'  => '',
        'after_title'   => '',
    ));

    register_sidebar(array(
        'name'          => 'Center Column Ecossistema AMA',
        'id'            => 'center-column-ecossistema-ama',
        'before_widget' => '<div class="center-column-ecossistema-ama">',
        'after_widget'  => '</div>',
        'before_title'  => '',
        'after_title'   => '',
    ));

    register_sidebar(array(
        'name'          => 'Right Column Ecossistema AMA',
        'id'            => 'right-column-ecossistema-ama',
        'before_widget' => '<div class="right-column-ecossistema-ama">',
        'after_widget'  => '</div>',
        'before_title'  => '',
        'after_title'   => '',
    ));

    register_sidebar(array(
        'name'          => 'Footer',
        'id'            => 'footer',
        'before_widget' => '<div class="footer-logo">',
        'after_widget'  => '</div>',
        'before_title'  => '',
        'after_title'   => '',
    ));

    register_sidebar(array(
        'name'          => 'Copyright',
        'id'            => 'copyright',
        'before_widget' => '<div class="copyright">',
        'after_widget'  => '</div>',
        'before_title'  => '',
        'after_title'   => '',
    ));
}
add_action('widgets_init', 'ama_widgets');

function ama_index_menu($atts = array())
{
    $atts = array_change_key_case((array) $atts, CASE_LOWER);

    $shortcode_atts = shortcode_atts(
        array(
            'esconder_numeracao' => false,
        ),
        $atts
    );

    $content = get_the_content();
    //$count = substr_count( $content, '<h2 id="');
    $count = substr_count($content, '<h2 ');

    $menu = '';

    if ($count > 0) {
        $menu .= '<div class="sidebar-menu">';
        $menu .= '<h2>Índice de conteúdos</h2>';

        // Check h2 elements with an ID set
        preg_match_all('@<h2[^>]*id=[\'"](.*?)[\'"][^>]*>(.*?)<\/h2>@i', $content, $matches);
        $hrefs      = $matches[1];
        $headings   = $matches[2];


        $class = $shortcode_atts['esconder_numeracao'] ? ' class="hide-bullets"' : '';

        $menu .= '<ol' . $class . '>';

        for ($i = 0; $i < count($headings); $i++) {
            $menu .= '<li><a href="#' . $hrefs[$i] . '">' . $headings[$i] . '</a></li>';
        }

        $menu .= '</ol>';
        $menu .= '</div>';
    }

    return $menu;
}
add_shortcode('indice', 'ama_index_menu');
function enqueue_slider_styles()
{
    wp_enqueue_style('slider-style', get_template_directory_uri() . '/custom-slider/slider.css');
}
add_action('wp_enqueue_scripts', 'enqueue_slider_styles');

add_action('wp_footer', function () {
    wp_dequeue_style('core-block-supports');
});

include 'inc/indicadores.php';

function ama_pagination($args = [])
{

    // if ( $GLOBALS['wp_query']->max_num_pages <= 1 ) return;

    $args = wp_parse_args($args, [
        'mid_size'           => 2,
        'prev_next'          => true,
        'prev_text'          => '<span class="icon-arrow-drop arrow-left" aria-hidden="true"></span>',
        'next_text'          => '<span class="icon-arrow-drop arrow-right" aria-hidden="true"></span>',
        'screen_reader_text' => 'resultados pesquisa',
        'type'               => 'array',
        'current'            => max(1, get_query_var('paged')),
    ]);

    $links = paginate_links($args);

?>
    <nav class="mt-5" aria-label="Paginação <?php echo $args['screen_reader_text']; ?>">
        <ul class="pagination">
            <?php
            foreach ($links as $key => $link) { ?>
                <li class="page-item <?php echo strpos($link, 'current') ? 'active' : '' ?>">
                    <?php echo str_replace('page-numbers', 'page-link', $link); ?>
                </li>
            <?php } ?>
        </ul>
    </nav>
<?php
}

/**
 * Adiciona suporte a cores personalizadas no editor de blocos.
 *
 * @return void
 */
function ama_theme_color_support(): void
{
    $custom_color_palette = array(
        [
            'name'  => __('Primaria', 'ama'),
            'slug'  => 'primaria',
            'color' => '#333399',
        ],
        [
            'name'  => __('Primaria Escura', 'ama'),
            'slug'  => 'primaria-escura',
            'color' => '#272777',
        ],
        [
            'name'  => __('Secundaria', 'ama'),
            'slug'  => 'secundaria',
            'color' => '#b1e4b2',
        ],
        [
            'name'  => __('Terciaria', 'ama'),
            'slug'  => 'terciaria',
            'color' => '#edeceb',
        ],
        [
            'name'  => __('Prata', 'ama'),
            'slug'  => 'prata',
            'color' => '#c2c2c2',
        ],
        [
            'name'  => __('Quaternaria', 'ama'),
            'slug'  => 'quaternaria',
            'color' => '#f0a502',
        ],
        [
            'name'  => __('Quaternaria light', 'ama'),
            'slug'  => 'quaternaria-light',
            'color' => '#efc256',
        ],
        [
            'name'  => __('Quinaria', 'ama'),
            'slug'  => 'quinaria',
            'color' => '#b6dcf6',
        ],
        [
            'name'  => __('Senaria', 'ama'),
            'slug'  => 'senaria',
            'color' => '#a56140',
        ],
        [
            'name'  => __('Senaria light', 'ama'),
            'slug'  => 'senaria-light',
            'color' => '#bc927c',
        ],
        [
            'name'  => __('preto', 'ama'),
            'slug'  => 'preto',
            'color' => '#000000',
        ],
        [
            'name'  => __('branco', 'ama'),
            'slug'  => 'branco',
            'color' => '#ffffff',
        ],
        [
            'name'  => __('ouro-light', 'ama'),
            'slug'  => 'ouro-light',
            'color' => '#FFE19F',
        ],
        [
            'name'  => __('prata-light', 'ama'),
            'slug'  => 'prata-light',
            'color' => '#F6F6F6',
        ],
        [
            'name'  => __('bronze-light', 'ama'),
            'slug'  => 'bronze-light',
            'color' => '#E8D7CF',
        ],
        [
            'name'  => __('vermelho escuro', 'ama'),
            'slug'  => 'vermelho-escuro',
            'color' => '#700723',
        ],
        [
            'name'  => __('lilás pálido', 'ama'),
            'slug'  => 'lilas-palido',
            'color' => '#FAF0F9',
        ],
        [
            'name'  => __('lilás gelo', 'ama'),
            'slug'  => 'lilas-gelo',
            'color' => '#F0F0FA',
        ],
    );

    add_theme_support(
        'editor-color-palette',
        $custom_color_palette
    );
}
add_action('after_setup_theme', 'ama_theme_color_support');

/**
 * Remove o cardinal das classes dos blocos, para não cortar o nome duma classe a meio e crie um ID inválido.
 *
 * @param array $classes
 * @return array|null
 */
function modify_block_classes($classes, $block): ?array
{
    foreach ($classes as &$class) {
        $class = str_replace('has-#', 'has-', $class);
    }
    return $classes;
}
add_filter('block_class', 'modify_block_classes', 10, 2);


//TODO: On theme activation, verificar se existem os posts to tipo lazy block, se não existirem, criar através do import do ficheiro JSON que esta na pasta do tema > blocks > imports
function check_and_create_post_on_theme_activation()
{
    // Replace 'YOUR_POST_TITLE' with the title of the post you want to check/create
    $post_title = 'YOUR_POST_TITLE';

    // Check if the post exists
    $post = get_page_by_title($post_title, OBJECT, 'post');

    // If the post doesn't exist, create it
    if (!$post) {
        // Replace 'YOUR_POST_CONTENT' with the content of the post
        $post_content = 'YOUR_POST_CONTENT';

        $new_post = array(
            'post_title'   => $post_title,
            'post_content' => $post_content,
            'post_status'  => 'publish',
            'post_author'  => 1, // Replace with the author ID if needed
            'post_type'    => 'post',
        );

        // Insert the post into the database
        $post_id = wp_insert_post($new_post);

        if ($post_id) {
            // The post was created successfully
            // You can perform additional actions here if needed
        } else {
            // There was an error creating the post
            // You can handle the error here if needed
        }
    }
}
//add_action('after_switch_theme', 'check_and_create_post_on_theme_activation');

/**
 * ‘Script’ usado para mostrar a mensagens de erro personalizadas no CF7.
 *
 * Verifica se o shortcode de formulário CF7 foi chamado no post/página.
 * Deteta um ‘input’ inválido e coloca a mensagem de erro do elemento
 * "span.mensagem-erro" no campo de erro ".wpcf7-not-valid-tip"
 *
 * @return void
 */
function enqueue_ama_script_for_cf7()
{
    global $post;
    if (is_a($post, 'WP_Post') && has_shortcode($post->post_content, 'contact-form-7')) {
        wp_enqueue_script(
            'ama-cf7-script',
            get_template_directory_uri() . '/js/cf7.js',
            ['jquery'],
            '',
            true // Enqueue in the footer
        );
    }
}
add_action('wp_enqueue_scripts', 'enqueue_ama_script_for_cf7');

function AMA_get_search_form(): string
{
    ob_start();
?>
    <form role="search" method="get" class="search-form my-3" action="<?= site_url() ?>">
        <label for="search-field" class="mb-2">Pesquisar por:</label>
        <div class="search input-group">
            <input id="search-field" type="search" class="search-field" placeholder="Pesquisar por:" value="" name="s">
            <button type="submit" class="search-submit">
                <span class="icon-search icon" aria-hidden="true"></span>
                <span class="visually-hidden">Pesquisar</span>
            </button>
        </div>
    </form>
<?php
    return ob_get_clean();
}

/**
 *
 * Adiciona o índice de conteúdos de um artigo.
 *
 * Lê todos os títulos h2 e h3 com ID definido e cria um índice de conteúdos.
 *
 * @param $atts
 * @return string
 */

if (!function_exists("ama_index_menu_2lvls")) {
    function ama_index_menu_2lvls($atts = []): ?string
    {

        $shortcode_atts = shortcode_atts(
            array(
                'esconder_numeracao' => false,
            ),
            $atts
        );

        $content = get_the_content();

        $list_tag = ($atts["esconder_numeracao"]) ? 'ul' : 'ol';

        // Match both h2 and h3 elements
        preg_match_all('@<h(2|3)[^>]*id=[\'"](.*?)[\'"][^>]*>(.*?)<\/h(2|3)>@i', $content, $matches, PREG_SET_ORDER);

        $menu = '';
        $previousTag = '';

        if (!empty($matches)) {
            $menu .= '<div class="indice">';
            $menu .= '<h2 class="mb-4">Índice de conteúdos</h2>';
            $menu .= '<' . $list_tag . ' class="indice">';
            $class = $shortcode_atts['esconder_numeracao'] ? ' class="hide-bullets"' : 'class="custom-list"';
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
}

add_shortcode('indice_2lvls', 'ama_index_menu_2lvls');


/**
 * Devolve o ID do campo.
 * 
 * @param mixed $field_id
 * @return string|null
 */
function get_field_key_by_id($field_id)
{
    // Use the FrmField::get_key_by_id method to get the field key
    $field_key = FrmField::get_key_by_id(str_replace('field', '', $field_id));
    return $field_key;
}

/**
 * Compila todos os erros do formulário em uma mensagem resumo.
 * 
 * Junta as mensagens de erro dos campos na mensagem de erro do formulário do
 * Formidable Forms. A mensagem de erro é devolvida com a etiqueta do campo e é clicável, para
 * levar o utilizador diretamente ao campo que precisa ser corrigido.
 *
 * @param $invalid_msg
 * @param $args
 */
function change_frm_form_error_message($invalid_msg, $args)
{
    if (is_array($args) && array_key_exists("errors", $args) && is_array($args["errors"])) {
        $errors = '';

        //Junta todas as mensagens de erro dos campos
        foreach ($args["errors"] as $field_id => $error_message) {
            $field_html_id = get_field_key_by_id($field_id);
            $fieldtype = FrmField::get_type($field_html_id);

            // Se o campo for um checkbox, o ID do campo é acrescentado com '-0', para não ter um ID errado
            if ($fieldtype == 'checkbox') {
                $field_html_id .= '-0';
            }

            // Devolve a etiqueta do campo
            $field = FrmField::getOne($field_html_id);

            if ($fieldtype == 'checkbox') {
                $errors .= "<li><a class='error-message' data-field-id='field_" . $field_html_id . "'>$error_message</a></li>";
            } else {
                $errors .= "<li>" . $field->name . ": <a class='error-message' data-field-id='field_" . $field_html_id . "'>$error_message</a></li>";
            }
        }
        return "<h2 class='mb-4'>Ocorreu um erro na submissão do formulário</h2>" . '<p class="mb-3">O erros surgem assinalados abaixo:</p>' . sprintf("<ul>%s</ul>", $errors);
    }
    return $invalid_msg;
}
add_filter('frm_invalid_error_message', 'change_frm_form_error_message', 10, 2);



/**
 * Remove o atributo 'type' dos ‘scripts’.
 *
 * O atributo 'type' é desnecessário para os ‘scripts’, uma vez que o MIME type padrão para ‘scripts’ é 'text/javascript'.
 *
 * @param $tag
 * @param $handle
 * @param $src
 * @return string|null
 */
function remove_type_attribute_from_scripts($tag, $handle, $src): ?string
{
    return preg_replace("/\s+type=['\"]text\/javascript['\"]/", '', $tag);
}
add_filter('script_loader_tag', 'remove_type_attribute_from_scripts', 10, 3);


/**
 * Remove o atributo 'type' dos ‘style’.
 *
 * O atributo 'type' é desnecessário para os ‘style’, uma vez que o MIME type padrão para ‘style’ é 'text/css'.
 *
 * @param $tag
 * @param $handle
 * @param $href
 * @return string|null
 */
function remove_type_attribute_from_styles($tag, $handle, $href)
{
    return preg_replace("/\s+type=['\"]text\/css['\"]/", '', $tag);
}
add_filter('style_loader_tag', 'remove_type_attribute_from_styles', 10, 3);

/**
 * Impede que seja impresso no <head> o CSS gerado pelo WordPress para as imagens responsivas.
 * O CSS gerado pelo WordPress usa uma propriedade CSS que não é suportada por todos os navegadores
 * e dá erros de validação no W3C Validator e no RocketValidator.
 */
add_filter('wp_img_tag_add_auto_sizes', '__return_false');

/**
 * Remove o <script> e <style> de emojis do WordPress.
 */
remove_action('wp_head', 'print_emoji_detection_script', 10);
remove_action('wp_print_styles', 'print_emoji_styles', 10);


//// / / | Deprecated slashes from HTML elements | \ \ \\\\


/**
 * Remove a barra de fecho de tags <meta> e <link>.
 *
 * @param string $buffer
 * @return string
 */
function remove_closing_slash_meta_tags_buffer($buffer)
{
    return str_replace(' />', '>', $buffer);
}

/**
 * Começa a ‘output buffering’ para remover as barras de fecho das tags <meta> e <link>.
 * Usa a função ‘remove_closing_slash_meta_tags_buffer’ para remover as barras de fecho das tags <meta> e <link>.
 * 
 * @return void
 */
function start_output_buffering()
{
    ob_start('remove_closing_slash_meta_tags_buffer');
}
add_action('template_redirect', 'start_output_buffering');

/**
 * Remove the <link> for the XMLRPC file of WordPress.
 */
remove_action('wp_head', 'rsd_link');

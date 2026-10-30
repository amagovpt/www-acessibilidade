<?php
defined('ABSPATH') || exit;

/**
 * Publicações em páginas do WordPress (issue #12).
 *
 * Publicações                    ← página raiz (slug "publicacoes"), lista as fichas com [ama_publicacoes]
 *   ├── Ficha da publicação A    ← página com secções livres, feita a partir do padrão "Ficha da publicação"
 *   └── Ficha da publicação N
 *
 * As fichas usam o page.php, por isso o breadcrumb é o das páginas (Início › Publicações › Ficha).
 * Não há campos por secção: o padrão "Ficha da publicação" cria as secções típicas, cada uma
 * com a estrutura <section><h2>…</h2> elementos livres </section>, e cada secção existe também
 * como padrão próprio para se poder voltar a inserir.
 *
 * Os formatos HTML das publicações (p. ex. os relatórios de monitorização) continuam a ser
 * feitos fora do WordPress, numa pasta do servidor; a ficha só tem a ligação para eles.
 */

/**
 * ID da página raiz das publicações.
 */
function ama_publicacoes_root_id(): int
{
    static $root_id = null;

    if ($root_id === null) {
        $root    = get_page_by_path((string) apply_filters('ama_publicacoes_root_path', 'publicacoes'));
        $root_id = $root instanceof WP_Post ? $root->ID : 0;
    }

    return $root_id;
}

/**
 * Indica se a página é uma ficha de publicação (filha direta de "Publicações").
 */
function ama_is_ficha_publicacao(int $post_id): bool
{
    $root_id = ama_publicacoes_root_id();

    return $root_id && $post_id && get_post_type($post_id) === 'page' && (int) wp_get_post_parent_id($post_id) === $root_id;
}

/**
 * Secções da ficha: título do <h2> e blocos de exemplo que vão dentro da secção.
 */
function ama_publicacao_secoes(): array
{
    return [
        'referencia' => [
            'titulo'   => 'Referência (APA)',
            'conteudo' => '<!-- wp:paragraph -->
<p>Apelido, N., &amp; Apelido, N. (Ano). <em>Título da publicação</em>. Editor. https://acessibilidade.gov.pt/…</p>
<!-- /wp:paragraph -->',
        ],
        'formatos' => [
            'titulo'   => 'Formatos disponíveis',
            'conteudo' => '<!-- wp:list -->
<ul class="wp-block-list"><!-- wp:list-item -->
<li>HTML: ligação para a versão HTML, na pasta do servidor</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>PDF (tamanho do ficheiro)</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>EPUB (tamanho do ficheiro)</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->',
        ],
        'sumario' => [
            'titulo'   => 'Sumário executivo',
            'conteudo' => '<!-- wp:paragraph -->
<p>Resumo da publicação: objetivo, metodologia e principais conclusões.</p>
<!-- /wp:paragraph -->',
        ],
        'indice' => [
            'titulo'   => 'Índice',
            'conteudo' => '<!-- wp:list {"ordered":true} -->
<ol class="wp-block-list"><!-- wp:list-item -->
<li>Introdução</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Capítulo<!-- wp:list {"ordered":true} -->
<ol class="wp-block-list"><!-- wp:list-item -->
<li>Secção</li>
<!-- /wp:list-item --></ol>
<!-- /wp:list --></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Conclusões</li>
<!-- /wp:list-item --></ol>
<!-- /wp:list -->',
        ],
    ];
}

/**
 * Marcação de blocos de uma secção: um Grupo com a etiqueta <section> e um título H2.
 */
function ama_publicacao_secao_markup(array $secao): string
{
    return '<!-- wp:group {"tagName":"section"} -->
<section class="wp-block-group"><!-- wp:heading -->
<h2 class="wp-block-heading">' . esc_html($secao['titulo']) . '</h2>
<!-- /wp:heading -->

' . $secao['conteudo'] . '</section>
<!-- /wp:group -->';
}

/**
 * Padrões do editor: a ficha completa (proposta ao criar uma página) e cada secção em separado.
 */
function ama_publicacoes_register_patterns(): void
{
    register_block_pattern_category('ama-publicacoes', ['label' => 'Publicações']);

    $secoes = ama_publicacao_secoes();

    register_block_pattern('ama/ficha-publicacao', [
        'title'       => 'Ficha da publicação',
        'description' => 'Referência APA, formatos disponíveis, sumário executivo e índice, cada um numa secção com título H2.',
        'categories'  => ['ama-publicacoes'],
        'blockTypes'  => ['core/post-content'],
        'postTypes'   => ['page'],
        'content'     => implode("\n\n", array_map('ama_publicacao_secao_markup', $secoes)),
    ]);

    foreach ($secoes as $slug => $secao) {
        register_block_pattern('ama/publicacao-' . $slug, [
            'title'      => 'Publicação: ' . $secao['titulo'],
            'categories' => ['ama-publicacoes'],
            'content'    => ama_publicacao_secao_markup($secao),
        ]);
    }
}
add_action('init', 'ama_publicacoes_register_patterns');

/**
 * Nas fichas, as secções ficam <section><h2>…</h2>…</section>, sem o
 * <div class="wp-block-group__inner-container"> que o WordPress acrescenta
 * aos grupos nos temas sem theme.json.
 */
function ama_publicacao_section_sem_inner_container(string $block_content, array $block): string
{
    if (
        ($block['attrs']['tagName'] ?? '') === 'section'
        && doing_filter('the_content')
        && ama_is_ficha_publicacao((int) get_the_ID())
        && remove_filter('render_block_core/group', 'wp_restore_group_inner_container', 10)
    ) {
        add_filter('render_block_core/group', 'ama_publicacao_restore_inner_container_filter', 11);
    }

    return $block_content;
}
add_filter('render_block_core/group', 'ama_publicacao_section_sem_inner_container', 9, 2);

/**
 * Volta a ligar o filtro do WordPress logo a seguir à secção.
 */
function ama_publicacao_restore_inner_container_filter(string $block_content): string
{
    remove_filter('render_block_core/group', 'ama_publicacao_restore_inner_container_filter', 11);
    add_filter('render_block_core/group', 'wp_restore_group_inner_container', 10, 2);

    return $block_content;
}

/**
 * Publicações publicadas para a página agregadora (issue #17): as fichas em páginas
 * (filhas diretas de "Publicações", pela "Ordem" e depois da mais recente para a mais
 * antiga) e as publicações antigas (tipo de conteúdo "publicacoes"), enquanto não forem
 * migradas. Cada item: título, ligação, descrição, categoria (taxonomia
 * "categoria_publicacao"), destaque, ícone e data.
 */
function ama_publicacoes_items(): array
{
    $root_id = ama_publicacoes_root_id();
    $posts   = $root_id ? get_posts([
        'post_type'      => 'page',
        'post_parent'    => $root_id,
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => ['menu_order' => 'ASC', 'date' => 'DESC'],
    ]) : [];

    if (post_type_exists('publicacoes')) {
        $posts = array_merge($posts, get_posts([
            'post_type'      => 'publicacoes',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'orderby'        => 'date',
            'order'          => 'DESC',
        ]));
    }

    $items = [];
    foreach ($posts as $post) {
        $is_page = $post->post_type === 'page';
        $terms   = taxonomy_exists('categoria_publicacao') ? get_the_terms($post, 'categoria_publicacao') : false;

        // Ícone do cartão: imagem de destaque da ficha; nas antigas, o campo "icone" do Pods.
        $icon_id = $is_page ? (int) get_post_thumbnail_id($post) : (int) get_post_meta($post->ID, 'icone', true);
        $icon    = $icon_id ? wp_get_attachment_image($icon_id, 'medium', false, ['class' => 'icon_card', 'alt' => '', 'aria-hidden' => 'true']) : '';

        $items[] = [
            'title'       => get_the_title($post),
            'url'         => get_permalink($post),
            'description' => $is_page ? (has_excerpt($post) ? get_the_excerpt($post) : '') : html_entity_decode(wp_strip_all_tags((string) get_post_meta($post->ID, 'descricao', true)), ENT_QUOTES, 'UTF-8'),
            'category'    => is_array($terms) && $terms ? $terms[0] : null,
            'destaque'    => (string) get_post_meta($post->ID, $is_page ? 'ama_publicacao_destaque' : 'destaque', true) === '1',
            'icon'        => $icon ?: '<div aria-hidden="true" class="icon-xl-law"></div>',
            'date'        => $post->post_date_gmt,
        ];
    }

    return $items;
}

/**
 * [ama_publicacoes]: página agregadora das publicações, com o layout da página antiga.
 *
 * - 3 cartões "em destaque": as marcadas como destaque e, a seguir, as mais recentes;
 * - uma secção por categoria (por ordem alfabética), com a descrição da categoria e as
 *   publicações em duas colunas, cada uma com a descrição por baixo do título;
 * - as publicações sem categoria ficam no fim, em "Outras publicações".
 */
function ama_publicacoes_shortcode(): string
{
    $items = ama_publicacoes_items();
    if (!$items) {
        return '';
    }

    $highlights = $items;
    usort($highlights, static fn(array $a, array $b): int => [$b['destaque'], $b['date']] <=> [$a['destaque'], $a['date']]);

    $cards = '';
    foreach (array_slice($highlights, 0, 3) as $item) {
        $cards .= sprintf(
            '<li class="card-highlight"><div class="card-body row"><div class="col-12">%s<h3 class="card-title"><a href="%s">%s</a></h3></div></div>'
            . '<div class="card-footer">%s</div></li>',
            $item['category'] ? '<p class="card-text">' . esc_html($item['category']->name) . '</p>' : '',
            esc_url($item['url']),
            esc_html($item['title']),
            $item['icon']
        );
    }

    $groups = [];
    $others = [];
    foreach ($items as $item) {
        if ($item['category']) {
            $groups[$item['category']->term_id][] = $item;
        } else {
            $others[] = $item;
        }
    }
    uasort($groups, static fn(array $a, array $b): int => strcasecmp(remove_accents($a[0]['category']->name), remove_accents($b[0]['category']->name)));
    if ($others) {
        $groups[0] = $others;
    }

    $html = '<section class="publicacoes-destaque"><h2 class="visually-hidden">Publicações em destaque</h2>'
        . '<ul class="list-unstyled grid grid-md-3 gap-30">' . $cards . '</ul></section>';

    foreach ($groups as $group) {
        $category = $group[0]['category'];

        $list = '';
        foreach ($group as $item) {
            $list .= sprintf(
                '<li><a href="%s">%s</a>%s</li>',
                esc_url($item['url']),
                esc_html($item['title']),
                $item['description'] !== '' ? '<span class="d-block small">' . esc_html($item['description']) . '</span>' : ''
            );
        }

        $html .= '<section class="publicacoes-categoria">'
            . '<h2>' . esc_html($category ? $category->name : 'Outras publicações') . '</h2>'
            . ($category && $category->description !== '' ? '<p class="small">' . esc_html($category->description) . '</p>' : '')
            . '<ul class="colunas-1 colunas-md-2 ama-list">' . $list . '</ul>'
            . '</section>';
    }

    return $html;
}
add_shortcode('ama_publicacoes', 'ama_publicacoes_shortcode');

/**
 * As fichas também usam a taxonomia "categoria_publicacao" (criada no Pods para as
 * publicações antigas).
 */
function ama_publicacoes_register_taxonomy(): void
{
    if (taxonomy_exists('categoria_publicacao')) {
        register_taxonomy_for_object_type('categoria_publicacao', 'page');
    }
}
add_action('init', 'ama_publicacoes_register_taxonomy', 99);

/**
 * Caixa "Publicação" no editor das fichas: categoria e destaque na página agregadora.
 */
function ama_publicacoes_add_meta_box(WP_Post $post): void
{
    if (!ama_is_ficha_publicacao($post->ID) || !taxonomy_exists('categoria_publicacao')) {
        return;
    }

    add_meta_box('ama-publicacao', 'Publicação', 'ama_publicacoes_meta_box', 'page', 'side');
}
add_action('add_meta_boxes_page', 'ama_publicacoes_add_meta_box');

function ama_publicacoes_meta_box(WP_Post $post): void
{
    $terms = get_the_terms($post, 'categoria_publicacao');

    wp_nonce_field('ama_publicacao_meta', 'ama_publicacao_nonce');
    echo '<p><label for="ama-publicacao-categoria">Categoria</label><br>';
    wp_dropdown_categories([
        'taxonomy'         => 'categoria_publicacao',
        'name'             => 'ama_publicacao_categoria',
        'id'               => 'ama-publicacao-categoria',
        'hide_empty'       => false,
        'show_option_none' => 'Sem categoria',
        'selected'         => is_array($terms) && $terms ? $terms[0]->term_id : -1,
    ]);
    echo '</p>';
    printf(
        '<p><label><input type="checkbox" name="ama_publicacao_destaque" value="1"%s> Destacar na página Publicações</label></p>',
        checked(get_post_meta($post->ID, 'ama_publicacao_destaque', true), '1', false)
    );
    echo '<p class="description">Na página Publicações, por baixo do título aparece o excerto (autoria e ano) e o ícone do cartão é a imagem de destaque.</p>';
}

function ama_publicacoes_save_meta_box(int $post_id): void
{
    if (!isset($_POST['ama_publicacao_nonce']) || !wp_verify_nonce(sanitize_key($_POST['ama_publicacao_nonce']), 'ama_publicacao_meta')
        || (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || !current_user_can('edit_post', $post_id)) {
        return;
    }

    $term_id = isset($_POST['ama_publicacao_categoria']) ? (int) $_POST['ama_publicacao_categoria'] : 0;
    wp_set_object_terms($post_id, $term_id > 0 ? [$term_id] : [], 'categoria_publicacao');

    if (!empty($_POST['ama_publicacao_destaque'])) {
        update_post_meta($post_id, 'ama_publicacao_destaque', '1');
    } else {
        delete_post_meta($post_id, 'ama_publicacao_destaque');
    }
}
add_action('save_post_page', 'ama_publicacoes_save_meta_box');

/**
 * Estilos da página agregadora "Publicações", com a versão pela data do ficheiro.
 */
function ama_publicacoes_enqueue(): void
{
    if (!is_page() || !ama_publicacoes_root_id() || get_queried_object_id() !== ama_publicacoes_root_id()) {
        return;
    }

    wp_enqueue_style('ama-publicacoes', get_stylesheet_directory_uri() . '/css/publicacoes.css', ['parent-style'], (string) filemtime(get_stylesheet_directory() . '/css/publicacoes.css'));
}
add_action('wp_enqueue_scripts', 'ama_publicacoes_enqueue', 12);

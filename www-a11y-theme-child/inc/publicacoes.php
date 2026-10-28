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
 * [ama_publicacoes titulo="Publicações disponíveis"]: lista as fichas (filhas diretas de "Publicações"),
 * pela "Ordem" e depois da mais recente para a mais antiga, com o resumo de cada uma.
 */
function ama_publicacoes_shortcode($atts): string
{
    $atts    = shortcode_atts(['titulo' => 'Publicações disponíveis'], $atts, 'ama_publicacoes');
    $root_id = ama_publicacoes_root_id();
    if (!$root_id) {
        return '';
    }

    $fichas = get_posts([
        'post_type'      => 'page',
        'post_parent'    => $root_id,
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => ['menu_order' => 'ASC', 'date' => 'DESC'],
    ]);
    if (!$fichas) {
        return '';
    }

    $html = $atts['titulo'] !== '' ? '<h2>' . esc_html($atts['titulo']) . '</h2>' : '';
    $html .= '<ul class="publicacoes-lista">';
    foreach ($fichas as $ficha) {
        $html .= sprintf('<li><a href="%s">%s</a>', esc_url(get_permalink($ficha)), esc_html(get_the_title($ficha)));
        if (has_excerpt($ficha)) {
            $html .= '<p>' . esc_html(get_the_excerpt($ficha)) . '</p>';
        }
        $html .= '</li>';
    }

    return $html . '</ul>';
}
add_shortcode('ama_publicacoes', 'ama_publicacoes_shortcode');

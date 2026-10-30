<?php
defined('ABSPATH') || exit;

/**
 * Tutoriais em páginas do WordPress (issue #4).
 *
 * Adaptado do tema de blocos "a11y-lab" (Jorge Fernandes) para este tema clássico.
 * A estrutura é feita só com páginas:
 *
 * Tutoriais                     ← página raiz (slug "tutoriais"), lista os tutoriais com [ama_tutoriais]
 *   └── Imagens                 ← tutorial: página de apresentação, gerada automaticamente
 *         ├── Imagens decorativas   ← páginas do tutorial, pela "Ordem" e pelo título
 *         └── Imagens informativas
 *
 * Todas as páginas abaixo de "Tutoriais" usam o template templates/tutorial.php sem
 * ser preciso escolhê-lo no editor. As páginas do tutorial têm, à esquerda, o índice
 * das páginas e, à direita (ou no topo, em ecrãs pequenos), o índice dos H2–H4.
 */

/**
 * ID da página raiz dos tutoriais.
 */
function ama_tutoriais_root_id(): int
{
    static $root_id = null;

    if ($root_id === null) {
        $root    = get_page_by_path((string) apply_filters('ama_tutoriais_root_path', 'tutoriais'));
        $root_id = $root instanceof WP_Post ? $root->ID : 0;
    }

    return $root_id;
}

/**
 * ID do tutorial a que a página pertence (a própria página, se for a apresentação),
 * ou 0 se a página não estiver dentro de "Tutoriais".
 */
function ama_tutorial_id(int $post_id): int
{
    $root_id = ama_tutoriais_root_id();
    if (!$root_id || !$post_id || get_post_type($post_id) !== 'page') {
        return 0;
    }

    foreach (array_merge([$post_id], get_post_ancestors($post_id)) as $id) {
        if ((int) wp_get_post_parent_id($id) === $root_id) {
            return (int) $id;
        }
    }

    return 0;
}

/**
 * Páginas publicadas do tutorial, em profundidade e pela ordem do WordPress
 * ("Ordem" e depois título). Cada item: ['page' => WP_Post, 'depth' => int].
 */
function ama_tutorial_pages(int $tutorial_id): array
{
    static $cache = [];

    if (isset($cache[$tutorial_id])) {
        return $cache[$tutorial_id];
    }

    $children = [];
    foreach (get_pages([
        'child_of'    => $tutorial_id,
        'post_status' => 'publish',
        'sort_column' => 'menu_order,post_title',
    ]) as $page) {
        $children[(int) $page->post_parent][] = $page;
    }

    $flatten = static function (int $parent_id, int $depth) use (&$flatten, $children): array {
        $list = [];
        foreach ($children[$parent_id] ?? [] as $page) {
            $list[] = ['page' => $page, 'depth' => $depth];
            array_push($list, ...$flatten($page->ID, $depth + 1));
        }
        return $list;
    };

    return $cache[$tutorial_id] = $flatten($tutorial_id, 0);
}

/**
 * Texto simples de um bloco de título, igual no índice e no ID.
 */
function ama_tutorial_heading_text(array $block): string
{
    return trim(html_entity_decode(wp_strip_all_tags($block['innerHTML'] ?? '', true), ENT_QUOTES, 'UTF-8'));
}

/**
 * Títulos H2–H4 do conteúdo da página, com o ID de cada um.
 *
 * O ID é a âncora definida no editor ou, se não houver, o título em forma de slug,
 * com -2, -3… quando se repete. O mesmo cálculo serve o índice e os próprios títulos,
 * por isso os links do índice apontam sempre para o sítio certo.
 */
function ama_tutorial_headings(int $post_id): array
{
    static $cache = [];

    if (isset($cache[$post_id])) {
        return $cache[$post_id];
    }

    $levels   = (array) apply_filters('ama_tutorial_toc_levels', [2, 3, 4]);
    $headings = [];
    $used     = [];

    $walk = static function (array $blocks) use (&$walk, &$headings, &$used, $levels): void {
        foreach ($blocks as $block) {
            if ($block['blockName'] === 'core/heading') {
                $level = (int) ($block['attrs']['level'] ?? 2);
                $text  = ama_tutorial_heading_text($block);

                if ($text !== '' && in_array($level, $levels, true)) {
                    $anchor = (string) ($block['attrs']['anchor'] ?? '');
                    $base   = $anchor !== '' ? $anchor : sanitize_title($text);
                    $id     = $base;

                    for ($n = 2; $anchor === '' && isset($used[$id]); $n++) {
                        $id = $base . '-' . $n;
                    }
                    $used[$id] = true;

                    $headings[] = [
                        'level'  => $level,
                        'text'   => $text,
                        'id'     => $id,
                        'base'   => sanitize_title($text),
                        'anchor' => $anchor !== '',
                    ];
                }
            }

            if (!empty($block['innerBlocks'])) {
                $walk($block['innerBlocks']);
            }
        }
    };
    $walk(parse_blocks((string) get_post_field('post_content', $post_id)));

    return $cache[$post_id] = $headings;
}

/**
 * Aplica os IDs calculados em ama_tutorial_headings() aos títulos do conteúdo.
 */
function ama_tutorial_add_heading_ids(string $block_content, array $block): string
{
    static $pending = [];

    $post_id = (int) get_the_ID();
    if (!doing_filter('the_content') || !is_singular('page') || !ama_tutorial_id($post_id)) {
        return $block_content;
    }
    if (!empty($block['attrs']['anchor'])) {
        return $block_content;
    }

    // IDs ainda por atribuir, agrupados pelo slug do texto, pela ordem em que aparecem.
    if (!isset($pending[$post_id])) {
        $pending[$post_id] = [];
        foreach (ama_tutorial_headings($post_id) as $heading) {
            if (!$heading['anchor']) {
                $pending[$post_id][$heading['base']][] = $heading['id'];
            }
        }
    }

    $base = sanitize_title(ama_tutorial_heading_text($block));
    if (empty($pending[$post_id][$base])) {
        return $block_content;
    }

    $processor = new WP_HTML_Tag_Processor($block_content);
    if ($processor->next_tag()) {
        $processor->set_attribute('id', array_shift($pending[$post_id][$base]));
        return $processor->get_updated_html();
    }

    return $block_content;
}
add_filter('render_block_core/heading', 'ama_tutorial_add_heading_ids', 10, 2);

/**
 * Índice dos títulos da página ("Links de acesso rápido").
 */
function ama_tutorial_toc(int $post_id): string
{
    $items = ama_tutorial_headings($post_id);
    if (!$items) {
        return '';
    }

    // Listas encaixadas sem saltos de nível: um H4 logo a seguir a um H2 fica um nível abaixo,
    // e cada <ul> interior fica sempre dentro de um <li>.
    $base  = min(array_column($items, 'level'));
    $depth = 0;
    $list  = '';

    foreach ($items as $item) {
        $level = max(1, min($item['level'] - $base + 1, $depth + 1));

        if ($level > $depth) {
            $list .= '<ul>';
            $depth++;
        } else {
            $list .= '</li>';
            for (; $depth > $level; $depth--) {
                $list .= '</ul></li>';
            }
        }

        $list .= sprintf('<li><a href="#%s">%s</a>', esc_attr($item['id']), esc_html($item['text']));
    }

    $list .= '</li>';
    for (; $depth > 1; $depth--) {
        $list .= '</ul></li>';
    }
    $list .= '</ul>';

    return '<nav class="tutorial-toc" aria-label="Secções da presente página do tutorial">'
        . '<details><summary>Links de acesso rápido</summary>' . $list . '</details>'
        . '</nav>';
}

/**
 * Índice das páginas do tutorial (coluna da esquerda).
 */
function ama_tutorial_nav(int $tutorial_id, int $current_id): string
{
    $pages = ama_tutorial_pages($tutorial_id);
    if (!$pages) {
        return '';
    }

    $link = static fn(int $id): string => sprintf(
        '<a href="%s"%s>%s</a>',
        esc_url(get_permalink($id)),
        $id === $current_id ? ' aria-current="page"' : '',
        esc_html(get_the_title($id))
    );

    // As páginas já vêm em profundidade; a profundidade de cada uma define o encaixe.
    $html  = '';
    $depth = -1;
    foreach ($pages as $item) {
        if ($item['depth'] > $depth) {
            $html .= '<ul>';
        } else {
            $html .= '</li>' . str_repeat('</ul></li>', $depth - $item['depth']);
        }
        $depth = $item['depth'];
        $html .= '<li>' . $link($item['page']->ID);
    }
    $html .= '</li>' . str_repeat('</ul></li>', $depth) . '</ul>';

    return '<nav class="tutorial-nav" aria-label="Páginas do tutorial">'
        . '<p class="tutorial-nav-title">' . $link($tutorial_id) . '</p>'
        . $html
        . '</nav>';
}

/**
 * Ligações "Página anterior" e "Próxima página", na ordem de leitura do tutorial
 * (apresentação, depois todas as páginas em profundidade).
 */
function ama_tutorial_pagination(int $tutorial_id, int $current_id): string
{
    $sequence = array_merge([$tutorial_id], array_map(
        static fn(array $item): int => $item['page']->ID,
        ama_tutorial_pages($tutorial_id)
    ));

    $index = array_search($current_id, $sequence, true);
    if ($index === false) {
        return '';
    }

    $links = '';
    if ($index > 0) {
        $links .= sprintf(
            '<li class="tutorial-pagination-previous"><a href="%s">Página anterior: %s</a></li>',
            esc_url(get_permalink($sequence[$index - 1])),
            esc_html(get_the_title($sequence[$index - 1]))
        );
    }
    if ($index < count($sequence) - 1) {
        $links .= sprintf(
            '<li class="tutorial-pagination-next"><a href="%s">Próxima página: %s</a></li>',
            esc_url(get_permalink($sequence[$index + 1])),
            esc_html(get_the_title($sequence[$index + 1]))
        );
    }

    return $links === ''
        ? ''
        : '<nav class="tutorial-pagination" aria-label="Seletor sequencial de páginas do tutorial"><ul>' . $links . '</ul></nav>';
}

/**
 * Tempo de leitura (minutos) de todas as páginas do tutorial, a ~200 palavras por minuto.
 * Fica em cache até alguma das páginas ser alterada.
 */
function ama_tutorial_reading_time(int $tutorial_id): int
{
    $pages = array_column(ama_tutorial_pages($tutorial_id), 'page');

    $key    = 'ama_tuto_leitura_' . $tutorial_id;
    $stamp  = md5(implode(',', array_map(static fn(WP_Post $p): string => $p->ID . ':' . $p->post_modified_gmt, $pages)));
    $cached = get_transient($key);
    if (is_array($cached) && $cached['stamp'] === $stamp) {
        return $cached['minutes'];
    }

    $words = 0;
    foreach ($pages as $page) {
        $words += preg_match_all('/[\p{L}\p{N}]+(?:[’\'][\p{L}\p{N}]+)*/u', wp_strip_all_tags(do_blocks($page->post_content)));
    }

    $minutes = max(1, (int) ceil($words / 200));
    set_transient($key, ['stamp' => $stamp, 'minutes' => $minutes], MONTH_IN_SECONDS);

    return $minutes;
}

/**
 * Apresentação do tutorial: introdução da 1.ª página (do 1.º parágrafo até ao 1.º título),
 * tempo de leitura, ligação para começar e lista das páginas.
 */
function ama_tutorial_intro(int $tutorial_id): string
{
    $pages = ama_tutorial_pages($tutorial_id);
    if (!$pages) {
        return '';
    }

    $first = $pages[0]['page'];

    $intro   = '';
    $started = false;
    foreach (parse_blocks($first->post_content) as $block) {
        if (!$started && $block['blockName'] !== 'core/paragraph') {
            continue;
        }
        if ($started && $block['blockName'] === 'core/heading') {
            break;
        }
        $started = true;
        $intro  .= render_block($block);
    }

    $minutes = ama_tutorial_reading_time($tutorial_id);

    $list = '';
    foreach ($pages as $item) {
        if ($item['depth'] === 0) {
            $list .= sprintf('<li><a href="%s">%s</a></li>', esc_url(get_permalink($item['page'])), esc_html(get_the_title($item['page'])));
        }
    }

    return '<div class="tutorial-intro">'
        . '<h2>O que vai aprender neste tutorial</h2>'
        . $intro
        . '<hr>'
        . sprintf('<p>Tempo estimado de leitura: %s</p>', esc_html(sprintf(_n('%d minuto', '%d minutos', $minutes), $minutes)))
        . sprintf('<p class="tutorial-start"><a href="%s">Começar o tutorial</a></p>', esc_url(get_permalink($first)))
        . '<h2>Conteúdo do tutorial</h2>'
        . '<ul>' . $list . '</ul>'
        . '</div>';
}

/**
 * Tutoriais publicados para a página agregadora (issue #18): os tutoriais em páginas
 * (filhas diretas de "Tutoriais") e os tutoriais antigos (tipo de conteúdo "tutorial"),
 * enquanto não forem migrados. Cada item: id, título, ligação, categoria
 * (taxonomia "categoria_tutorial"), descrição, destaque, ícone e data.
 */
function ama_tutoriais_items(): array
{
    $root_id = ama_tutoriais_root_id();
    $posts   = $root_id ? get_pages([
        'parent'      => $root_id,
        'post_status' => 'publish',
    ]) : [];

    if (post_type_exists('tutorial')) {
        $posts = array_merge($posts, get_posts([
            'post_type'      => 'tutorial',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
        ]));
    }

    $items = [];
    foreach ($posts as $post) {
        $is_page = $post->post_type === 'page';
        $terms   = taxonomy_exists('categoria_tutorial') ? get_the_terms($post, 'categoria_tutorial') : false;

        // Ícone do cartão: imagem de destaque da página (nos antigos, o campo "icon" do Pods)
        // ou, se não houver, o campo "Icon de destaque" do ACF.
        $icon_id = $is_page ? (int) get_post_thumbnail_id($post) : (int) get_post_meta($post->ID, 'icon', true);
        $icon    = $icon_id ? wp_get_attachment_image($icon_id, 'medium', false, ['class' => 'icon_card', 'alt' => '', 'aria-hidden' => 'true']) : '';
        $icon    = $icon ?: (string) get_field('ama_icon_destaque', $post->ID);

        $items[] = [
            'id'          => $post->ID,
            'title'       => get_the_title($post),
            'url'         => get_permalink($post),
            'category'    => is_array($terms) && $terms ? $terms[0] : null,
            'description' => $is_page && has_excerpt($post) ? get_the_excerpt($post) : '',
            'destaque'    => (string) get_post_meta($post->ID, $is_page ? 'ama_tutorial_destaque' : 'destaque', true) === '1',
            'icon'        => $icon ?: '<div aria-hidden="true" class="icon-xl-forms"></div>',
            'date'        => $post->post_date_gmt,
        ];
    }

    usort($items, static fn(array $a, array $b): int => strcasecmp(remove_accents($a['title']), remove_accents($b['title'])));

    return $items;
}

/**
 * Lista de tutoriais com seta (classe "ama-list"), em duas colunas.
 */
function ama_tutoriais_list(array $items, bool $with_category): string
{
    $html = '';
    foreach ($items as $item) {
        $html .= sprintf(
            '<li><a href="%s">%s</a>%s%s</li>',
            esc_url($item['url']),
            esc_html($item['title']),
            $with_category && $item['category'] ? '<span class="d-block small">' . esc_html($item['category']->name) . '</span>' : '',
            $item['description'] !== '' ? '<span class="d-block small">' . esc_html($item['description']) . '</span>' : ''
        );
    }

    return '<ul class="colunas-1 colunas-md-2 ama-list">' . $html . '</ul>';
}

/**
 * [ama_tutoriais]: página agregadora dos tutoriais, com o layout da página antiga.
 *
 * - 3 cartões "em destaque": os marcados como destaque e, a seguir, os mais recentes;
 * - todos os tutoriais por ordem alfabética, com a categoria e o excerto por baixo do título;
 * - acima de 30 tutoriais (filtro "ama_tutoriais_limite_categorias"), a lista passa
 *   a estar agrupada por categoria.
 */
function ama_tutoriais_shortcode(): string
{
    $items = ama_tutoriais_items();
    if (!$items) {
        return '';
    }

    $highlights = $items;
    usort($highlights, static fn(array $a, array $b): int => [$b['destaque'], $b['date']] <=> [$a['destaque'], $a['date']]);

    $cards = '';
    foreach (array_slice($highlights, 0, 3) as $item) {
        $cards .= sprintf(
            '<li class="card-highlight"><div class="card-body row"><div class="col-12">%s<h3 class="card-title"><a href="%s">%s</a></h3></div></div>'
            . '<div class="card-footer"><div class="icons_tutorials">%s</div></div></li>',
            $item['category'] ? '<p class="card-text">' . esc_html($item['category']->name) . '</p>' : '',
            esc_url($item['url']),
            esc_html($item['title']),
            $item['icon']
        );
    }

    $html = '<section class="tutoriais-destaque"><h2 class="visually-hidden">Tutoriais em destaque</h2>'
        . '<ul class="grid grid-md-3 gap-30">' . $cards . '</ul></section>'
        . '<section class="tutoriais-lista mt-5"><h2 class="visually-hidden">Todos os tutoriais</h2>';

    if (count($items) <= (int) apply_filters('ama_tutoriais_limite_categorias', 30)) {
        return $html . ama_tutoriais_list($items, true) . '</section>';
    }

    $groups = [];
    $others = [];
    foreach ($items as $item) {
        if ($item['category']) {
            $groups[$item['category']->name][] = $item;
        } else {
            $others[] = $item;
        }
    }
    uksort($groups, static fn(string $a, string $b): int => strcasecmp(remove_accents($a), remove_accents($b)));
    if ($others) {
        $groups['Outros tutoriais'] = $others;
    }

    foreach ($groups as $name => $group) {
        $html .= '<h3>' . esc_html($name) . '</h3>' . ama_tutoriais_list($group, false);
    }

    return $html . '</section>';
}
add_shortcode('ama_tutoriais', 'ama_tutoriais_shortcode');

/**
 * As páginas dos tutoriais também usam a taxonomia "categoria_tutorial" (criada no Pods
 * para os tutoriais antigos).
 */
function ama_tutoriais_register_taxonomy(): void
{
    if (taxonomy_exists('categoria_tutorial')) {
        register_taxonomy_for_object_type('categoria_tutorial', 'page');
    }
}
add_action('init', 'ama_tutoriais_register_taxonomy', 99);

/**
 * Caixa "Tutorial" no editor das páginas que são tutoriais (filhas diretas de
 * "Tutoriais"): categoria e destaque na página agregadora. Numa página nova a mãe ainda
 * não está gravada, por isso a caixa aparece sempre e só conta ao gravar (ver abaixo).
 */
function ama_tutoriais_add_meta_box(WP_Post $post): void
{
    if (!ama_tutoriais_root_id() || !taxonomy_exists('categoria_tutorial')) {
        return;
    }
    if ((int) $post->post_parent !== ama_tutoriais_root_id() && $post->post_status !== 'auto-draft') {
        return;
    }

    add_meta_box('ama-tutorial', 'Tutorial', 'ama_tutoriais_meta_box', 'page', 'side');
}
add_action('add_meta_boxes_page', 'ama_tutoriais_add_meta_box');

function ama_tutoriais_meta_box(WP_Post $post): void
{
    $terms = get_the_terms($post, 'categoria_tutorial');

    wp_nonce_field('ama_tutorial_meta', 'ama_tutorial_nonce');
    echo '<p><label for="ama-tutorial-categoria">Categoria</label><br>';
    wp_dropdown_categories([
        'taxonomy'         => 'categoria_tutorial',
        'name'             => 'ama_tutorial_categoria',
        'id'               => 'ama-tutorial-categoria',
        'hide_empty'       => false,
        'show_option_none' => 'Sem categoria',
        'selected'         => is_array($terms) && $terms ? $terms[0]->term_id : -1,
    ]);
    echo '</p>';
    printf(
        '<p><label><input type="checkbox" name="ama_tutorial_destaque" value="1"%s> Destacar na página Tutoriais</label></p>',
        checked(get_post_meta($post->ID, 'ama_tutorial_destaque', true), '1', false)
    );
    echo '<p class="description">O ícone do cartão é a imagem de destaque ou, se não houver, o campo "Icon de destaque". Só se aplica às páginas diretamente abaixo de Tutoriais.</p>';
}

function ama_tutoriais_save_meta_box(int $post_id): void
{
    if (!isset($_POST['ama_tutorial_nonce']) || !wp_verify_nonce(sanitize_key($_POST['ama_tutorial_nonce']), 'ama_tutorial_meta')
        || (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || !current_user_can('edit_post', $post_id)
        || (int) wp_get_post_parent_id($post_id) !== ama_tutoriais_root_id()) {
        return;
    }

    $term_id = isset($_POST['ama_tutorial_categoria']) ? (int) $_POST['ama_tutorial_categoria'] : 0;
    wp_set_object_terms($post_id, $term_id > 0 ? [$term_id] : [], 'categoria_tutorial');

    if (!empty($_POST['ama_tutorial_destaque'])) {
        update_post_meta($post_id, 'ama_tutorial_destaque', '1');
    } else {
        delete_post_meta($post_id, 'ama_tutorial_destaque');
    }
}
add_action('save_post_page', 'ama_tutoriais_save_meta_box');

/**
 * As páginas dentro de "Tutoriais" usam o template dos tutoriais.
 */
function ama_tutorial_template(string $template): string
{
    if (is_page() && ama_tutorial_id((int) get_queried_object_id())) {
        $tutorial_template = locate_template('templates/tutorial.php');
        if ($tutorial_template) {
            return $tutorial_template;
        }
    }

    return $template;
}
add_filter('template_include', 'ama_tutorial_template');

/**
 * Indica se a página atual pertence à secção "Tutoriais": uma página abaixo de
 * "Tutoriais" ou um tutorial antigo (tipo de conteúdo "tutorial").
 */
function ama_is_tutoriais_section(): bool
{
    return is_singular('tutorial') || (is_page() && ama_tutorial_id((int) get_queried_object_id()));
}

/**
 * Marca "Tutoriais" no menu principal dentro da secção. O WordPress só dá
 * "current_page_parent" à mãe direta; nos netos usa "current-page-ancestor",
 * que o tema não destaca, e nos tutoriais antigos não marca nada.
 */
function ama_tutoriais_menu_class(array $classes, $item): array
{
    if ((int) $item->object_id === ama_tutoriais_root_id() && $item->object === 'page' && ama_is_tutoriais_section()) {
        $classes[] = 'current_page_parent';
    }

    return array_unique($classes);
}
add_filter('nav_menu_css_class', 'ama_tutoriais_menu_class', 10, 2);

/**
 * Para leitores de ecrã: aria-current="true" indica a secção atual
 * ("page" fica reservado para a própria página).
 */
function ama_tutoriais_menu_link_attributes(array $atts, $item): array
{
    if (empty($atts['aria-current']) && (int) $item->object_id === ama_tutoriais_root_id() && $item->object === 'page' && ama_is_tutoriais_section()) {
        $atts['aria-current'] = 'true';
    }

    return $atts;
}
add_filter('nav_menu_link_attributes', 'ama_tutoriais_menu_link_attributes', 10, 2);

/**
 * Estilos e script só nas páginas dos tutoriais e na página agregadora "Tutoriais".
 */
function ama_tutorial_enqueue(): void
{
    $is_root = is_page() && ama_tutoriais_root_id() && get_queried_object_id() === ama_tutoriais_root_id();
    if (!$is_root && (!is_page() || !ama_tutorial_id((int) get_queried_object_id()))) {
        return;
    }

    // Versão pela data do ficheiro, para os browsers não ficarem com a versão antiga em cache.
    $version = static fn(string $file): string => (string) filemtime(get_stylesheet_directory() . $file);

    wp_enqueue_style('ama-tutoriais', get_stylesheet_directory_uri() . '/css/tutoriais.css', ['parent-style'], $version('/css/tutoriais.css'));
    if ($is_root) {
        return;
    }

    wp_enqueue_script('ama-prism', get_stylesheet_directory_uri() . '/js/prism.min.js', [], '1.29.0', ['in_footer' => true, 'strategy' => 'defer']);
    wp_add_inline_script('ama-prism', 'window.Prism = { manual: true };', 'before');
    wp_enqueue_script('ama-tutoriais', get_stylesheet_directory_uri() . '/js/tutoriais.js', ['ama-prism'], $version('/js/tutoriais.js'), ['in_footer' => true, 'strategy' => 'defer']);
}
add_action('wp_enqueue_scripts', 'ama_tutorial_enqueue', 12);

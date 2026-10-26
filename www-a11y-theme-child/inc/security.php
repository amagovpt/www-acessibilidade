<?php
defined('ABSPATH') || exit;

/**
 * XML-RPC não é usado pelo site; desativá-lo evita ataques de força bruta
 * amplificados (system.multicall) e abuso de pingbacks.
 */
add_filter('xmlrpc_enabled', '__return_false');

/**
 * Impede a enumeração de utilizadores através de ?author=N e dos arquivos de autor.
 */
function ama_block_author_enumeration(): void
{
    if (is_admin()) {
        return;
    }

    if (isset($_GET['author']) || is_author()) {
        wp_safe_redirect(home_url('/'), 301);
        exit;
    }
}
add_action('template_redirect', 'ama_block_author_enumeration', 1);

/**
 * Organizações/utilizadores GitHub de onde podem vir conteúdos Markdown.
 */
function ama_github_allowed_owners(): array
{
    return apply_filters('ama_github_allowed_owners', ['amagovpt']);
}

/**
 * Valida um URL de repositório GitHub e devolve owner/repo, ou null se não for permitido.
 */
function ama_github_parse_repo_url(string $github_url): ?array
{
    if (!preg_match('#^https://github\.com/([A-Za-z0-9_.-]+)/([A-Za-z0-9_.-]+)#', trim($github_url), $matches)) {
        return null;
    }

    $allowed = array_map('strtolower', ama_github_allowed_owners());
    if (!in_array(strtolower($matches[1]), $allowed, true)) {
        return null;
    }

    return [
        'owner' => $matches[1],
        'repo'  => preg_replace('/\.git$/', '', $matches[2]),
    ];
}

/**
 * Converte Markdown em HTML seguro: o Parsedown em modo seguro escapa HTML embutido
 * e links javascript:, e o resultado passa ainda pelo filtro de conteúdo do WordPress.
 */
function ama_markdown_to_safe_html(string $markdown): string
{
    require_once get_stylesheet_directory() . '/libs/Parsedown/Parsedown.php';

    $parsedown = new Parsedown();
    $parsedown->setSafeMode(true);

    return wp_kses_post(tutos_add_id_to_titles($parsedown->text($markdown)));
}

/**
 * Devolve o README.md de um repositório GitHub permitido, convertido em HTML seguro.
 * A resposta fica em cache para não chamar a API do GitHub em cada visita
 * (limite de 60 pedidos/hora sem autenticação).
 */
function ama_github_readme_html(string $github_url): ?string
{
    $repo = ama_github_parse_repo_url($github_url);
    if (!$repo) {
        return null;
    }

    $cache_key = 'ama_gh_readme_' . md5($repo['owner'] . '/' . $repo['repo']);
    $cached    = get_transient($cache_key);
    if ($cached !== false) {
        return $cached;
    }

    $response = wp_remote_get(
        sprintf('https://api.github.com/repos/%s/%s/contents/README.md', rawurlencode($repo['owner']), rawurlencode($repo['repo'])),
        [
            'timeout' => 10,
            'headers' => [
                'Accept'     => 'application/vnd.github+json',
                'User-Agent' => 'acessibilidade.gov.pt',
            ],
        ]
    );

    if (is_wp_error($response) || wp_remote_retrieve_response_code($response) !== 200) {
        return null;
    }

    $body = json_decode(wp_remote_retrieve_body($response), true);
    if (empty($body['content'])) {
        return null;
    }

    $html = ama_markdown_to_safe_html((string) base64_decode($body['content']));
    set_transient($cache_key, $html, 6 * HOUR_IN_SECONDS);

    return $html;
}

/**
 * O fornecedor "Dummy" do plugin Two Factor serve apenas para testes e
 * aceitaria qualquer pessoa como segundo fator.
 */
function ama_two_factor_remove_dummy(array $providers): array
{
    unset($providers['Two_Factor_Dummy']);
    return $providers;
}
add_filter('two_factor_providers', 'ama_two_factor_remove_dummy');

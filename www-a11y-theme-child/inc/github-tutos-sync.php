<?php
defined('ABSPATH') || exit;

function tutos_github_sources(): array
{
    $sources = [];
    
    if (!function_exists('get_field')) {
        return $sources;
    }
    
    $posts = get_posts([
        'post_type'      => 'tuto',
        'posts_per_page' => -1,
        'post_status'    => 'any',
    ]);
    
    foreach ($posts as $post) {
        $github_url = get_field('tutorial_github_url', $post->ID);
        
        if (empty($github_url)) {
            continue;
        }
        
        $sources[] = [
            'github_url' => $github_url,
            'post_id'    => $post->ID,
            'post_type'  => 'tuto',
            'status'     => $post->post_status,
            'path'       => 'README.md',
        ];
    }
    
    return $sources;
}

function tutos_extract_md_title(string $markdown): string
{
    $markdown = preg_replace('/^---\s*\n.*?\n---\s*\n/s', '', $markdown);
    
    if (preg_match('/^#+\s*(.+)$/m', $markdown, $matches)) {
        $title = trim($matches[1]);
        $title = preg_replace('/\*\*(.+?)\*\*/', '$1', $title);
        $title = preg_replace('/\*(.+?)\*/', '$1', $title);
        $title = preg_replace('/\[(.+?)\]\(.+?\)/', '$1', $title);
        return trim($title);
    }
    
    return '';
}

function tutos_extract_md_excerpt(string $markdown): string
{
    $markdown = preg_replace('/^---\s*\n.*?\n---\s*\n/s', '', $markdown);
    $markdown = preg_replace('/^#+\s*.+$/m', '', $markdown);
    $markdown = preg_replace('/```[\s\S]*?```/', '', $markdown);
    
    $lines = explode("\n", $markdown);
    $excerpt = '';
    
    foreach ($lines as $line) {
        $line = trim($line);
        if (!empty($line) && !preg_match('/^[#*\-\[\]]/', $line)) {
            $excerpt = $line;
            break;
        }
    }
    
    return mb_substr($excerpt, 0, 160);
}

function tutos_convert_md_to_html(string $markdown): string
{
    $parsedown_path = dirname(__DIR__) . '/libs/Parsedown/Parsedown.php';
    
    if (!file_exists($parsedown_path)) {
        return $markdown;
    }
    
    require_once $parsedown_path;
    
    if (!class_exists('Parsedown')) {
        return $markdown;
    }
    
    $parsedown = new Parsedown();
    $html = $parsedown->text($markdown);
    
    return tutos_add_id_to_titles($html);
}

function tutos_add_id_to_titles(string $html_content): string
{
    if (empty($html_content)) {
        return $html_content;
    }
    
    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    
    $dom->loadHTML('<?xml encoding="utf-8" ?>' . $html_content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    libxml_clear_errors();
    
    $h2_tags = $dom->getElementsByTagName('h2');
    foreach ($h2_tags as $index => $h2) {
        $id = 'titulo-' . ($index + 1);
        $h2->setAttribute('id', $id);
    }
    
    $body = $dom->getElementsByTagName('body')->item(0);
    if (!$body) {
        return $html_content;
    }
    
    $html = '';
    foreach ($body->childNodes as $child) {
        $html .= $dom->saveHTML($child);
    }
    
    return $html;
}

function sincronizar_tutos_do_github()
{
    $sources = tutos_github_sources();
    $synced = 0;
    $skipped = 0;
    $errors = [];
    
    foreach ($sources as $source) {
        $github_url = $source['github_url'];
        $post_id    = $source['post_id'];
        $post_type  = $source['post_type'] ?? 'tuto';
        $status     = $source['status'] ?? 'publish';
        $path       = $source['path'] ?? 'README.md';
        
        // Parse GitHub URL to extract owner, repo, and branch
        if (!preg_match('#github\.com/([^/]+)/([^/]+)#', $github_url, $matches)) {
            $errors[] = sprintf('URL GitHub inválida: %s', $github_url);
            continue;
        }
        
        $owner = $matches[1];
        $repo = $matches[2];
        $branch = 'main';
        
        if (preg_match('#/tree/([^/]+)#', $github_url, $branch_matches)) {
            $branch = $branch_matches[1];
        }
        
        $source_id = "{$owner}/{$repo}:{$path}";
        
        // Build raw GitHub URL
        $raw_url = sprintf(
            'https://raw.githubusercontent.com/%s/%s/%s/%s',
            $owner,
            $repo,
            $branch,
            $path
        );
        
        $response = wp_remote_get($raw_url, [
            'timeout' => 30,
            'headers' => [
                'User-Agent' => 'WordPress-GitHub-Sync/1.0',
                'Cache-Control' => 'no-cache',
            ],
        ]);
        
        if (is_wp_error($response)) {
            $errors[] = sprintf('Erro ao buscar %s: %s', $raw_url, $response->get_error_message());
            continue;
        }
        
        $response_code = wp_remote_retrieve_response_code($response);
        if ($response_code !== 200) {
            $errors[] = sprintf('Erro HTTP %d ao buscar %s', $response_code, $raw_url);
            continue;
        }
        
        $body = wp_remote_retrieve_body($response);
        if (empty($body)) {
            $errors[] = sprintf('Conteúdo vazio para %s', $raw_url);
            continue;
        }
        
        $new_hash = md5($body);
        $old_hash = get_post_meta($post_id, '_github_md_hash', true);
        
        if ($old_hash === $new_hash) {
            $skipped++;
            continue;
        }
        
        $title = tutos_extract_md_title($body);
        if (empty($title)) {
            $title = preg_replace('/\.md$/i', '', basename($path));
            $title = str_replace(['-', '_'], ' ', $title);
            $title = ucwords($title);
        }
        
        $excerpt = tutos_extract_md_excerpt($body);
        
        // Convert markdown to HTML
        $html_content = tutos_convert_md_to_html($body);
        
        $post_data = [
            'ID'           => $post_id,
            'post_title'   => $title,
            'post_content' => $html_content,
            'post_excerpt' => $excerpt,
            'post_status'  => $status,
            'post_type'    => $post_type,
        ];
        
        $result = wp_update_post($post_data, true);
        
        if (is_wp_error($result)) {
            $errors[] = sprintf('Erro ao guardar post para %s: %s', $source_id, $result->get_error_message());
            continue;
        }
        
        update_post_meta($post_id, '_github_source_id', $source_id);
        update_post_meta($post_id, '_github_md_hash', $new_hash);
        update_post_meta($post_id, '_github_repo', "{$owner}/{$repo}");
        update_post_meta($post_id, '_github_path', $path);
        update_post_meta($post_id, '_github_branch', $branch);
        update_post_meta($post_id, '_github_synced_at', current_time('mysql'));
        
        $synced++;
    }
    
    if (!empty($errors)) {
        return new WP_Error(
            'github_sync_errors',
            'Alguns ficheiros falharam: ' . implode('; ', $errors),
            ['synced' => $synced, 'skipped' => $skipped, 'errors' => $errors]
        );
    }
    
    return ['synced' => $synced, 'skipped' => $skipped];
}

<?php
// Cria as páginas do Gerador da Declaração no WordPress (em vez da pasta /gerador à parte):
//   /gerador/     "Gerador da Declaração de Acessibilidade e Usabilidade"  template gerador.php
//   /gerador/en/  "Accessibility and Usability Statement Generator"         template gerador-en.php
// Uso, a partir da pasta do WordPress ou indicando-a:
//   php gerador-paginas.php [/caminho/para/wordpress] [--aplicar]
//   wp eval-file gerador-paginas.php [--aplicar]   (WP-CLI)
// Sem --aplicar só mostra o que mudaria. Pode ser corrido mais do que uma vez.
// Atenção: enquanto existir a pasta física /gerador na raiz do site, o Apache serve-a
// em vez da página. Depois de criar as páginas, retire (ou mude o nome de) essa pasta.
if (!defined('ABSPATH')) {
    $opcoes = array_values(array_filter(array_slice($argv, 1), static fn(string $a): bool => $a !== '--aplicar'));
    $pasta  = rtrim($opcoes[0] ?? getcwd(), '/');
    if (!is_file($pasta . '/wp-load.php')) {
        fwrite(STDERR, "Não encontrei o WordPress em \"$pasta\". Corra o script na pasta do WordPress ou indique-a como argumento.\n");
        exit(1);
    }
    require $pasta . '/wp-load.php';
}

// Com o WP-CLI (wp eval-file) os argumentos chegam em $args.
$aplicar = in_array('--aplicar', $args ?? $argv ?? [], true);
$log     = static fn(string $m) => print(($aplicar ? '' : '[simulação] ') . $m . "\n");

if (!is_file(get_stylesheet_directory() . '/gerador.php') || !is_file(get_stylesheet_directory() . '/gerador-en.php')) {
    $log('O tema ativo não tem os templates gerador.php e gerador-en.php; atualize o tema filho primeiro.');
    return;
}

$garantir = static function (string $caminho, array $dados, string $template) use ($aplicar, $log): int {
    $pagina = get_page_by_path($caminho);

    if ($pagina) {
        $atual = get_page_template_slug($pagina->ID);
        if ($atual === $template && $pagina->post_status === 'publish') {
            $log("Página /$caminho/ (ID {$pagina->ID}) já existe com o template $template; nada a fazer.");
        } else {
            $log("Página /$caminho/ (ID {$pagina->ID}): template \"$atual\" -> \"$template\", estado \"{$pagina->post_status}\" -> \"publish\"");
            $aplicar && wp_update_post(['ID' => $pagina->ID, 'post_status' => 'publish', 'page_template' => $template]);
        }
        return $pagina->ID;
    }

    $log("Cria a página /$caminho/ \"{$dados['post_title']}\" com o template $template");
    if (!$aplicar) {
        return 0;
    }
    $id = wp_insert_post($dados + ['post_type' => 'page', 'post_status' => 'publish', 'page_template' => $template], true);
    if (is_wp_error($id)) {
        $log('Erro: ' . $id->get_error_message());
        return 0;
    }
    return (int) $id;
};

$pt = $garantir('gerador', [
    'post_title'   => 'Gerador da Declaração de Acessibilidade e Usabilidade',
    'post_name'    => 'gerador',
    'post_excerpt' => 'Ferramenta que gera automaticamente a Declaração de Acessibilidade e Usabilidade pronta a publicar no seu sítio Web.',
    'post_content' => '',
], 'gerador.php');

if (!$pt && !$aplicar) {
    $log('Cria a página /gerador/en/ "Accessibility and Usability Statement Generator" com o template gerador-en.php');
    return;
}
if (!$pt) {
    return;
}

$garantir('gerador/en', [
    'post_title'   => 'Accessibility and Usability Statement Generator',
    'post_name'    => 'en',
    'post_parent'  => $pt,
    'post_excerpt' => 'Tool that automatically generates the Accessibility and Usability Statement ready to publish on your website.',
    'post_content' => '',
], 'gerador-en.php');

if (is_dir(ABSPATH . 'gerador')) {
    $log('Aviso: a pasta ' . ABSPATH . 'gerador ainda existe e tapa a página /gerador/. Retire-a ou mude-lhe o nome.');
}

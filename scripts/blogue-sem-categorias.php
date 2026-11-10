<?php
// Página "Blogue": a coluna lateral fica só com "Mais lidos" (sai o bloco "Categorias").
// O bloco está no conteúdo da página (shortcode [get_blogue_categories]), não no tema.
// Uso, a partir da pasta do WordPress ou indicando-a:
//   php blogue-sem-categorias.php [/caminho/para/wordpress] [--aplicar]
//   wp eval-file blogue-sem-categorias.php [--aplicar]   (WP-CLI)
// Sem --aplicar só mostra o que mudaria. Pode ser corrido mais do que uma vez.
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

$blogue = get_page_by_path('blogue');
if (!$blogue) {
    $log('Página "blogue" não encontrada; nada a fazer.');
    return;
}

$novo = preg_replace('#\s*<div class="categories">.*?\[get_blogue_categories\]\s*</div>#s', '', $blogue->post_content, 1, $n);
if ($n !== 1) {
    $log("Página \"{$blogue->post_title}\" (ID {$blogue->ID}): sem bloco \"Categorias\"; nada a fazer.");
    return;
}

$log("Página \"{$blogue->post_title}\" (ID {$blogue->ID}): remove o bloco \"Categorias\" da coluna lateral");
$aplicar && wp_update_post(['ID' => $blogue->ID, 'post_content' => $novo]);

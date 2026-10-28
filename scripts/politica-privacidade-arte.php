<?php
// Conteúdo para a issue #7: a política de privacidade passa a ser a da ARTE e sai a página "Termos e Condições".
// Uso: php scripts/politica-privacidade-arte.php /caminho/para/wordpress [--aplicar]
// Sem --aplicar só mostra o que mudaria. Pode ser corrido mais do que uma vez.
require rtrim($argv[1] ?? '', '/') . '/wp-load.php';

$aplicar = in_array('--aplicar', $argv, true);
$arte    = 'https://www.arte.gov.pt/politica-de-privacidade/';
$log     = static fn(string $m) => print(($aplicar ? '' : '[simulação] ') . $m . "\n");

$termos = get_page_by_path('termos-e-condicoes');

// 1. Menu do rodapé: "Política de Privacidade" liga para a ARTE e sai "Termos e Condições".
$menu_id = (int) (get_nav_menu_locations()['footer'] ?? 0);
foreach ($menu_id ? wp_get_nav_menu_items($menu_id) : [] as $item) {
    if ($item->type === 'custom' && stripos($item->url, 'politica-de-privacidade') !== false && $item->url !== $arte) {
        $log("Menu: \"{$item->title}\" {$item->url} -> $arte");
        $aplicar && update_post_meta($item->ID, '_menu_item_url', $arte);
    }
    if ($termos && $item->type === 'post_type' && (int) $item->object_id === $termos->ID) {
        $log("Menu: remove \"{$item->title}\"");
        $aplicar && wp_delete_post($item->ID, true);
    }
}

// 2. Página "Termos e Condições" para o lixo (pode ser reposta).
if ($termos && $termos->post_status !== 'trash') {
    $log("Página: \"{$termos->post_title}\" (ID {$termos->ID}) para o lixo");
    $aplicar && wp_trash_post($termos->ID);
}

// 3. Rascunho da política própria (PR #11), que deixa de ser usado.
$politica_id = (int) get_option('wp_page_for_privacy_policy');
$politica    = $politica_id ? get_post($politica_id) : null;
if ($politica && $politica->post_status === 'draft' && $politica->post_name === 'politica-de-privacidade-e-cookies') {
    $log("Página: rascunho \"{$politica->post_title}\" (ID {$politica_id}) para o lixo");
    $aplicar && wp_trash_post($politica_id);
}
if ($politica_id) {
    $log('Definições > Privacidade: sem página (a política é a da ARTE)');
    $aplicar && update_option('wp_page_for_privacy_policy', 0);
}

// 4. Formulário de contacto (Formidable): o consentimento deixa de referir os termos e condições.
global $wpdb;
$table = $wpdb->prefix . 'frm_fields';
if ($wpdb->get_var($wpdb->prepare('SHOW TABLES LIKE %s', $table)) === $table) {
    $texto  = '<p>Para enviar este formulário, deverá aceitar a <a href="' . $arte . '">política de privacidade da ARTE</a>.</p>';
    $opcao  = 'Aceito a política de privacidade da ARTE';
    $erro   = 'Aceite a política de privacidade da ARTE';
    $campos = $wpdb->get_results(
        "SELECT id, form_id, name, description, options, field_options FROM $table
         WHERE description LIKE '%termos-e-condicoes%' OR description LIKE '%politica-de-privacidade%'
            OR options LIKE '%termos e condições%' OR options LIKE '%política de privacidade%'"
    );

    foreach ($campos as $campo) {
        $dados = [];
        if (str_contains((string) $campo->description, '<a ') && $campo->description !== $texto) {
            $dados['description'] = $texto;
        }

        $options = maybe_unserialize($campo->options);
        if (is_array($options) && count($options) === 1 && is_array(reset($options)) && reset($options)['label'] !== $opcao) {
            $options = [array_merge(reset($options), ['label' => $opcao, 'value' => $opcao])];
            $dados['options'] = maybe_serialize($options);
        }
        if (is_array($options) && stripos($campo->name, 'termos') !== false) {
            $dados['name'] = 'Política de privacidade:';
        }
        $field_options = maybe_unserialize($campo->field_options);
        if (is_array($options) && is_array($field_options) && ($field_options['blank'] ?? '') !== $erro) {
            $field_options['blank'] = $erro;
            $dados['field_options'] = maybe_serialize($field_options);
        }

        if (!$dados) {
            continue;
        }
        $log("Formulário {$campo->form_id}, campo {$campo->id} (\"{$campo->name}\"): " . implode(', ', array_keys($dados)));
        if ($aplicar) {
            $wpdb->update($table, $dados, ['id' => $campo->id]);
            $wpdb->query($wpdb->prepare("DELETE FROM {$wpdb->options} WHERE option_name LIKE %s", '_transient%frm_form_fields_' . (int) $campo->form_id . '%'));
            wp_cache_flush();
        }
    }
}

echo $aplicar ? "Feito.\n" : "Nada foi alterado. Para aplicar: acrescentar --aplicar\n";

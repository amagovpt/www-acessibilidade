<?php
defined('ABSPATH') || exit;

function tutos_sync_github_callback(): void
{
    if (!current_user_can('manage_options')) {
        wp_send_json_error('Não tem permissões para executar esta ação.');
        wp_die();
    }

    $resultado = sincronizar_tutos_do_github();
    
    if (is_wp_error($resultado)) {
        $data = $resultado->get_error_data();
        $msg = $resultado->get_error_message();
        if (isset($data['synced']) && $data['synced'] > 0) {
            $msg .= ' (' . $data['synced'] . ' sincronizados com sucesso)';
        }
        wp_send_json_error($msg);
        wp_die();
    }
    
    if (is_array($resultado)) {
        $msg = sprintf(
            'Sincronização concluída: %d criados/atualizados, %d sem alterações.',
            $resultado['synced'],
            $resultado['skipped']
        );
        wp_send_json_success($msg);
        wp_die();
    }

    wp_send_json_error('Ocorreu um erro ao sincronizar os tutoriais.');
    wp_die();
}
add_action('wp_ajax_tutos_sync_github', 'tutos_sync_github_callback');

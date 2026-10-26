<?php
defined('ABSPATH') || exit;

function tutos_github_register_settings(): void
{
    register_setting('tutos_github_settings_group', 'tutos_github_schedule_datetime');
    register_setting('tutos_github_settings_group', 'tutos_github_schedule_frequency');
    register_setting('tutos_github_settings_group', 'tutos_github_error_email');

    add_settings_section(
        'tutos_github_settings_section',
        'Sincronização de Tutoriais do GitHub',
        'tutos_github_settings_section_callback',
        'tutos-github-settings'
    );

    add_settings_field(
        'tutos_github_schedule_datetime',
        'Data e hora da execução da tarefa',
        'tutos_github_datetime_field_callback',
        'tutos-github-settings',
        'tutos_github_settings_section'
    );

    add_settings_field(
        'tutos_github_schedule_frequency',
        'Frequência de execução da tarefa.',
        'tutos_github_frequency_field_callback',
        'tutos-github-settings',
        'tutos_github_settings_section'
    );

    add_settings_field(
        'tutos_github_error_email',
        'Email para notificações de erro',
        'tutos_github_email_field_callback',
        'tutos-github-settings',
        'tutos_github_settings_section'
    );
}
add_action('admin_init', 'tutos_github_register_settings');

function tutos_github_settings_section_callback(): void
{
    echo '<p>As seguintes opções servem o propósito de agendar a tarefa de sincronização de tutoriais a partir dos repositórios GitHub.</p>';
}

function tutos_github_datetime_field_callback(): void
{
    $value = get_option('tutos_github_schedule_datetime', date('Y-m-d\TH:i'));
    echo '<input type="datetime-local" name="tutos_github_schedule_datetime" value="' . esc_attr($value) . '" />';
}

function tutos_github_frequency_field_callback(): void
{
    $value = get_option('tutos_github_schedule_frequency', 'daily');
    $options = [
        'hourly'     => 'A cada hora',
        'twicedaily' => 'Duas vezes por dia',
        'daily'      => 'Diariamente',
    ];
    
    echo '<select name="tutos_github_schedule_frequency">';
    foreach ($options as $key => $label) {
        $selected = ($value === $key) ? ' selected' : '';
        echo '<option value="' . esc_attr($key) . '"' . $selected . '>' . esc_html($label) . '</option>';
    }
    echo '</select>';
}

function tutos_github_email_field_callback(): void
{
    $value = get_option('tutos_github_error_email', get_option('admin_email'));
    echo '<input type="text" name="tutos_github_error_email" value="' . esc_attr($value) . '" class="regular-text" />';
    echo '<p class="description" >Insira uma ou várias contas de e-mail separadas por uma vírgula.</p>';
}

function tutos_github_add_admin_menu(): void
{
    add_submenu_page(
        'options-general.php',
        'Sincronização GitHub Tutos',
        'GitHub Tutos',
        'manage_options',
        'github-tutos-sync',
        'tutos_github_render_admin_page'
    );
}
add_action('admin_menu', 'tutos_github_add_admin_menu');

function tutos_github_render_admin_page(): void
{
    if (!current_user_can('manage_options')) {
        wp_die('Não tem permissões para aceder a esta página.');
    }
    ?>
    <div class="wrap">
        <h1>Definições adicionais | AMA</h1>
        
        <h2>Sincronização de Tutoriais do GitHub</h2>
        
        <form method="post" action="options.php">
            <?php
            settings_fields('tutos_github_settings_group');
            do_settings_sections('tutos-github-settings');
            submit_button('Guardar alterações');
            ?>
        </form>
        
        <hr style="margin: 40px 0;" />
        
        <h2>Executar sincronização de tutoriais</h2>
        <p>Esta ação força a execução da tarefa de sincronização de tutoriais a partir dos repositórios GitHub configurados.</p>
        
        <p><button type="button" id="tutos-sync-button" class="button">Sincronizar Dados</button></p>
        <div id="tutos-sync-response"></div>
    </div>
    <?php
}

function tutos_github_enqueue_admin_scripts($hook): void
{
    if ($hook !== 'settings_page_github-tutos-sync') {
        return;
    }
    
    wp_enqueue_script(
        'tutos-admin-js',
        get_stylesheet_directory_uri() . '/assets/js/admin.js',
        ['jquery'],
        '1.0',
        true
    );
}
add_action('admin_enqueue_scripts', 'tutos_github_enqueue_admin_scripts');

function tutos_github_reschedule_cron(): void
{
    $timestamp = wp_next_scheduled('atualizar_tutos_github');
    if ($timestamp) {
        wp_unschedule_event($timestamp, 'atualizar_tutos_github');
    }
    
    $datetime = get_option('tutos_github_schedule_datetime');
    $frequency = get_option('tutos_github_schedule_frequency', 'daily');
    
    if ($datetime) {
        $schedule_time = strtotime(str_replace('T', ' ', $datetime));
        if ($schedule_time === false || $schedule_time < time()) {
            $schedule_time = time() + 60;
        }
    } else {
        $schedule_time = strtotime('tomorrow midnight');
    }
    
    wp_schedule_event($schedule_time, $frequency, 'atualizar_tutos_github');
}
add_action('update_option_tutos_github_schedule_datetime', 'tutos_github_reschedule_cron');
add_action('update_option_tutos_github_schedule_frequency', 'tutos_github_reschedule_cron');

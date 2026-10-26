<?php
defined('ABSPATH') || exit;

function atualizar_tutos_github_cb(): void
{
    $atualizacao = sincronizar_tutos_do_github();

    if (is_wp_error($atualizacao)) {
        $emails = get_option('tutos_github_error_email');
        if ($emails) {
            $email_list = array_map('trim', explode(',', $emails));
            foreach ($email_list as $email) {
                if (is_email($email)) {
                    wp_mail(
                        $email,
                        'Erro na sincronização dos Tutoriais do GitHub',
                        $atualizacao->get_error_message()
                    );
                }
            }
        }
        error_log('GitHub Tutos Sync Error: ' . $atualizacao->get_error_message());
    }
}
add_action('atualizar_tutos_github', 'atualizar_tutos_github_cb');

function agendar_tarefa_tutos_github(): void
{
    if (wp_next_scheduled('atualizar_tutos_github')) {
        return;
    }
    
    $datetime = get_option('tutos_github_schedule_datetime');
    $frequency = get_option('tutos_github_schedule_frequency', 'daily');
    
    if ($datetime) {
        $schedule_time = strtotime(str_replace('T', ' ', $datetime));
        if ($schedule_time === false || $schedule_time < time()) {
            $schedule_time = strtotime('tomorrow midnight');
        }
    } else {
        $schedule_time = strtotime('tomorrow midnight');
    }
    
    wp_schedule_event($schedule_time, $frequency, 'atualizar_tutos_github');
}
add_action('wp', 'agendar_tarefa_tutos_github');

function tutos_github_add_weekly_schedule($schedules): array
{
    $schedules['weekly'] = [
        'interval' => 604800,
        'display'  => 'Semanalmente'
    ];
    return $schedules;
}
add_filter('cron_schedules', 'tutos_github_add_weekly_schedule');

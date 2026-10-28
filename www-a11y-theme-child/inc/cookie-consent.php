<?php
defined('ABSPATH') || exit;

/**
 * Consentimento de cookies.
 *
 * Princípio: nada de terceiros é carregado sem uma ação explícita do visitante.
 * - Vídeos do YouTube: o <iframe> é substituído por um marcador; o vídeo só é
 *   carregado quando o visitante carrega em "Ver vídeo" ou permitiu vídeos nas definições.
 * - Assistente virtual (opção "ai_agent"): o script fica inativo até haver consentimento.
 * - A escolha fica no cookie primário "ama_consent" (estritamente necessário) e pode
 *   ser alterada a qualquer momento através do botão "Definições de cookies" no rodapé.
 *
 * O aviso só aparece quando existe algum serviço que carregaria em todas as páginas
 * (ex.: assistente virtual). Os vídeos pedem consentimento no próprio local.
 */

const AMA_CONSENT_COOKIE = 'ama_consent';

/**
 * Versão da política de cookies. Ao alterá-la, o consentimento é pedido de novo.
 */
function ama_cookie_consent_version(): int
{
    return (int) apply_filters('ama_cookie_consent_version', 1);
}

/**
 * Serviços que dependem de consentimento.
 *
 * "autoload" indica que o serviço carregaria em todas as páginas, pelo que justifica
 * mostrar o aviso de cookies; os restantes pedem consentimento no próprio local.
 */
function ama_cookie_services(): array
{
    $services = [
        'youtube' => [
            'label'       => 'Vídeos do YouTube',
            'description' => 'Permite ver os vídeos incorporados nas páginas. O YouTube (Google Ireland Limited) pode guardar cookies e recolher dados sobre a visualização.',
            'autoload'    => false,
        ],
    ];

    if (ama_ai_agent_markup_unfiltered() !== '') {
        $services['assistente'] = [
            'label'       => 'Assistente virtual',
            'description' => 'Ativa o assistente virtual de apoio à navegação. O fornecedor do assistente pode guardar cookies e registar as conversas.',
            'autoload'    => true,
        ];
    }

    return apply_filters('ama_cookie_services', $services);
}

/**
 * Snippet do assistente virtual sem o bloqueio de consentimento aplicado.
 */
function ama_ai_agent_markup_unfiltered(): string
{
    static $markup = null;

    if ($markup === null) {
        remove_filter('ama_ai_agent_markup', 'ama_cookie_block_ai_agent');
        $markup = ama_ai_agent_markup();
        add_filter('ama_ai_agent_markup', 'ama_cookie_block_ai_agent');
    }

    return $markup;
}

/**
 * Política de privacidade da ARTE, que cobre todos os sítios da ARTE e lista os seus cookies (issue #7).
 */
const AMA_PRIVACY_POLICY_URL = 'https://www.arte.gov.pt/politica-de-privacidade/';

function ama_cookie_policy_url(): string
{
    return (string) apply_filters('ama_cookie_policy_url', AMA_PRIVACY_POLICY_URL);
}

/**
 * Os scripts do assistente virtual ficam com type="text/plain" e só são
 * ativados pelo cookie-consent.js depois de o visitante dar consentimento.
 */
function ama_cookie_block_ai_agent(string $markup): string
{
    return str_replace(
        '<script src=',
        '<script type="text/plain" data-ama-consent="assistente" data-ama-src=',
        $markup
    );
}
add_filter('ama_ai_agent_markup', 'ama_cookie_block_ai_agent');

/**
 * Substitui os <iframe> do YouTube por um marcador que só carrega o vídeo
 * com consentimento. Sem JavaScript, fica disponível a ligação para o YouTube.
 */
function ama_cookie_block_youtube_iframes(string $content): string
{
    if (stripos($content, '<iframe') === false) {
        return $content;
    }

    // Nos excertos o <iframe> é descartado; o texto do marcador apareceria no resumo.
    if (doing_filter('get_the_excerpt')) {
        return $content;
    }

    return preg_replace_callback(
        '#<iframe\b[^>]*>.*?</iframe>#is',
        'ama_cookie_youtube_placeholder',
        $content
    );
}
add_filter('the_content', 'ama_cookie_block_youtube_iframes', 99);
add_filter('widget_text_content', 'ama_cookie_block_youtube_iframes', 99);
add_filter('widget_block_content', 'ama_cookie_block_youtube_iframes', 99);

/**
 * Gera o marcador para um <iframe>; devolve o original se não for um vídeo do YouTube.
 */
function ama_cookie_youtube_placeholder(array $matches): string
{
    $iframe = $matches[0];

    if (!preg_match('#\bsrc=(["\'])(.*?)\1#i', $iframe, $src_match)) {
        return $iframe;
    }

    $src = html_entity_decode($src_match[2]);
    if (!preg_match('#^(?:https?:)?//(?:www\.)?youtube(?:-nocookie)?\.com/embed/([A-Za-z0-9_-]{6,})#i', $src, $id_match)) {
        return $iframe;
    }

    $video_id = $id_match[1];

    // O parâmetro "si" é um identificador de partilha (rastreio) e não é necessário.
    $query = [];
    parse_str((string) wp_parse_url($src, PHP_URL_QUERY), $query);
    unset($query['si']);

    $embed_url = add_query_arg($query, 'https://www.youtube-nocookie.com/embed/' . $video_id);
    $watch_url = 'https://www.youtube.com/watch?v=' . $video_id;

    $title = '';
    if (preg_match('#\btitle=(["\'])(.*?)\1#i', $iframe, $title_match)) {
        $title = trim(html_entity_decode($title_match[2]));
    }
    if ($title === '' || stripos($title, 'youtube video player') !== false) {
        $title = 'Vídeo do YouTube';
    }

    $style = '';
    if (preg_match('#\bstyle=(["\'])(.*?)\1#i', $iframe, $style_match)) {
        $style = $style_match[2];
    }

    ob_start();
    ?>
<div class="ama-embed" data-ama-consent="youtube" data-ama-embed-src="<?= esc_url($embed_url) ?>" data-ama-embed-title="<?= esc_attr($title) ?>"<?= $style !== '' ? ' style="' . esc_attr($style) . '"' : '' ?>>
    <div class="ama-embed__placeholder">
        <p class="ama-embed__title"><?= esc_html($title) ?></p>
        <p>Este vídeo está alojado no YouTube. Ao vê-lo aqui, o YouTube pode guardar cookies no seu dispositivo.</p>
        <div class="ama-embed__actions">
            <button type="button" class="btn btn-primary ama ama-embed__load" hidden>Ver vídeo<span class="visually-hidden">: <?= esc_html($title) ?></span></button>
            <a href="<?= esc_url($watch_url) ?>" class="ama-embed__link">Abrir no YouTube<span class="visually-hidden">: <?= esc_html($title) ?></span></a>
        </div>
    </div>
</div>
    <?php
    return trim((string) ob_get_clean());
}

/**
 * Estilos e script do consentimento.
 */
function ama_cookie_consent_enqueue(): void
{
    $theme_version = wp_get_theme()->get('Version');

    wp_enqueue_style(
        'ama-cookie-consent',
        get_stylesheet_directory_uri() . '/css/cookie-consent.css',
        ['parent-style'],
        $theme_version
    );

    wp_enqueue_script(
        'ama-cookie-consent',
        get_stylesheet_directory_uri() . '/js/cookie-consent.js',
        [],
        $theme_version,
        ['in_footer' => true, 'strategy' => 'defer']
    );

    $services = [];
    foreach (ama_cookie_services() as $key => $service) {
        $services[$key] = ['autoload' => (bool) $service['autoload']];
    }

    // wp_localize_script converteria os números em texto; o JS compara a versão com ===.
    wp_add_inline_script('ama-cookie-consent', 'var AMA_CONSENT = ' . wp_json_encode([
        'cookie'   => AMA_CONSENT_COOKIE,
        'version'  => ama_cookie_consent_version(),
        'maxAge'   => 180 * DAY_IN_SECONDS,
        'services' => $services,
    ]) . ';', 'before');
}
add_action('wp_enqueue_scripts', 'ama_cookie_consent_enqueue', 12);

/**
 * Aviso de cookies, colocado no início do <body> e antes da ligação "Saltar para o
 * conteúdo", seguindo o padrão do GOV.UK Design System. Fica oculto até o
 * cookie-consent.js decidir que é necessário mostrá-lo.
 */
function ama_cookie_banner(): void
{
    $services   = ama_cookie_services();
    $policy_url = ama_cookie_policy_url();
    ?>
<section id="ama-cookie-banner" class="ama-cookie-banner" aria-labelledby="ama-cookie-banner-title" hidden>
    <div class="container py-4">
        <div class="ama-cookie-banner__question">
            <h2 id="ama-cookie-banner-title" class="ama-cookie-banner__title" tabindex="-1">Cookies no acessibilidade.gov.pt</h2>
            <p>Usamos apenas os cookies necessários para o site funcionar. Alguns conteúdos de terceiros, como vídeos, só são carregados se o permitir.</p>
            <?php if ($policy_url !== '') : ?>
                <p><a href="<?= esc_url($policy_url) ?>">Saiba mais na política de privacidade da ARTE</a></p>
            <?php endif; ?>

            <form class="ama-cookie-banner__settings" id="ama-cookie-settings" hidden>
                <fieldset>
                    <legend>Escolha os conteúdos de terceiros que quer permitir</legend>
                    <?php foreach ($services as $key => $service) : ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="ama-consent-<?= esc_attr($key) ?>" name="<?= esc_attr($key) ?>" aria-describedby="ama-consent-<?= esc_attr($key) ?>-desc">
                            <label class="form-check-label" for="ama-consent-<?= esc_attr($key) ?>"><?= esc_html($service['label']) ?></label>
                            <p class="ama-cookie-banner__hint" id="ama-consent-<?= esc_attr($key) ?>-desc"><?= esc_html($service['description']) ?></p>
                        </div>
                    <?php endforeach; ?>
                </fieldset>
            </form>

            <div class="ama-cookie-banner__actions">
                <button type="button" class="btn btn-primary ama" data-ama-consent-action="accept">Aceitar todos</button>
                <button type="button" class="btn btn-primary ama" data-ama-consent-action="reject">Rejeitar todos</button>
                <button type="button" class="btn btn-secondary ama" data-ama-consent-action="customize" aria-expanded="false" aria-controls="ama-cookie-settings">Escolher</button>
                <button type="button" class="btn btn-secondary ama" data-ama-consent-action="save" hidden>Guardar escolhas</button>
            </div>
        </div>

        <div class="ama-cookie-banner__confirmation" hidden>
            <p class="ama-cookie-banner__message" tabindex="-1"></p>
            <button type="button" class="btn btn-secondary ama" data-ama-consent-action="hide">Ocultar mensagem</button>
        </div>
    </div>
</section>
    <?php
}
add_action('wp_body_open', 'ama_cookie_banner', 1);

/**
 * Botão permanente para rever ou retirar o consentimento.
 */
function ama_cookie_settings_button(): string
{
    return '<button type="button" class="btn btn-link ama-cookie-settings-button p-0" data-ama-consent-action="open">Definições de cookies</button>';
}

/**
 * [ama_cookies]: lista os cookies e serviços de terceiros, para a página de política de cookies.
 */
function ama_cookies_shortcode(): string
{
    $rows = [
        [AMA_CONSENT_COOKIE, 'acessibilidade.gov.pt', 'Guarda as suas escolhas sobre cookies.', '6 meses', 'Necessário'],
        ['darkMode (armazenamento local)', 'acessibilidade.gov.pt', 'Lembra se escolheu o modo escuro.', 'Até o apagar', 'Necessário'],
    ];
    foreach (ama_cookie_services() as $service) {
        $rows[] = [$service['label'], 'Terceiros', $service['description'], 'Definida pelo fornecedor', 'Só com consentimento'];
    }

    ob_start();
    ?>
<table class="table ama-cookies-table">
    <caption>Cookies e armazenamento usados no acessibilidade.gov.pt</caption>
    <thead>
        <tr><th scope="col">Nome</th><th scope="col">Origem</th><th scope="col">Finalidade</th><th scope="col">Duração</th><th scope="col">Tipo</th></tr>
    </thead>
    <tbody>
        <?php foreach ($rows as $row) : ?>
            <tr>
                <th scope="row"><?= esc_html($row[0]) ?></th>
                <td><?= esc_html($row[1]) ?></td>
                <td><?= esc_html($row[2]) ?></td>
                <td><?= esc_html($row[3]) ?></td>
                <td><?= esc_html($row[4]) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<p><?= ama_cookie_settings_button() ?></p>
    <?php
    return (string) ob_get_clean();
}
add_shortcode('ama_cookies', 'ama_cookies_shortcode');

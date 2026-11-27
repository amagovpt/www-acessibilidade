<?php
/**
 * Títulos com marcação HTML.
 *
 * O título de um artigo ou página pode ter marcação inline, por exemplo:
 *   <abbr title="Agência para a Reforma Tecnológica do Estado">ARTE</abbr> e
 *   <abbr title="World Wide Web" lang="en">W3C</abbr> lutam contra a arte de <em lang="en">phishing</em>!
 *
 * O WordPress já tira as etiquetas no <title> do documento e mostra-as no <h1>. Estas
 * funções fazem o mesmo no resto do tema:
 * - ama_titulo_texto(): texto simples, para atributos (title, alt, aria-label) e links mailto;
 * - ama_titulo_html(): o título com a marcação inline permitida, para texto visível.
 */

/**
 * Etiquetas inline permitidas em títulos visíveis.
 */
function ama_titulo_etiquetas(): array
{
    $lang = ['lang' => true];

    return [
        'abbr'   => ['title' => true, 'lang' => true],
        'dfn'    => ['title' => true, 'lang' => true],
        'em'     => $lang,
        'strong' => $lang,
        'i'      => $lang,
        'b'      => $lang,
        'span'   => $lang,
        'cite'   => $lang,
        'q'      => $lang,
        'code'   => [],
        'sub'    => [],
        'sup'    => [],
    ];
}

/**
 * Título como texto simples (sem etiquetas nem entidades). Escapar ao usar:
 * esc_attr(ama_titulo_texto($post)).
 *
 * @param int|WP_Post $post
 */
function ama_titulo_texto($post = 0): string
{
    $texto = wp_strip_all_tags(get_the_title($post));

    return trim(html_entity_decode($texto, ENT_QUOTES | ENT_HTML5, 'UTF-8'));
}

/**
 * Título com a marcação inline permitida, pronto a imprimir.
 *
 * @param int|WP_Post $post
 */
function ama_titulo_html($post = 0): string
{
    return wp_kses(get_the_title($post), ama_titulo_etiquetas());
}

/**
 * Link "Enviar email" com sugestão de melhoria para o tutorial atual.
 */
function ama_titulo_link_sugestao(string $texto = 'Enviar email'): string
{
    $assunto = 'Sugestão de melhoria para o tutorial: ' . ama_titulo_texto();

    return sprintf(
        '<a href="%s" title="%s">%s</a>',
        esc_url('mailto:acessibilidade@gov.pt?subject=' . rawurlencode($assunto)),
        esc_attr($assunto),
        esc_html($texto)
    );
}

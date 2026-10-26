<?php
/**
 * Template name: Página c/ Markdown
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Incluir biblioteca PHP de markdown
include __DIR__ . "/../libs/Parsedown/Parsedown.php";

// Agarra no conteúdo markdown e transforma em HTML
$Parsedown  = new Parsedown();
$github_url = get_field('tutorial_github_url');

$parsed_markdown_content = "";
if ($Parsedown && $github_url !=='') {
    $api_url            = str_replace('github.com', 'api.github.com/repos', $github_url) . '/contents/README.md';
    $github_response    = wp_remote_get($api_url);

    if (is_array($github_response) && !is_wp_error($github_response)) {
        $body = json_decode($github_response['body'], true);
        if (isset($body['content'])) {
            // O conteúdo está codificado em base64
            $readme_content = base64_decode($body['content']);

            // Mostra o conteúdo
            $parsed_markdown_content = add_id_to_titles($Parsedown->text($readme_content));
        } else {
            // Não foi possível ler o conteúdo
            $parsed_markdown_content = 'Erro ao carregar o conteúdo';
        }
    }
    // echo $Parsedown->text('##Hello _Parsedown_!');
} else {
    // Não foi posível ler o conteúdo remotamente
    $parsed_markdown_content ='Erro ao carregar o conteúdo';
}

// Função para adicionar IDs automáticos aos <h2> tags
function add_id_to_titles($html_content)
{
    // Use DOMDocument para manipular o HTML
    $dom = new DOMDocument();

    // Suprimir erros devido a HTML malformado
    libxml_use_internal_errors(true);

    $dom->loadHTML('<?xml encoding="utf-8" ?>' . $html_content);
    libxml_clear_errors();

    $h2_tags = $dom->getElementsByTagName('h2');
    foreach ($h2_tags as $index => $h2) {
        $id = 'titulo-' . ($index + 1);
        $h2->setAttribute('id', $id);
    }

    // Extrair o corpo do conteúdo, excluindo o doctype e outras tags HTML extras
    $body = $dom->getElementsByTagName('body')->item(0);
    $html = '';
    foreach ($body->childNodes as $child) {
        $html .= $dom->saveHTML($child);
    }

    return $html;
}

wp_enqueue_style(
    "fulld-width",
    get_stylesheet_directory_uri() . "/css/full-width.css",
    "",
    "1.0.0",
);

wp_enqueue_script(
    "AccessMonitor",
    get_stylesheet_directory_uri() . "/js/AccessMonitor.js",
    ["jquery"],
    "1.0.0",
    "defer"
);

get_header();
?>
    <main class="site-main tutorial" id="main">
        <div class="wrapper" id="page-wrapper">
            <div class="container-fluid p-0" id="content" tabindex="-1">
                <div class="container">
                    <div class="row">
                        <div class="page-header col">
                            <nav aria-label="Você está aqui">
                                <ol class="breadcrumb mb-5">
                                    <li class="breadcrumb-item">
                                        <a href="<?= site_url(); ?>">Início</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="<?= site_url("tutoriais") ?>">Tutoriais</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        <?= the_title(); ?>
                                    </li>
                                </ol>
                            </nav>
                            <div class="row">
                                <div class="col-12 mb-3"><a href="<?= site_url("tutoriais")?>" class="version" title="Consulte todos os artigos classificados nesta categoria">Tutoriais</a></div>
                                <div class="col-12 col-lg-8<?php echo has_excerpt() ? '' : ' align-self-end'; ?>">
                                    <h1><?php the_title(); ?></h1>
                                    <?php
                                    if ( has_excerpt() ) : ?>
                                        <div class="excerpt">
                                            <?php the_excerpt(); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <?php
                                //if ( has_post_thumbnail() ) : ?>
                                <div class="d-none d-lg-flex col-lg-4 d-flex justify-content-center featured-image">
                                    <div class="featured-image">
                                        <?php
                                        // Verifica se o tutorial tem feature image ou se aplica o ACF do icon de destaque (HTML)
                                        if(has_post_thumbnail()) {
                                            the_post_thumbnail();
                                        } elseif(get_field('ama_icon_destaque')) {
                                            echo get_field('ama_icon_destaque');
                                        }
                                        ?>
                                    </div>
                                </div>
                                <?php //endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-content">
                    <div class="container">
                        <div class="row g-5">
                            <aside class="col-12 col-md-4">
                                <!--<h2>Índice de conteúdo</h2>
                                <?= do_shortcode("[indice]"); ?> -->
                            </aside>
                            <div class="col-12 col-md-8">
                                <?php
                                echo $parsed_markdown_content;
                                the_content();
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="container p-4 my-5">
                        <div class="row border border-5 border-black p-3 p-lg-5">
                            <div class="order-md-2 col-12 col-md-4 d-flex flex-row justify-content-center justify-content-md-end">
                                <img src="<?= get_stylesheet_directory_uri()."/img/icon-ajuda.svg" ?>" alt="" class="img-fluid mb-4 mb-md-0" width="150">
                            </div>
                            <div class="order-md-1 col-12 col-md-8">
                                <h2 class="mb-4">Ajude-nos a melhorar esta página</h2>
                                <p class="mb-4">Partilhe connosco as sugestões, comentários ou dúvidas através do e-mail <a href="mailto:acessibilidade@ama.gov.pt">acessibilidade@ama.gov.pt</a>, ou via GitHub.</p>
                                <ul class="ama-list d-flex flex-row gap-3">
                                    <li>
                                        <a href="mailto:acessibilidade@gov.pt?subject=Sugestão de melhoria para o tutorial: <?= get_the_title() ?>" title="Sugestão de melhoria para o tutorial: <?= get_the_title() ?>">Enviar email</a>
                                    </li>
                                    <li>
                                        <a href="https://github.com">Github</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="page-footer col">
                            <div class="d-flex justify-content-between">
                                <div class="share-post">
                                    <h2>Partilhar</h2>
                                    <ul class="d-flex list-inline mb-0">
                                        <li>
                                            <button id="fb-icon" type="button" role="button" aria-label="Partilhar no Facebook" >
                                                <span class="icon-share-facebook" aria-hidden="true"></span>
                                            </button>
                                        </li>
                                        <li>
                                            <button id="tw-icon" type="button" role="button" aria-label="Partilhar no Twitter">
                                                <span class="icon-share-twitter" aria-hidden="true"></span>
                                            </button>
                                        </li>
                                        <li>
                                            <button id="ld-icon" type="button" role="button" aria-label="Partilhar no Linkedin">
                                                <span class="icon-share-linkedin" aria-hidden="true"></span>
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                                <div class="last-update py-2">
                                    <p class="mb-0">Última atualização: <?php echo get_the_modified_date('j \d\e F, Y'); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col">
                    <?= do_shortcode('[accessmonitor_wide]'); ?>
                </div>
            </div>
        </div>
    </main>
<?php
get_footer();
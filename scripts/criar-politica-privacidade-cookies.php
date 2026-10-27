<?php
// Cria (ou atualiza) o rascunho da página "Política de privacidade e cookies" — issue #7.
// Uso: php scripts/criar-politica-privacidade-cookies.php /caminho/para/wordpress
require rtrim($argv[1], '/') . '/wp-load.php';

$p = static fn(string $t): string => "<!-- wp:paragraph -->\n<p>$t</p>\n<!-- /wp:paragraph -->\n\n";
$h = static fn(string $t): string => "<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">$t</h2>\n<!-- /wp:heading -->\n\n";
$ul = static function (array $items): string {
    return "<!-- wp:list -->\n<ul class=\"wp-block-list\">" . implode('', array_map(
        static fn($i) => "<!-- wp:list-item -->\n<li>$i</li>\n<!-- /wp:list-item -->",
        $items
    )) . "</ul>\n<!-- /wp:list -->\n\n";
};
$validar = static fn(string $t): string => "<mark>[A VALIDAR PELA ARTE: $t]</mark>";

$content =
    $p('Esta política explica que dados pessoais são tratados no sítio acessibilidade.gov.pt, para que fins, durante quanto tempo e como pode exercer os seus direitos. Explica também que cookies e tecnologias semelhantes usamos.') .

    $h('Quem é o responsável pelo tratamento') .
    $p('A Agência para a Reforma Tecnológica do Estado, I.P. (ARTE), que gere este sítio. ' . $validar('morada e contacto do Encarregado de Proteção de Dados (EPD)')) .

    $h('Que dados tratamos e porquê') .
    $p('<strong>Formulário de contacto.</strong> Quando nos escreve, tratamos o seu nome, endereço de e-mail e a mensagem, para responder ao seu pedido. Por razões de segurança e para prevenir abusos, o sistema regista também o endereço IP e o navegador usados no envio. ' . $validar('fundamento jurídico — consentimento (art. 6.º, n.º 1, al. a) do RGPD) ou exercício de funções de interesse público (al. e)')) .
    $p('<strong>Navegação.</strong> O servidor regista, de forma automática, dados técnicos dos pedidos (endereço IP, data e hora, página pedida e navegador), necessários para o funcionamento e a segurança do sítio. ' . $validar('prazo de conservação dos registos do servidor')) .
    $p('Não usamos ferramentas de estatística nem de publicidade, e não criamos perfis dos visitantes.') .

    $h('Durante quanto tempo guardamos os dados') .
    $ul([
        'Formulário de contacto (nome, e-mail, mensagem, IP e navegador): 30 dias ou até a resposta estar concluída.',
        'Registos técnicos do servidor: ' . $validar('prazo'),
        'Escolha sobre cookies (cookie <code>ama_consent</code>): 6 meses, no seu dispositivo.',
    ]) .

    $h('Com quem partilhamos os dados') .
    $p('Os dados ficam alojados na infraestrutura tecnológica da ARTE e não são vendidos nem cedidos a terceiros. ' . $validar('confirmar se o envio de e-mail do formulário usa algum prestador externo (subcontratante)')) .
    $p('Alguns conteúdos são fornecidos por terceiros e <strong>só são carregados se o permitir</strong>:') .
    $ul([
        '<strong>Vídeos do YouTube</strong> (Google Ireland Limited): ao ver um vídeo, o YouTube pode guardar cookies e recolher dados sobre a visualização, de acordo com a <a href="https://policies.google.com/privacy?hl=pt-PT">política de privacidade da Google</a>. Os vídeos são carregados a partir de youtube-nocookie.com.',
        '<strong>Assistente virtual</strong> (quando disponível): o fornecedor pode guardar cookies e registar as conversas. ' . $validar('identificar o fornecedor e ligar para a sua política de privacidade'),
    ]) .

    $h('Cookies') .
    $p('Os cookies são pequenos ficheiros que um sítio guarda no seu dispositivo. Usamos apenas os cookies e o armazenamento local estritamente necessários para o sítio funcionar e para lembrar as suas escolhas. Esses não precisam de consentimento. Os conteúdos de terceiros indicados acima só são carregados com o seu consentimento.') .
    $p('Pode aceitar, recusar ou alterar a sua escolha a qualquer momento através do botão «Definições de cookies», no rodapé de todas as páginas ou abaixo da tabela seguinte. Pode também apagar os cookies nas definições do seu navegador.') .
    "<!-- wp:shortcode -->\n[ama_cookies]\n<!-- /wp:shortcode -->\n\n" .

    $h('Os seus direitos') .
    $p('Pode pedir o acesso, a retificação, o apagamento, a limitação ou a portabilidade dos seus dados, opor-se ao tratamento e, quando o tratamento se baseia no consentimento, retirá-lo a qualquer momento, sem afetar o tratamento já efetuado. Para isso, contacte ' . $validar('e-mail do EPD da ARTE') . '.') .
    $p('Tem também o direito de apresentar reclamação à <a href="https://www.cnpd.pt/">Comissão Nacional de Proteção de Dados (CNPD)</a>.') .

    $h('Alterações a esta política') .
    $p('Esta política pode ser atualizada. Quando a alteração afetar os cookies, voltaremos a pedir a sua escolha. Última atualização: ' . $validar('data de publicação') . '.') .

    $h('Legislação aplicável') .
    $ul([
        'Regulamento (UE) 2016/679 (Regulamento Geral sobre a Proteção de Dados — RGPD).',
        'Lei n.º 58/2019, de 8 de agosto, que assegura a execução do RGPD.',
        'Lei n.º 41/2004, de 18 de agosto, relativa à privacidade nas comunicações eletrónicas (cookies), na redação atual.',
    ]);

$existing = get_page_by_path('politica-de-privacidade-e-cookies', OBJECT, 'page');

$postarr = [
    'post_type'    => 'page',
    'post_status'  => $existing && $existing->post_status === 'publish' ? 'publish' : 'draft',
    'post_title'   => 'Política de privacidade e cookies',
    'post_name'    => 'politica-de-privacidade-e-cookies',
    'post_content' => $content,
];
if ($existing) {
    $postarr['ID'] = $existing->ID;
}

$id = wp_insert_post(wp_slash($postarr), true);
if (is_wp_error($id)) {
    fwrite(STDERR, $id->get_error_message() . "\n");
    exit(1);
}

// Definições ➜ Privacidade. Enquanto a página for rascunho, get_privacy_policy_url() devolve ''
// e o aviso de cookies não mostra a ligação; passa a mostrá-la quando a página for publicada.
update_option('wp_page_for_privacy_policy', $id);

echo "Página $id (" . get_post_status($id) . "): " . get_permalink($id) . "\n";

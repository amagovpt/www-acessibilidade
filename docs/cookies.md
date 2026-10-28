# Consentimento de cookies

Implementado no tema filho (`www-a11y-theme-child`) na sequência da issue #3.

**Princípio:** nada de terceiros é carregado sem uma ação explícita do visitante.

## Ficheiros

| Ficheiro | Função |
|---|---|
| `www-a11y-theme-child/inc/cookie-consent.php` | Lista de serviços, bloqueio dos vídeos e do assistente, HTML do aviso, botão do rodapé e shortcode |
| `www-a11y-theme-child/js/cookie-consent.js` | Lê e grava a escolha, ativa os conteúdos e controla o aviso |
| `www-a11y-theme-child/css/cookie-consent.css` | Estilos do aviso e dos marcadores de vídeo (inclui modo escuro) |
| `www-a11y-theme/header.php` | Chama `wp_body_open()`, onde o aviso é inserido |
| `www-a11y-theme/functions.php` | Filtro `ama_ai_agent_markup` sobre o script do assistente virtual |
| `www-a11y-theme-child/footer.php` | Botão "Definições de cookies" |

## Como funciona

1. **Vídeos do YouTube.** No filtro `the_content` (e nos widgets), cada `<iframe>` do YouTube é trocado por um marcador `.ama-embed` com:
   - um botão "Ver vídeo", que só fica visível com JavaScript;
   - uma ligação "Abrir no YouTube", que funciona sempre.

   O vídeo carrega a partir de `youtube-nocookie.com` e sem o parâmetro de rastreio `si`. Os excertos não são alterados.
2. **Assistente virtual.** O script da opção `ai_agent` sai com `type="text/plain"` e `data-ama-src`. Depois do consentimento, o JS recria o script com os atributos originais.
3. **Aviso.**
   - Só é mostrado quando há serviços com `autoload => true`, ou seja, que carregariam em todas as páginas (hoje, apenas o assistente).
   - Os vídeos pedem consentimento no próprio local.
   - Os botões "Aceitar todos", "Rejeitar todos" e "Escolher" têm o mesmo destaque.
   - Fica antes da ligação "Saltar para o conteúdo" (padrão do GOV.UK Design System).
   - A mensagem de confirmação recebe o foco.
4. **Escolha.** Fica no cookie primário `ama_consent`, com o valor `{"v":1,"youtube":true,"assistente":false}`. Dura 6 meses, com `SameSite=Lax` e `Secure` em HTTPS. Este cookie é estritamente necessário, por isso não precisa de consentimento.
5. **Retirar o consentimento.** Faz-se no botão "Definições de cookies" do rodapé. Se um serviço já carregado deixar de ser permitido, a página é recarregada.

## Cookies e armazenamento

| Nome | Origem | Finalidade | Duração | Tipo |
|---|---|---|---|---|
| `ama_consent` | 1.ª parte | Guarda as escolhas sobre cookies | 6 meses | Necessário |
| `darkMode` (localStorage) | 1.ª parte | Lembra o modo escuro | Até ser apagado | Necessário |
| YouTube | Google Ireland Ltd. | Reprodução de vídeos | Definida pelo fornecedor | Só com consentimento |
| Assistente virtual | Fornecedor do assistente | Assistente de apoio | Definida pelo fornecedor | Só com consentimento |

Esta tabela é gerada na página com o shortcode `[ama_cookies]`.

## Política de privacidade (issue #7)

O site não tem política própria: usa a [política de privacidade da ARTE](https://www.arte.gov.pt/politica-de-privacidade/), que cobre todos os sítios da ARTE e tem a lista dos cookies de cada um. O aviso de cookies, o menu do rodapé e o formulário de contacto ligam para ela, e a página "Termos e Condições" foi retirada.

As alterações de conteúdo (menu, páginas e formulário) estão em `scripts/politica-privacidade-arte.php`:

```sh
php scripts/politica-privacidade-arte.php /caminho/para/wordpress            # mostra o que muda
php scripts/politica-privacidade-arte.php /caminho/para/wordpress --aplicar  # aplica
```

### Para acrescentar à tabela de cookies da ARTE

No formato da tabela da ARTE (Cookie | Domínio | Propósito | Data de expiração):

| Cookie | Domínio | Propósito | Data de expiração |
|---|---|---|---|
| `ama_consent` | acessibilidade.gov.pt | Guarda as escolhas do visitante sobre conteúdos de terceiros (vídeos do YouTube e, quando existe, assistente virtual). Estritamente necessário. | 6 meses |

Armazenamento no navegador (não são cookies, mas a ePrivacy também os abrange; todos estritamente necessários, nenhum sai do navegador):

| Nome | Domínio | Propósito | Data de expiração |
|---|---|---|---|
| `darkMode` (localStorage) | acessibilidade.gov.pt | Lembra se o visitante escolheu o modo escuro | Até o visitante o apagar |
| `dark_mode` (sessionStorage) | acessibilidade.gov.pt, incluindo /gerador | Mantém o modo escuro durante a visita | Sessão |
| `ama_consent_message` (sessionStorage) | acessibilidade.gov.pt | Mostra a confirmação da escolha de cookies depois de a página recarregar | Sessão |
| ID do botão (sessionStorage) | acessibilidade.gov.pt/gerador | Lembra que secções do gerador estão abertas ou fechadas | Sessão |

Terceiros, só com consentimento:

- **YouTube** (Google Ireland Limited): os vídeos só são carregados a partir de `youtube-nocookie.com` depois de o visitante o permitir. A tabela da ARTE já tem uma linha para os cookies dos vídeos incorporados; basta acrescentar acessibilidade.gov.pt.
- **Assistente virtual** (`virtualbrain.ai`): só existe se a opção `ai_agent` estiver preenchida, e só carrega com consentimento.

Não usamos: o servidor não envia cookies nas páginas públicas, e nem o site nem o `/gerador` usam o Google Analytics (`_ga`, `_gid`, `_gat`). Na tabela da ARTE, a linha "Maioria dos sites da ARTE" do Google Analytics não deve incluir o acessibilidade.gov.pt. Os cookies do WordPress (`wordpress_logged_in_*`, `wordpress_sec_*`, `wp-settings-*`) só existem para quem entra na área de gestão.

## Configuração (filtros)

| Filtro | Por omissão | Uso |
|---|---|---|
| `ama_cookie_services` | `youtube` e, se houver `ai_agent`, `assistente` | Acrescentar ou alterar serviços |
| `ama_cookie_consent_version` | `1` | Incrementar quando a política mudar, para pedir consentimento de novo |
| `ama_cookie_policy_url` | `https://www.arte.gov.pt/politica-de-privacidade/` | Ligação "Saiba mais" do aviso |
| `ama_ai_agent_markup` | — | HTML do assistente; o tema filho usa-o para o bloquear |

### Acrescentar um serviço (ex.: estatísticas)

```php
add_filter('ama_cookie_services', function (array $services): array {
    $services['estatisticas'] = [
        'label'       => 'Estatísticas',
        'description' => 'Ajuda-nos a perceber como o site é usado.',
        'autoload'    => true, // carrega em todas as páginas: mostra o aviso
    ];
    return $services;
});
```

O script do serviço tem de ser impresso já bloqueado:

```html
<script type="text/plain" data-ama-consent="estatisticas" data-ama-src="https://…/script.js" async></script>
```

## Testes manuais

1. Com o browser limpo, abrir uma página com vídeo (ex.: `/jornadas-2025/`). Confirmar que:
   - não há pedidos a `youtube.com` nem a `google.com`;
   - não há `Set-Cookie`;
   - o marcador do vídeo aparece.
2. "Ver vídeo" carrega só esse vídeo, a partir de `youtube-nocookie.com`, e o foco passa para o vídeo.
3. "Definições de cookies" (no rodapé) ➜ "Escolher" ➜ marcar "Vídeos do YouTube" ➜ "Guardar escolhas". Todos os vídeos carregam e aparece a confirmação.
4. Rodapé ➜ "Rejeitar todos". A página recarrega sem vídeos e mostra a confirmação.
5. Com a opção `ai_agent` definida, o aviso aparece em todas as páginas até haver uma escolha.

## Pendente

- Enviar à ARTE a lista acima, para a tabela de cookies da política de privacidade.
- O `/gerador` ainda carrega a fonte Lato de `fonts.googleapis.com` (repositório `amagovpt/a11y-da`).

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

## Configuração (filtros)

| Filtro | Por omissão | Uso |
|---|---|---|
| `ama_cookie_services` | `youtube` e, se houver `ai_agent`, `assistente` | Acrescentar ou alterar serviços |
| `ama_cookie_consent_version` | `1` | Incrementar quando a política mudar, para pedir consentimento de novo |
| `ama_cookie_policy_url` | `get_privacy_policy_url()` | Ligação "Saiba mais" do aviso |
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

- Criar a página de política de privacidade/cookies e defini-la em **Definições ➜ Privacidade**.
- O gerador (`/gerador`, repositório `amagovpt/a11y-da`) precisa da mesma limpeza: remover o aviso placebo e o `gtag.js`.
- Alojar a fonte Noto Sans localmente: hoje vem de `fonts.googleapis.com`, que recebe o IP de cada visitante.

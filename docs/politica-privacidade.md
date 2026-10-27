# Política de privacidade e cookies

Issue #7. O sítio não tinha página de política de privacidade (`wp_page_for_privacy_policy` = 0); o rodapé e o formulário de contacto ligavam para a política genérica de ama.gov.pt.

## Criar a página

```sh
php scripts/criar-politica-privacidade-cookies.php /caminho/para/wordpress
```

O script:

- cria (ou atualiza) a página `politica-de-privacidade-e-cookies` como **rascunho** — se já estiver publicada, mantém-na publicada;
- define-a em **Definições ➜ Privacidade** (`wp_page_for_privacy_policy`). Enquanto for rascunho, `get_privacy_policy_url()` devolve vazio e o aviso de cookies não mostra a ligação;
- inclui o shortcode `[ama_cookies]` (PR #5), que gera a tabela de cookies e o botão "Definições de cookies".

Pode ser corrido várias vezes: atualiza a mesma página.

## A validar pela ARTE

O texto tem 8 marcadores `[A VALIDAR PELA ARTE: …]`, realçados com `<mark>`:

1. Morada e contacto do Encarregado de Proteção de Dados (EPD)
2. Fundamento jurídico do formulário de contacto — consentimento (art. 6.º, n.º 1, al. a) RGPD) ou interesse público (al. e)
3. Prazo de conservação dos registos do servidor (texto)
4. Prazo de conservação dos registos do servidor (lista)
5. Se o envio de e-mail do formulário usa um prestador externo (subcontratante)
6. Fornecedor do assistente virtual e ligação para a sua política de privacidade
7. E-mail do EPD para exercício de direitos
8. Data de publicação

O texto indica 30 dias de conservação para as mensagens do formulário de contacto. Hoje há mensagens mais antigas na base de dados: apagá-las ou ajustar o prazo é decisão da ARTE.

## Depois da validação

1. Substituir os marcadores pelo texto final e publicar a página.
2. **Aparência ➜ Menus**: trocar, no menu do rodapé, a ligação para a política de ama.gov.pt pela nova página.
3. **Formidable ➜ Formulário de contacto**: trocar a ligação para a política de ama.gov.pt pela nova página.

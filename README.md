# Site Relpps Cosméticos

Site institucional + catálogo de produtos com painel administrativo, feito em **PHP + MySQL**
puro (sem framework), pronto pra rodar em qualquer hospedagem compartilhada com cPanel (ex:
Hostinger). Domínio: relpps.com.br.

## O que tem aqui

- Site público: início, catálogo (busca + filtro por categoria: Unhas, Cílios, Sobrancelhas),
  página de produto, promoções em destaque, blog, sobre, contato.
- Botão flutuante de WhatsApp em todas as páginas.
- Selo de avaliação do Google (nota + link pro perfil) — editável pelo painel, sem API paga.
- Painel administrativo (`/admin`) protegido por login: produtos (com foto, categoria, preço
  opcional, marcação de promoção da semana), blog, e configurações da loja (endereço, horário,
  WhatsApp, Instagram, nota do Google, mapa).

## Passo a passo para publicar na hospedagem (cPanel / Hostinger)

### 1. Criar o banco de dados

No painel da hospedagem, procure **"Bancos de Dados MySQL"**:

1. Crie um banco de dados (ex: `relpps`) — o nome final geralmente fica `seuusuario_relpps`.
2. Crie um usuário MySQL com uma senha forte.
3. Associe o usuário ao banco, dando todos os privilégios.
4. Anote: nome do banco, nome do usuário e senha.

### 2. Importar a estrutura do banco

1. Abra o **phpMyAdmin** pelo cPanel.
2. Selecione o banco que você criou.
3. Vá em **Importar** e envie o arquivo `sql/schema.sql` desta pasta.
4. Isso cria as tabelas e já deixa a configuração inicial da loja (endereço, horário, WhatsApp,
   Instagram, link do Google) preenchida com os dados reais coletados na entrevista com o
   cliente.

### 3. Configurar a conexão

Abra `config.php` e preencha:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'seuusuario_relpps');
define('DB_USER', 'seuusuario_relpps');
define('DB_PASS', 'a-senha-que-voce-criou');

define('SITE_URL', 'https://relpps.com.br');
```

### 4. Enviar os arquivos

Envie **todo o conteúdo desta pasta `site/`** (não a pasta em si) pra `public_html` da
hospedagem, via FTP ou Gerenciador de Arquivos do cPanel.

**Não precisa enviar a pasta `tests/`** — é ferramenta de desenvolvimento local, não faz parte
do site publicado. O script `tests/setup-db.php` apaga e recria o banco de dados sem exigir
login; ele nunca deve rodar em produção.

### 5. Ajustar permissões da pasta de uploads

Garanta que `uploads/produtos` e `uploads/blog` tenham permissão de escrita (geralmente `755`;
se der erro ao enviar imagem, tente `775`).

### 6. Criar o primeiro usuário administrador

Acesse `https://relpps.com.br/admin/instalar.php`. Essa página só funciona uma vez — depois se
bloqueia sozinha.

### 7. Acessar o painel

`https://relpps.com.br/admin/login.php` — cadastre os produtos reais (substituindo os exemplos
inseridos pelo `schema.sql`), artigos de blog e confirme os dados em Configurações.

## Estrutura de pastas

```
site/
├── config.php              # credenciais do banco (preencher antes de subir)
├── index.php
├── produtos.php             # catálogo com busca e filtro por categoria/promoção
├── produto.php               # página de um produto (?slug=...)
├── blog.php / post.php
├── sobre.php / contato.php
├── includes/                 # conexão, auth, funções, header/footer
├── assets/                   # css, js, imagens (logo em assets/img/logo.png)
├── uploads/                  # fotos enviadas pelo painel (produtos, blog)
├── sql/schema.sql
└── admin/                    # painel administrativo (login obrigatório)
    ├── instalar.php / login.php / logout.php / index.php
    ├── produtos.php / produto-form.php
    ├── blog.php / post-form.php
    └── configuracoes.php
```

## Categorias

Fixas em `includes/functions.php` (`categorias()`): Unhas, Cílios, Sobrancelhas — sem
subcategorias (decisão do cliente).

## Fase 2 (futuro)

O cliente sinalizou interesse em evoluir pra carrinho de compras/venda online no futuro. A
tabela `produtos` já tem `id`, `slug` e `preco` estáveis desde o início pra isso ser aditivo
(tabelas novas de carrinho/pedido), sem precisar redesenhar o catálogo atual. Nada disso está
implementado nesta fase.

## Requisitos da hospedagem

- PHP 7.4+ com extensão PDO MySQL.
- MySQL 5.7+ ou MariaDB equivalente.

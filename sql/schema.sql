-- clientes/Relpps-Cosméticos/site/sql/schema.sql
CREATE TABLE IF NOT EXISTS admin_usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario VARCHAR(50) NOT NULL UNIQUE,
  senha_hash VARCHAR(255) NOT NULL,
  criado_em DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS produtos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  slug VARCHAR(160) NOT NULL UNIQUE,
  nome VARCHAR(160) NOT NULL,
  descricao TEXT,
  foto VARCHAR(255),
  categoria ENUM('unhas','cilios','sobrancelhas') NOT NULL,
  preco DECIMAL(10,2) NULL,
  em_promocao TINYINT(1) NOT NULL DEFAULT 0,
  ativo TINYINT(1) NOT NULL DEFAULT 1,
  criado_em DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS blog_posts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  slug VARCHAR(160) NOT NULL UNIQUE,
  titulo VARCHAR(200) NOT NULL,
  resumo VARCHAR(300),
  conteudo TEXT NOT NULL,
  capa VARCHAR(255),
  publicado_em DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS configuracoes (
  chave VARCHAR(60) PRIMARY KEY,
  valor TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO blog_posts (slug, titulo, resumo, conteudo) VALUES
('brow-lamination-x-micropigmentacao', 'Brow lamination x micropigmentação: qual técnica indicar para cada cliente', 'Duas das técnicas mais procuradas para sobrancelhas definidas — entenda as diferenças, indicações e como orientar cada cliente na escolha certa.', 'Sobrancelhas bem desenhadas continuam sendo um dos serviços mais procurados em salões e estúdios de beleza — mas a forma de entregar esse resultado mudou muito nos últimos anos. Duas técnicas dividem a preferência das clientes hoje: o brow lamination e a micropigmentação. Saber indicar a certa para cada perfil é o que separa um profissional generalista de um especialista de confiança.

O brow lamination é um procedimento não invasivo que reestrutura os fios da sobrancelha, alinhando-os numa direção desejada — geralmente para cima e para os lados, criando um efeito volumoso e uniforme. O resultado dura entre quatro e seis semanas e não altera a pele nem a quantidade de fios: trabalha com o que a cliente já tem. É a escolha ideal para quem tem sobrancelhas desalinhadas, com fios rebeldes, ou quer um efeito natural e reversível sem compromisso de longo prazo.

Já a micropigmentação trabalha em outra camada: insere pigmento na pele para preencher falhas, redesenhar o formato ou reconstruir sobrancelhas rareadas, seja por alopecia, over-plucking antigo ou envelhecimento. O resultado dura de um a três anos, dependendo da técnica (fio a fio, hairstroke, sombreado) e do tipo de pele da cliente. É a indicação certa para quem busca uma solução de longo prazo e não tem fios suficientes para um lamination fazer diferença.

Na prática, a pergunta que guia a indicação não é "qual técnica é melhor", mas "o que essa cliente tem e o que ela busca". Fios presentes mas desalinhados, resultado reversível, orçamento menor e retorno rápido ao salão levam ao brow lamination. Falhas visíveis, fios rareados, busca por resultado de longa duração e disposição para investir mais levam à micropigmentação. Muitas profissionais inclusive combinam as duas ao longo do relacionamento com a cliente: começam com lamination para fios que ainda respondem bem, e migram para micropigmentação quando a demanda muda.

Para quem atende as duas frentes, vale manter um kit de produtos específico para cada técnica — géis e loções de fixação para o lamination, pigmentos e agulhas de qualidade rastreável para a micropigmentação — e nunca misturar insumos entre os dois procedimentos, mesmo que pareçam compatíveis. A procedência do material influencia diretamente na durabilidade do resultado e na segurança da cliente, e é isso que sustenta a reputação do seu trabalho a longo prazo.'),

('volume-russo-classico-hibrido-cilios', 'Volume russo, clássico ou híbrido: guia completo para escolher a técnica de extensão de cílios', 'Cada técnica de extensão de cílios atende um perfil diferente de cliente. Veja as diferenças entre volume russo, clássico e híbrido, e como decidir qual oferecer.', 'Extensão de cílios é um dos serviços mais recorrentes em qualquer agenda de lash designer — e também um dos que mais gera dúvida na hora de fechar o orçamento com a cliente. As três técnicas mais procuradas hoje são o volume clássico, o volume russo e o híbrido, e cada uma exige uma abordagem técnica e comercial diferente.

O volume clássico aplica um fio de extensão para cada fio natural da cliente, respeitando o crescimento e a curvatura naturais. É a técnica mais indicada para quem já tem cílios naturais razoavelmente cheios e busca um efeito de alongamento discreto, próximo do natural — e também é o ponto de entrada mais comum para quem nunca fez extensão antes.

O volume russo, por outro lado, aplica um leque de fios finíssimos (geralmente entre 2 e 6 fios por leque) em cada cílio natural, criando um efeito de volume denso sem sobrecarregar o fio natural com peso excessivo. É a técnica certa para clientes com cílios naturais mais ralos que querem um efeito mais marcado, e também costuma ter um ticket médio mais alto, já que exige mais tempo de aplicação e mais habilidade técnica da profissional.

O híbrido combina as duas: mistura fios individuais (clássico) com leques (russo) ao longo da linha do cílio, criando textura e um efeito intermediário — nem tão discreto quanto o clássico, nem tão denso quanto o russo puro. É uma ótima porta de entrada para clientes que querem experimentar volume sem ir direto para o russo completo.

Do ponto de vista de negócio, vale ter as três técnicas na carteira de serviços, com preços escalonados de acordo com o tempo de cadeira e a complexidade de cada uma — e ser transparente com a cliente sobre qual técnica realmente atende à expectativa dela, em vez de empurrar sempre a mais cara. Uma cliente bem orientada na primeira sessão vira cliente recorrente; uma cliente insatisfeita com o resultado raramente volta, mesmo que a técnica aplicada tenha sido tecnicamente perfeita.

Um ponto que faz diferença direta no resultado, independente da técnica escolhida: a qualidade da cola. Colas de baixa procedência perdem fixação mais rápido, o que reduz a durabilidade do trabalho e força retoques antecipados — prejudicando tanto a percepção de qualidade quanto a rentabilidade do serviço.'),

('fibra-vidro-acrigel-porcelana-unhas', 'Fibra de vidro, acrigel ou porcelana: como escolher o melhor método de alongamento de unhas', 'Não existe técnica "melhor" — existe a técnica certa para cada unha e cada cliente. Compare fibra de vidro, acrigel e porcelana e amplie seu leque de serviços.', 'Alongamento de unhas é um serviço com alta demanda e também alta variedade técnica — e escolher entre fibra de vidro, acrigel (poligel) e porcelana (acrílico) é uma das decisões mais importantes que uma manicure especializada precisa tomar, tanto para a cliente individual quanto para o portfólio de serviços do salão.

A fibra de vidro é a técnica mais leve das três. Utiliza uma manta de fibra impregnada com resina, curada em cabine UV ou LED, criando uma extensão fina, flexível e resistente. É a indicação ideal para clientes com unhas naturais fracas ou quebradiças, que precisam de reforço sem peso excessivo, e também é a técnica que gera menos dano à unha natural durante a remoção, quando bem executada.

O acrigel, também chamado de poligel, é um material híbrido entre o gel e o acrílico: tem a maleabilidade do gel na aplicação e a resistência estrutural do acrílico depois de curado. É uma técnica versátil, indicada tanto para alongamentos moderados quanto para esculturas mais elaboradas, e costuma ter um cheiro bem mais ameno que o acrílico tradicional — um diferencial real para clientes sensíveis a odor forte no salão.

Já a porcelana, ou acrílico tradicional, é a técnica mais resistente e duradoura das três, ideal para alongamentos mais extensos e formatos mais estruturados, como coffin ou stiletto. Exige mais técnica de aplicação e um manuseio mais cuidadoso do pó e do líquido, mas entrega uma durabilidade superior entre manutenções — o que pode significar um ciclo de retorno mais espaçado para a cliente, mas também uma percepção de valor mais alta por sessão.

Não existe hierarquia entre as três — existe adequação. Unha natural fraca pede fibra de vidro. Cliente que quer versatilidade e conforto no dia a dia tende a preferir acrigel. Quem busca um alongamento estruturado e de longa duração se beneficia da porcelana. Ter as três técnicas disponíveis, com uma conversa honesta sobre o estado da unha natural da cliente antes de indicar qualquer uma delas, é o que constrói uma reputação de trabalho técnico e não só estético — e é essa reputação que traz indicação boca a boca, o canal mais forte de aquisição de cliente nesse mercado.'),

('lash-lifting-x-extensao-cilios', 'Lash lifting x extensão de cílios: qual técnica escolher para cada cliente', 'Duas técnicas para cílios com efeito e manutenção bem diferentes — entenda quando indicar lash lifting e quando indicar extensão.', 'Nem toda cliente que busca cílios mais marcantes quer, ou pode, fazer extensão. O lash lifting é uma alternativa cada vez mais procurada, e saber diferenciar as duas técnicas — e principalmente saber quando indicar cada uma — é o que evita frustração da cliente e retrabalho no salão.

O lash lifting trabalha só com os cílios naturais: um curling estrutural que curva os fios desde a raiz, criando um efeito de "cílios com máscara" sem aplicar nenhuma extensão. O resultado dura entre seis e oito semanas, acompanhando o ciclo natural de crescimento do cílio, e não exige manutenção quinzenal como a extensão. É a escolha certa para clientes que têm cílios naturais compridos mas retos ou caídos, e que querem um efeito de abertura do olhar sem o compromisso de retorno frequente ao salão.

A extensão de cílios, por outro lado, adiciona fios sintéticos aos cílios naturais — seja em volume clássico, russo ou híbrido — criando comprimento, volume e curvatura que o cílio natural não tem. É a técnica certa para clientes com cílios naturais curtos ou ralos, que buscam um efeito mais dramático e estão dispostas a fazer manutenção a cada duas ou três semanas.

Um erro comum é oferecer extensão pra toda cliente, sem avaliar se o cílio natural dela realmente precisa de fio extra ou se só precisa de uma curvatura melhor. Cliente com cílio comprido e saudável que só queria "abrir o olhar" muitas vezes sai mais satisfeita com um lash lifting bem feito — e volta com menos frequência, o que não é ruim: ela associa o salão a um resultado que dura, não a um ciclo caro de manutenção.

Do ponto de vista técnico, os produtos usados também são bem diferentes: o lifting depende de um kit de solução de curvatura e fixação compatível com a curvatura escolhida, enquanto a extensão depende de cola de fixação rápida e fios na espessura certa pra não sobrecarregar o cílio natural. Ter as duas técnicas na carteira de serviços — com os produtos certos para cada uma — amplia o público atendido sem forçar a mesma solução pra todo mundo.'),

('henna-sobrancelhas-tecnica-durabilidade', 'Henna para sobrancelhas: técnica, durabilidade e como indicar para cada tipo de fio', 'Um clássico que voltou com tudo — entenda como a henna se diferencia de outras técnicas de sobrancelha e para qual perfil de cliente ela funciona melhor.', 'A henna para sobrancelhas nunca saiu de moda de verdade, mas voltou com força nos últimos anos como uma alternativa mais acessível e menos invasiva que a micropigmentação — e é uma técnica que toda profissional de sobrancelha deveria dominar, mesmo que já ofereça outras opções.

Diferente da tintura tradicional, que só pigmenta os fios, a henna pigmenta tanto os fios quanto a pele por baixo deles, criando um efeito de preenchimento que disfarça falhas e dá a impressão de uma sobrancelha mais cheia — sem agulha, sem sangramento e sem tempo de cicatrização. O resultado na pele dura entre uma e duas semanas, e nos fios entre quatro e seis semanas, o que torna a henna uma ótima porta de entrada pra clientes que querem testar um formato mais preenchido antes de decidir por uma técnica de longo prazo, como a micropigmentação.

A indicação ideal é para clientes com falhas leves a moderadas, fios claros que precisam de mais definição, ou quem simplesmente quer experimentar um formato novo sem compromisso — já que, ao contrário da micropigmentação, o resultado da henna esmaece naturalmente e não exige remoção a laser se a cliente não gostar do resultado.

Um cuidado técnico importante é a escolha do produto: henna de baixa qualidade pigmenta de forma irregular, esmaece rápido e pode até manchar de forma esverdeada em vez do castanho esperado, dependendo da reação com a pele da cliente. Fazer um teste de mancha antes da primeira aplicação, sempre com produto de procedência confiável, evita retrabalho e reclamação.

Para quem já atende com fio a fio ou laminação, vale oferecer a henna como uma camada extra de serviço — muitas clientes combinam laminação com henna na mesma sessão, já que uma reforça o alinhamento dos fios e a outra reforça a cor e o preenchimento, entregando um resultado mais completo do que qualquer uma das duas técnicas sozinha.')
ON DUPLICATE KEY UPDATE titulo = VALUES(titulo);

INSERT INTO configuracoes (chave, valor) VALUES
  ('endereco', 'C 12 AE 2, Loja 30 – Taguatinga Centro, DF, 72010901'),
  ('horario', 'Seg a Sex, 09h00 às 18h00'),
  ('whatsapp', '5561996498557'),
  ('instagram', 'https://www.instagram.com/relpps'),
  ('nota_google', '5.0'),
  ('link_google', 'https://maps.app.goo.gl/MjM2hpovka9ozjCc7'),
  ('embed_maps', '')
ON DUPLICATE KEY UPDATE valor = VALUES(valor);

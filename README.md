#  Liga dos Pereba — Documentação Técnica do Sistema

---

## 1. Introdução

### 1.1 Escopo do Sistema
O **Liga dos Pereba** é uma aplicação web desenvolvida para catalogar, organizar e divulgar a história de grandes esquadrões e times marcantes do futebol mundial. A plataforma permite a consulta pública de acervos, a busca por equipes, o cadastro de novos times por usuários autenticados e a administração/moderação de conteúdo por usuários com perfil elevado.

O sistema possui autenticação de usuários baseada em sessões HTTP e controle de autorização em dois níveis: usuários comuns (com privilégio de publicação) e administradores (com privilégios exclusivos de edição e exclusão de registros).

### 1.2 Propósito
O propósito do projeto é oferecer aos torcedores e entusiastas do futebol uma interface fluida, moderna e responsiva inspirada no padrão visual da **UEFA Champions League** (modo noturno, cores ciano/dourado e tipografia Montserrat). Além disso, serve como artefato prático de desenvolvimento web utilizando PHP estruturado, banco de dados MySQL e CSS3 sem dependência de frameworks externos.

---

## 2. Como Executar o Projeto Localmente

### 2.1 Pré-requisitos
* Servidor web local com suporte a PHP 8.x e MySQL (ex: XAMPP, WAMP, Laragon ou PHP Built-in Server).
* Navegador web moderno.
* Cliente de banco de dados (phpMyAdmin ou terminal MySQL).

### 2.2 Passo 1: Obter o Projeto e Estrutura de Pastas
Clone o repositório oficial ou extraia os arquivos dentro da raiz do seu servidor web 

```bash
git clone https://github.com/Timas1150/projeto_integrador.git liga_pereba
cd liga_pereba
```

### 2.3 Passo 2: Configuração do Banco de Dados MySQL
Acesse o **phpMyAdmin** (`http://localhost/phpmyadmin`) ou o terminal do MySQL e execute o script para criar o banco de dados e as tabelas:

```sql
CREATE DATABASE IF NOT EXISTS liga_pereba;
USE liga_pereba;

-- Tabela de Usuários
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    perfil VARCHAR(20) NOT NULL DEFAULT 'user'
);

-- Tabela de Times
CREATE TABLE IF NOT EXISTS times (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    ano INT NOT NULL,
    historia TEXT NOT NULL,
    usuario_id INT,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE SET NULL
);
```

### 2.4 Passo 3: Configurar a Conexão PHP
Abra o arquivo `includes/conexao.php` e ajuste os parâmetros de conexão de acordo com o seu ambiente local:

```php
<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'liga_pereba';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}
?>
```

### 2.5 Passo 4: Executar a Aplicação
No seu navegador, acesse a URL correspondente à pasta do projeto:  
`http://localhost/liga_pereba/index.php` (ou através do servidor embutido do PHP com `php -S localhost:8000`).

### 2.6 Passo 5: Promover uma Conta a Administrador
Por padrão, todo cadastro público pelo formulário web registra a conta como usuário comum (`perfil = 'user'`). Para conceder permissão administrativa e testar os botões de edição e exclusão de times, execute a seguinte instrução SQL no banco de dados:

```sql
UPDATE usuarios SET perfil = 'admin' WHERE email = 'seuemail@exemplo.com';
```

---

## 3. Descrição Global

### 3.1 Público-alvo
* **Fãs de Futebol e Torcedores:** Pessoas que desejam pesquisar e ler sobre momentos e elencos históricos.
* **Usuários Cadastrados:** Torcedores e colaboradores que desejam registrar a história de seus times favoritos.
* **Administradores:** Gestores responsáveis por moderar o acervo, corrigir informações e excluir registros indevidos.

### 3.2 Perfis de Acesso

| Perfil | Responsabilidade e Acesso |
| :--- | :--- |
| **Visitante** | Acessar a Home (`index.php`), consultar o acervo de times, visualizar histórias e acessar as telas de login e cadastro. |
| **Usuário Cadastrado** | Acessar a conta (`perfil = 'user'`), cadastrar novos times no acervo (`app/create.php`) e realizar pesquisas por nome/conteúdo. |
| **Administrador** | Todas as atribuições do usuário cadastrado (`perfil = 'admin'`), com permissão exclusiva de edição (`app/update.php`) e exclusão de times (`app/delete.php`). |

### 3.3 Principais Telas

| Tela | Finalidade |
| :--- | :--- |
| **Início / Home (`index.php`)** | Página principal com cabeçalho institucional, navegação e apresentação do sistema. |
| **Times (`app/select.php`)** | Listagem geral de todos os times cadastrados no sistema com suporte à busca dinâmica. |
| **Cadastrar Time (`app/create.php`)** | Formulário de inclusão de novos times (exclusivo para usuários autenticados). |
| **Editar Time (`app/update.php`)** | Alteração dos dados cadastrais de um time (exclusivo para Administradores). |
| **Login (`login/login.php`)** | Interface de autenticação de usuários cadastrados. |
| **Cadastro (`login/cadastrar.php`)** | Interface para criação de novas contas de usuário. |

---

## 4. Requisitos do Sistema

### 4.1 Requisitos Funcionais (RF)

| ID | Requisito | Descrição | Prioridade |
| :--- | :--- | :--- | :--- |
| **RF01** | Cadastro de usuários | Permitir a criação de contas com nome, e-mail e senha. | Alta |
| **RF02** | Login | Validar credenciais de acesso e iniciar a sessão do usuário. | Alta |
| **RF03** | Logout | Encerrar com segurança a sessão ativa do usuário. | Alta |
| **RF04** | Cadastro de times | Permitir que usuários autenticados cadastrem novos times (nome, ano e história). | Alta |
| **RF05** | Consultar acervo | Exibir a listagem dos times cadastrados com estilo e formatação organizada. | Alta |
| **RF06** | Pesquisa | Permitir filtrar e localizar times por palavra-chave ou nome na tela de consulta. | Alta |
| **RF07** | Identificação do perfil | Diferenciar e controlar os acessos no sistema com base no campo `perfil`. | Alta |
| **RF08** | Edição de times | Permitir que usuários administradores alterem informações de times existentes. | Alta |
| **RF09** | Exclusão de times | Restringir a remoção de registros do acervo exclusivamente ao perfil administrador. | Alta |

### 4.2 Requisitos Não Funcionais (RNF)

| ID | Requisito | Descrição | Prioridade |
| :--- | :--- | :--- | :--- |
| **RNF01** | Tecnologias | Construir o sistema utilizando PHP, MySQL, HTML5 e CSS3 nativo. | Alta |
| **RNF02** | Identidade visual | Adotar tema escuro inspirado na UEFA Champions League, utilizando variáveis CSS e a fonte Montserrat. | Média |
| **RNF03** | Usabilidade | Prover menus centralizados, botões estilo pílula e navegação fluida em todas as telas. | Alta |
| **RNF04** | Controle de acesso | Validar a sessão HTTP e as permissões de usuário no servidor para operações restritas. | Alta |
| **RNF05** | Integridade dos dados | Manter a consistência e os relacionamentos de chave estrangeira entre usuários e times. | Alta |
| **RNF06** | Compatibilidade | Assegurar a renderização responsiva nos principais navegadores modernos. | Média |

### 4.3 Regras de Negócio (RN)

| ID | Regra de Negócio |
| :--- | :--- |
| **RN01** | O usuário precisa estar obrigatoriamente autenticado para cadastrar um time. |
| **RN02** | Qualquer usuário autenticado (comum ou administrador) pode submeter um novo time. |
| **RN03** | Apenas contas com `perfil = 'admin'` possuem permissão para alterar ou remover times do acervo. |
| **RN04** | As permissões de acesso e exclusão devem ser validadas no lado do servidor, prevenindo burlas por URL direta. |
| **RN05** | O formulário de cadastro de usuários deve atribuir por padrão `perfil = 'user'`. |
| **RN06** | A exclusão de um time é permanente e o registro deixa de aparecer imediatamente nas consultas e buscas. |

---

## 5. Organização dos Dados

A persistência do sistema utiliza o modelo relacional em MySQL.

### 5.1 Dicionário de Dados

#### Tabela: `usuarios`
Armazena as contas cadastradas e seus níveis de acesso.

| Campo | Tipo | Nulo | Restrições | Finalidade |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `INT` | **Não** | `AUTO_INCREMENT PRIMARY KEY` | Identificador único do usuário. |
| `nome` | `VARCHAR(100)` | **Não** | — | Nome completo ou de exibição. |
| `email` | `VARCHAR(100)` | **Não** | `UNIQUE` | E-mail do usuário utilizado no login. |
| `senha` | `VARCHAR(255)` | **Não** | — | Hash de senha do usuário. |
| `perfil` | `VARCHAR(20)` | **Não** | `DEFAULT 'user'` | Perfil de acesso (`'admin'` ou `'user'`). |

#### Tabela: `times`
Armazena as equipes futebolísticas e seus conteúdos históricos.

| Campo | Tipo | Nulo | Restrições | Finalidade |
| :--- | :--- | :--- | :--- | :--- |
| `id` | `INT` | **Não** | `AUTO_INCREMENT PRIMARY KEY` | Identificador único do time. |
| `nome` | `VARCHAR(100)` | **Não** | — | Nome da equipe (ex: "AC Milan", "Bayern"). |
| `ano` | `INT` | **Não** | — | Ano ou temporada marcante do elenco. |
| `historia` | `TEXT` | **Não** | — | Relato detalhado sobre o time e títulos. |
| `usuario_id` | `INT` | **Sim** | `FK -> usuarios(id)` | Identificador do usuário que realizou o cadastro. |

### 5.2 Relacionamentos
* **`usuarios` $\rightarrow$ `times` (1 : N):** Um usuário pode cadastrar um ou múltiplos ($N$) times no sistema. O campo `usuario_id` armazena a referência para o criador do registro.

---

## 6. Diagramas e Fluxos

### 6.1 Diagrama Entidade-Relacionamento (DER)

```mermaid
erDiagram
    USUARIOS {
        INT id PK
        VARCHAR_100 nome
        VARCHAR_100 email
        VARCHAR_255 senha
        VARCHAR_20 perfil
    }

    TIMES {
        INT id PK
        VARCHAR_100 nome
        INT ano
        TEXT historia
        INT usuario_id FK
    }

    USUARIOS ||--o{ TIMES : "cadastra"
```

---

### 6.2 Mapa de Funcionalidades por Perfil

```text
[ Visitante ]
 ├── Visualizar Home (Página Inicial)
 ├── Consultar Acervo de Times e Histórias
 ├── Acessar Tela de Login
 └── Acessar Tela de Cadastro de Usuário

[ Usuário Cadastrado (perfil = 'user') ]
 ├── (Todas as permissões de Visitante)
 ├── Autenticar no Sistema (Login / Logout)
 ├── Cadastrar Novo Time Histórico
 └── Pesquisar Times por Título ou Conteúdo

[ Administrador (perfil = 'admin') ]
 ├── (Todas as permissões de Usuário Cadastrado)
 ├── Editar Registros de Times (app/update.php)
 └── Excluir Times do Acervo (app/delete.php)
```

---

## 7. Roteiro de Verificação Manual

| Cenário | Ação Executada | Resultado Esperado |
| :--- | :--- | :--- |
| **01. Login Válido** | Digitar e-mail e senha de uma conta existente. | Acesso concedido, sessão iniciada e exibição da saudação no menu. |
| **02. Login Inválido** | Inserir e-mail não registrado ou senha incorreta. | Recusa do acesso e mensagem de erro exibida. |
| **03. Logout** | Clicar no botão do perfil para encerrar a sessão. | Destruição da sessão e bloqueio de páginas privadas. |
| **04. Cadastro de Time** | Preencher o formulário de cadastro com nome, ano e história. | Time salvo no banco e exibido no acervo geral (`app/select.php`). |
| **05. Pesquisa de Times** | Digitar um termo no campo de busca (ex: "Bayern"). | Filtro aplicado com sucesso exibindo apenas os resultados correspondentes. |
| **06. Bloqueio de Edição (User)**| Tentar acessar a rota de edição logado como usuário comum. | Acesso bloqueado pelo servidor com negação de permissão. |
| **07. Exclusão de Time (Admin)**| Clicar no botão "Deletar" utilizando uma conta administrador. | Time removido permanentemente da base de dados e do acervo. |

---

## 8. Prototipagem

O planejamento visual e a estrutura das telas foram desenvolvidos em um protótipo de baixa fidelidade interativo.

* **Link de Acesso ao Protótipo no Excalidraw:**  
  [Acessar Prototipação no Excalidraw](https://excalidraw.com/#room=26d39aa295942ffb0187,iOLix3GvB7HOCSHm4Bb7Dg)

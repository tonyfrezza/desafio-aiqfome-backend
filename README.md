# API de Produtos Favoritos - Desafio Aiqfome

Este projeto implementa uma API RESTful para gerenciamento de clientes e seus produtos favoritos, conforme o desafio técnico do Aiqfome. A API permite criar, consultar, atualizar e remover clientes, além de gerenciar a lista de produtos favoritos de cada cliente com validação de produtos via API externa.

---

## 🚀 Tecnologias Utilizadas

- **Docker**: Orquestração de containers e isolamento do ambiente.
- **PHP 8.3**: Linguagem principal do backend.
- **Laravel Framework 10**: Framework para desenvolvimento da API, estruturação e validação.
- **PostgreSQL**: Banco de dados relacional para persistência dos dados.
- **Redis**: Gerenciamento de sessões com Laravel.
- **Swagger**: Geração de documentação e testes de API.

## ⚙️ Configurações e Otimizações

### Configurações Padrão dos Containers
- IP fixo atribuído para cada container.
- Exposição da porta `8080` para o container PHP Laravel.
- Banco de dados PostgreSQL criado automaticamente:
    - **Nome**: `aiqfome`
    - **Usuário**: `aiqfome`
    - **Senha**: `Pg102030@`
- Redis configurado com senha padrão: `Redis2019!`

### Alterações de Configuração
As configurações podem ser ajustadas no arquivo `docker-compose.yml`:
- Porta do container Laravel: `ports` do container `aiqfome-laravel`.
- Usuário e senha do PostgreSQL: `POSTGRES_USER` e `POSTGRES_PASSWORD`.
- Nome do banco de dados: `POSTGRES_DB`.
- Configurações de rede.

---

## 🛠️ Execução da Aplicação

### 1. Clonando o Repositório e Acessando o Projeto
```bash
git clone https://github.com/tonyfrezza/desafio-aiqfome-backend.git
cd desafio-aiqfome-backend
```

### 2. Inicializando os Containers Docker
Acesse a pasta `docker` do projeto e execute:
```bash
cd docker
docker compose up -d
```
(podem ser requeridas permissões de super usuário, dependendo da instalação do seu docker) 

Isso iniciará os containers:
- **aiqfome-laravel**: Aplicação Laravel.
- **aiqfome-postgres**: Banco de dados PostgreSQL.
- **aiqfome-redis**: Redis.

### 3. Configurando o Ambiente Laravel
No diretório raiz do projeto, copie o arquivo `.env.example` para `.env`:
```bash
cd ..
cp .env.example .env
```

Para facilitar a execução e validação deste projeto, usuário e senha de acesso ao banco de dados, bem como senha de acesso ao Redis, já estão definidos na criação do container ‘aiqfome-postgres’ e do container ‘aiqfome-redis’. 

Desta forma, você pode utilizá-los na configuração do projeto.

Ainda assim, por questões de padrão e segurança, você deve preencher estas informações no novo arquivo .env.

Edite o arquivo `.env` com as seguintes variáveis:
```env
DB_PASSWORD=Pg102030@
REDIS_PASSWORD=Redis2019!
```

### 4. Inicializando a Aplicação Laravel
Acesse o terminal do container Laravel:
```bash
docker exec -it aiqfome-laravel bash
```

(podem ser requeridas permissões de super usuário, dependendo da instalação do seu docker) 

Dentro do terminal do container ‘aiqfome-laravel’ - atente-se para estar no terminal correto, sem erros na execução do comando anterior - execute os comandos::
```bash
composer install
php artisan key:generate
php artisan migrate
php artisan db:seed
```

Após esses passos, a API estará disponível.

---

## 👤 Credenciais de Teste
Um super usuário será criado automaticamente:
- **Nome**: Master Admin
- **E-mail/Login**: master@aiqfome.com
- **Senha**: Master123!

---

## 🔒 Regras e Permissões

- **Login**: Bloqueio de 60 segundos após 5 tentativas inválidas.
- **Super Usuário**: Permissão para gerenciar contas de outros usuários.
- **Usuários Comuns**: Gerenciam apenas seus próprios produtos favoritos.
- **Autenticação**: Requer login com usuário (email) e senha para obter o token de autenticação.

---

## 📖 Documentação da API

A documentação interativa gerada com Swagger está disponível em:
[http://localhost:8080/api/documentation](http://localhost:8080/api/documentation)

> Caso tenha alterado a porta padrão, substitua `8080` pela nova porta configurada.

Na interface do Swagger, é possível:
- Visualizar endpoints disponíveis.
- Consultar parâmetros de entrada e exemplos de requisição/resposta.
- Testar os endpoints diretamente.


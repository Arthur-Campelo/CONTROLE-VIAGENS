# Controle de Viagens

Sistema de CRUD para controle de viagens (veículos, motoristas e viagens), desenvolvido como projeto de avaliação técnica.

## Tecnologias utilizadas

| Tecnologia | Papel no projeto |
|---|---|
| **PHP 8.1+** | Linguagem da aplicação |
| **CodeIgniter 4** | Framework web (MVC, roteamento, ORM básico, migrations) |
| **CodeIgniter Shield** | Autenticação (login obrigatório, sessão) |
| **PostgreSQL 14** | Banco de dados |
| **Docker / Docker Compose** | Ambiente do banco de dados |
| **Tailwind CSS 3** | Estilização da interface |
| **Composer** | Gerenciador de dependências PHP |
| **npm** | Gerenciador de dependências para o build do CSS |

## Funcionalidades

- **CRUD de Veículos** — modelo, ano, data de aquisição, KM na aquisição, Renavam (único) e placa (única)
- **CRUD de Motoristas** — nome, data de nascimento (idade mínima de 18 anos validada) e número da CNH
- **CRUD de Viagens** — vínculo N:N com motoristas e N:1 com veículo, KM inicial/final (final ≥ inicial), data/hora inicial e de chegada (chegada ≥ início)
- **Login obrigatório** para acessar qualquer tela do sistema, via CodeIgniter Shield

## Decisões de escopo

- Aplicação **monólito**, com as telas renderizadas pelo próprio CodeIgniter (sem front-end separado)
- Uma viagem só é criada **já finalizada** — todos os campos são preenchidos de uma vez, não existe estado "em andamento"

## Requisitos para rodar

- PHP 8.1+ com as extensões: `pdo_pgsql`, `pgsql`, `mbstring`, `intl`, `curl`
- [Composer](https://getcomposer.org)
- [Docker](https://www.docker.com/products/docker-desktop/) e Docker Compose
- [Node.js](https://nodejs.org) e npm (só para gerar o CSS)

> **Observação:** só o banco de dados está containerizado neste projeto — a aplicação PHP em si roda localmente (via `php spark serve`), não dentro de um container Docker. Não cheguei a montar a containerização completa da aplicação dentro do prazo; ficou como uma melhoria que gostaria de voltar a fazer com mais tempo. O `docker-compose.yml` fornecido cuida só do Postgres, e os passos abaixo cobrem exatamente como rodar o restante.

## Como rodar

1. Clone o repositório e entre na pasta do projeto.

2. Suba o banco de dados:
   ```bash
   docker compose up -d
   ```

3. Instale as dependências PHP:
   ```bash
   composer install
   ```

4. Configure o `.env`:
   ```bash
   cp env .env
   ```
   E ajuste:
   ```ini
   CI_ENVIRONMENT = development

   database.default.hostname = 127.0.0.1
   database.default.database = entrevista
   database.default.username = postgres
   database.default.password = postgres
   database.default.DBDriver = Postgre
   database.default.port = 5432
   ```

5. Rode as migrations (cria as tabelas do domínio e do Shield):
   ```bash
   php spark migrate --all
   ```

6. Crie um usuário para conseguir logar:
   ```bash
   php spark shield:user create
   ```

7. Instale as dependências do front-end e gere o CSS:
   ```bash
   npm install
   npx tailwindcss -i resources/css/input.css -o public/css/tailwind.css
   ```

8. Suba a aplicação:
   ```bash
   php spark serve
   ```

9. Acesse `http://localhost:8080` e faça login com o usuário criado no passo 6.

## Estrutura relevante

```
app/Controllers/     Controllers das 3 entidades (Vehicle, Driver, Trip)
app/Models/           Models com validação e regras de negócio
app/Views/            Telas (layout + vehicles/drivers/trips)
app/Database/Migrations/   Schema do banco (domínio + Shield)
resources/css/         Código-fonte do Tailwind
tailwind.config.js     Configuração do Tailwind (cores, caminhos escaneados)
docker-compose.yml      Ambiente do Postgres
```

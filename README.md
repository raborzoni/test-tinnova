# Documentação - Sistema de Veículos - Tinnova

Dependências Utilizadas:
- Laravel 10 - https://laravel.com/docs/10.x
- PHPUnit - https://laravel.com/docs/12.x/testing

## Instalação do projeto e dependências
Primeiramente, você deve clonar o repositório no seu ambiente local usando o comando:
- `$ git clone https://github.com/raborzoni/test-tinnova.git`
- `$ cd test-tinnova`

Após o clone, instale as dependências do projeto com o comando:
- `$ composer install`

Copie o arquivo .env.example para .env com o comando:
- `$ cp .env.example .env`

Gere uma nova key do Laravel para o seu projeto:
- `$ php artisan key:generate`

## Configuração do Banco de Dados
### Crie um Banco de Dados MySQL.
No arquivo .env, preencha os dados do Banco criado:
- `DB_CONNECTION=mysql`
- `DB_HOST=127.0.0.1`
- `DB_PORT=3306`
- `DB_DATABASE=nome_do_banco`
- `DB_USERNAME=root`
- `DB_PASSWORD=sua_senha`

Execute o comando para migrar as tabelas do projeto e os seeders criados de exemplo:
- `$ php artisan migrate`
- `$ php artisan db:seed --class=VeiculoSeeder`

## Startar o Sistema
Apois todas as configurações acima, inicie o sistema com o comando:
- `$ php artisan serve`

## Rotas
### Veículos
- `GET /veiculos` - Listar todos os veículos
- `GET /veiculos?marca={marca}&ano={ano}&cor={cor}` - Listar com Filtros
- `GET /veiculos/{id}` - Exibe detalhes do veículo
- `POST /veiculos` - Cadastrar um novo veículo
- `PUT /veiculos/{id}` - Atualiza todas as informações do veículo
- `PATCH /veiculo/{id}` - Atualiza apenas um dado específico do cadastro, no caso, se foi vendido ou não.
- `DELETE /veiculo/{id}` - Exclui o veículo

### Estatísticas
- `GET /veiculos/estatisticas/decadas` - Lista a estatística de carros por décadas
- `GET /veiculos/estatisticas/fabricantes` - Lista a estatística de carros por fabricantes
- `GET /veiculos/ultima-semana` - Exibe os veículos registrados na ultima semana
- `GET /veiculos/marcas-validas` - Exibe a lista de marcas válidas no sistema

## Geração de documentos:
O sistema gera documentos das estatísticas em .CSV, PDF ou JSON.

## Testes Automatizados
O sistema obtém testes automatizados nativos do Laravel. Para executar os testes, acesse o terminal e execute o comando:
- `$ php artisan test`

Serão testados os métodos criados.

### Observação: 
Após os testes serem executados, é necessário que refaça os comandos Migrate.

Para limpar os testes do banco e subir novamente o migrate e os seeders:
- `$ php artisan migrate:refresh –seed`

Logo depois, o banco ficará preenchido novamente.

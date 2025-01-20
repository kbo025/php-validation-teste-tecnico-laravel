# Teste Dev: Gabriel Camacho

## Descrição

Esse projeto é o resultado do teste para vaga de Developer. Foi usada como tecnologias principais PHP (Laravel) postgreSQL, nodejs e vuejs.

### Foi entregue no prazo:

- Registro de clientes (validado unicidade do usuario e recaptcha v3).
- Excluir clientes (Incluindo deleção em masa).
- Listar clientes + filtros + paginação.
- Ativar / desativar clientes.
- Login / Logout (os clientes desativados não podem logar)

### Foi entregado fora do prazo:
- Readme com instruções para rodar o projeto.
- Configuração para container Docker criado com Laravel sail.

### Não foi entregado:
- Formulario para criar / editar clientes (logica criada com bug no frontend)

## Requerimentos

- PHP >= 7.4
- Composer
- Node.js
- Docker
- Docker Compose

## Instalação

1. Clonar repositorio:
    ```sh
    git clone https://github.com/kbo025/php-validation-teste-tecnico-laravel/tree/Gabriel-Camacho
    cd your-project
    ```

2. Copiar o arquivo .env.example em .env
    ```sh
    cp .env.example .env
    ```

3. Atualice o .env como for necesario
    ```ini
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=database_name
    DB_USERNAME=username
    DB_PASSWORD=password
    ```

4. Instalar dependencias de php:
    ```sh
    composer install
    ```

5. Inicialize o Laravel Sail
    ```sh
    ./vendor/bin/sail up
    ```

6. Criar as chaves do projeto
    ```sh
    ./vendor/bin/sail artisan key:generate
    ```

8. Rodar as migrações de laravel para construção do banco de dados
    ```sh
    ./vendor/bin/sail artisan migrate
    ```

9. Rodar as seeds de laravel para popular a tabela de usarios com 10 clientes/usuarios
    ```sh
    ./vendor/bin/sail artisan db:seed
    ```

10. Instalar as dependencias de node para executar o frontend
    ```sh
    ./vendor/bin/sail npm install && ./vendor/bin/sail npm run dev
    ```

11. Entrar no site na url: localhost:8000, credenciais para login:
    - user: test@example.com
    - pass: 123456


## Comandos Úteis

### Parar os containers:
    ```sh
    ./vendor/bin/sail down
    ```

### Reconstrução de containers:
    ```sh
    ./vendor/bin/sail down
    docker-compose rm -f
    ./vendor/bin/sail build
    ./vendor/bin/sail up -d
    ```


## Autor

- [@kbo025](https://github.com/kbo025)


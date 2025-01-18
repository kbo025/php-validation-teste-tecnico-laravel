# Project

## Requirements

- PHP >= 7.4
- Composer
- Node.js
- Docker (optional)

## Installation

1. Clone the repository:
    ```sh
    git clone https://github.com/your-username/your-project.git
    cd your-project
    ```

2. Install PHP dependencies:
    ```sh
    composer install
    ```

3. Install Node.js dependencies:
    ```sh
    npm install
    ```

4. Copy the environment file and configure it:
    ```sh
    cp .env.example .env
    ```

5. Generate the application key:
    ```sh
    php artisan key:generate
    ```

## Configuration

Make sure to configure the following parameters in your [.env](http://_vscodecontentref_/1) file:

- Database:
    ```ini
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=database_name
    DB_USERNAME=username
    DB_PASSWORD=password
    ```

- Redis:
    ```ini
    REDIS_CLIENT=phpredis
    REDIS_HOST=127.0.0.1
    REDIS_PASSWORD=null
    REDIS_PORT=6379
    ```

- PHP Configuration (file [local.ini](http://_vscodecontentref_/2)):
    ```ini
    memory_limit = 512M
    upload_max_filesize = 100M
    post_max_size = 100M
    max_execution_time = 300
    ```

## Running the Project

1. Compile the assets:
    ```sh
    npm run dev
    ```

2. Start the development server:
    ```sh
    php artisan serve
    ```

3. Access the application in your browser:
    ```
    http://localhost:8000
    ```

# Pastelaria Setup Docker Laravel 10 com PHP 8.1

### Passos
Clone Repositório
```sh
git clone https://github.com/tiagobatista7/teste-pastelaria.git
```
Crie o Arquivo .env
```sh
cp .env.example .env
```

Atualize as variáveis de ambiente do arquivo .env
```dosini
APP_NAME=Pastelaria
APP_URL=http://localhost:8989

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=root

CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis

REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379
```

Suba os containers do projeto
```sh
docker-compose up -d
```

Acesse o container app
```sh
docker-compose exec app bash
```

Instale as dependências do projeto
```sh
composer install
```

Gere a key do projeto Laravel
```sh
php artisan key:generate
```

Instale o Pest PHP para testes
```sh
composer remove phpunit/phpunit
composer require pestphp/pest --dev --with-all-dependencies
./vendor/bin/pest --init
./vendor/bin/pest
```

Instale plugins Pest para o Laravel
```sh
composer require pestphp/pest-plugin-laravel --dev
```


Instale as migrações e popule as tabelas
```sh
php artisan migrate:refresh --seed
```

Tabelas e migrações de filas para envio de emails
```sh
php artisan queue:table
php artisan migrate
```

Processar as filas
```sh
php artisan queue:work --tries=3
php artisan schedule:work
```

Acesse o projeto e confira a retorno se está "ok"
[http://localhost:89](http://localhost:89)


Para efetuar todos os testes, no terminal digite o comando:
```sh
php artisan test
```


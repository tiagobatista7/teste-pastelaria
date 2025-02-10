
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
DB_DATABASE=nome_que_desejar_db
DB_USERNAME=nome_usuario
DB_PASSWORD=senha_aqui

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

Acesse o projeto
[http://localhost:89](http://localhost:89)

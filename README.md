## Личный кабинет

Installation:

- docker-compose build
- docker-compose up -d
- sudo chmod -R 777 ./storage/
- docker exec -it test_app bash
- composer install
- php artisan key:generate
- php artisan migrate
- php artisan storage:link

the site will be available at http://localhost:8876/

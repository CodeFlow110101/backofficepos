1) Rename .env.example to .env 
2) Setup DB credentials in the .env
3) Run the following Commands (Note: php version 8.2 required)
    a) composer update
    b) php artisan key:generate
    d) php artisan migrate
    e) php artisan optimize:clear
4) Installation complete
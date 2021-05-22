## Projeto Clube do Livro

* Instruções de Instalação: *

Depois de colar o projeto pelo github, fazer as seguintes açãos na linha de comando:
cd (Pasta do Projeto)
composer install
npm intall
php artisan migrate

Agora configure o baco de dados no arquivo .env:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_nome
DB_USERNAME=root
DB_PASSWORD=

Dois disso se deve abrir dois terminais para rodar a API do Laravel e as páginas do Vue:
php artisan serve
npm run hot

:)
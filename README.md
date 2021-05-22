## Projeto Clube do Livro

* Instruções de Instalação:  <br/>

* Depois de colar o projeto pelo github, fazer as seguintes açãos na linha de comando: <br/>
cd (Pasta do Projeto) <br/>
composer install <br/>
npm intall <br/>
php artisan migrate <br/>

* Agora configure o baco de dados no arquivo .env: <br/>
DB_CONNECTION=mysql <br/>
DB_HOST=127.0.0.1 <br/>
DB_PORT=3306 <br/>
DB_DATABASE=db_nome <br/>
DB_USERNAME=root <br/>
DB_PASSWORD= <br/>

* Dois disso se deve abrir dois terminais para rodar a API do Laravel e as páginas do Vue:  <br/>
php artisan serve <br/>
npm run hot <br/>

:)

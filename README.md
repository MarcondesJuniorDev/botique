# Botique

Este projeto é desenvolvido com [Laravel 12](https://laravel.com/) e utiliza o [FilamentPHP](https://filamentphp.com/) como stack principal para construção de interfaces administrativas. O banco de dados utilizado é o **MySQL**.

## Requisitos

- PHP >= 8.2
- Composer
- MySQL
- Node.js e NPM (para assets)

## Instalação

```bash
git clone https://github.com/seu-usuario/botique.git
cd botique
composer install
cp .env.example .env
php artisan key:generate
# Configure o banco de dados no arquivo .env
php artisan migrate
npm install && npm run build
php artisan serve
```

## Recursos

- Painel administrativo com FilamentPHP
- Gerenciamento de dados com MySQL
- Estrutura robusta do Laravel 12

## Licença

Este projeto está sob a licença MIT.
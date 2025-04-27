# 📚 Documentación de API - Proyecto Laravel 11

## Introducción
Esta API está construida con **Laravel 11** y sigue prácticas modernas de desarrollo, incluyendo autenticación basada en tokens, validación estricta de datos y respuestas estandarizadas en formato JSON.

## Requisitos
- PHP >= 8.2
- Composer
- Laravel 11
- Base de datos MySQL/PostgreSQL

## Instalación
```bash
git clone https://github.com/tuusuario/tu-proyecto-api.git
cd tu-proyecto-api
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve

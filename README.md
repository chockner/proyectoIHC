<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Requisitos

XAMPP v3.3.0

## INSTALACION

    ### 1. Conar el repositorio

    ```bash
    git clone https://github.com/chockner/proyectoIHC.git
    cd proyectoIHC
    ```

    ### 2. Instalar dependencias de PHP

    ```bash
    composer install
    ```

    ### 3. Copiar archivo de entorno y generar la clave de la aplicación

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

    ### 4. Configurar el archivo `.env`

    Edita el archivo `.env` con los datos de tu base de datos:

    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=ihcproyectofinal
    DB_USERNAME=root
    DB_PASSWORD=
    ```

    ### 5. Ejecutar migraciones y seeders 

    ```bash
    php artisan migrate
    php artisan db:seed --class=DatabaseSeeder
    ```

    ### 6. Levantar el servidor local

    ```bash
    php artisan serve
    ```


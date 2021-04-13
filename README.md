## Pre-Installation
- clone this repo
- cp .env.example .env // and setup accordingly
- create database according to .env setting 
## Installation
- composer install
- php artisan key:generate
- php artisan migrate --seed
- npm install && npm run dev
- php artisan serve
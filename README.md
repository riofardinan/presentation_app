## Web Based Presentation App

Aplikasi web untuk membuat tutorial tugas menggunakan laravel 12 dan tailwind

## 🔧 Requirement

-   PHP >= 8.1
-   Composer
-   MySQL
-   Node.js & NPM
-   Laravel 12

## Cara Setup Project

Ikuti langkah-langkah berikut untuk menjalankan project ini di lokal:

### 1. Clone Repository

```bash
git clone https://github.com/riofardinan/presentation_app.git
cd presentation_app
```

### 2. Install Dependency

```bash
composer install
npm install && npm run dev
```

### 3. Salin File .env

```bash
cp .env.example .env
```

### 4. Generate App Key

```bash
php artisan key:generate
```

### 5. Jalankan Migrasi

```bash
php artisan migrate
```

### 6. Jalankan Server Lokal

```bash
php artisan serve
```

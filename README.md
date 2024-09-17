<p align="center"><a href="[YOUR_LOGO_URL]" target="_blank"><img src="[YOUR_LOGO_URL]" width="400" alt="[Project Name]"></a></p>

<p align="center">
<a href="[BUILD_STATUS_LINK]"><img src="[BUILD_BADGE_URL]" alt="Build Status"></a>
<a href="[PACKAGE_DOWNLOADS_LINK]"><img src="[DOWNLOADS_BADGE_URL]" alt="Total Downloads"></a>
<a href="[CURRENT_VERSION_LINK]"><img src="[VERSION_BADGE_URL]" alt="Latest Stable Version"></a>
<a href="[LICENSE_LINK]"><img src="[LICENSE_BADGE_URL]" alt="License"></a>
</p>

## About [RegisterCalls]

[RegisterCalls] is an application designed for [Management and accounting of telephone assistance]. This project aims to [facilitate the management of companies that offer telephone assistance and need to account for the time spent for subsequent invoicing].

The main features include:

- [Feature 1]
- [Feature 2]
- [Feature 3]
- [Feature 4]

The project is built using [names of the main technologies and frameworks].

## System Requirements

- **PHP**: >= [8.3.9]
- **Laravel**: ^[11]
- **MySQL/PostgreSQL/SQLite/etc.**: >= [Database Version]
- **Composer**: >= [Composer Version]
- **Node.js**: >= [Node.js Version]
- Others: [Detail additional libraries, services, or tools required].

## Installation

### Clone the repository

```bash
git clone https://github.com/[user]/[repository-name].git
```

### Install Node.js dependencies:
```bash
npm install
```
### Configure the .env file:
Copy the .env.example file to .env and set up the environment variables:
```bash
cp .env.example .env
```

Make sure to set up the database credentials:
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nombre_base_de_datos
DB_USERNAME=usuario
DB_PASSWORD=contraseña
```

## Generate the application key:
```bash
php artisan key:generate
```

## Migrate and seed the database:
```bash
php artisan migrate --seed
```

## Start the development server:
```bash
php artisan serve
```
Access the application at: http://localhost:8000

## Compile front-end assets

### For development environment:
```bash
npm run dev
```

### For production:
```bash
npm run build
```

## Main Routes

| Route                      | Method | Description                        |
|----------------------------|--------|------------------------------------|
| `/dashboard`               | GET    | Project's main page                |
| `/users/create`            | GET    | Create a new user                  |
| `/calls/create`            | GET    | Create a new call                  |
| `/change-view-preference`  | POST   | Change view preference             |


## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.



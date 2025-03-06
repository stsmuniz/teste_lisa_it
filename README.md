# Project Name

Laravel project running with Docker, including Nginx, PHP-FPM, and MySQL.

## Prerequisites

-   Docker
-   Docker Compose
-   Git

## Project Setup

1. Clone the repository

```bash
git clone <repository-url>
cd <project-directory>
```

```bash
cp .env.example .env
```

```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=laravel_user
DB_PASSWORD=your_password
```

```bash
docker-compose up -d --build
```

```bash
docker-compose exec php composer install
```

```bash
docker-compose exec php php artisan key:generate
```

```bash
docker-compose exec php php artisan migrate
```

```bash
docker-compose exec php chmod -R 777 storage bootstrap/cache
```

Start containers
`docker-compose up -d`
Stop containers
`docker-compose down`
View container logs
`docker-compose logs`
View specific container logs
`docker-compose logs {container_name}`
Access PHP container shell
`docker-compose exec php bash`
Access MySQL container shell
`docker-compose exec mysql bash`
Run migrations
`docker-compose exec php php artisan migrate`
Clear cache
`docker-compose exec php php artisan cache:clear`
Clear config
`docker-compose exec php php artisan config:clear`
Create a new controller
`docker-compose exec php php artisan make:controller ControllerName`

```bash
docker-compose exec php chmod -R 777 storage bootstrap/cache
```

```bash
docker-compose ps
```

```bash
docker-compose down
docker-compose up -d
```

├── docker
│ ├── mysql
│ ├── nginx
│ └── php
├── src
│ └── (Laravel application files)
├── .env
├── docker-compose.yml
└── README.md

This README provides:

-   Clear setup instructions
-   Environment configuration details
-   Common commands
-   Troubleshooting steps
-   Project structure
-   Container information

Feel free to customize it further based on your specific project needs!

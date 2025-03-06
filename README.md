# D-Influencer test project

Laravel project running with Docker, including Nginx, PHP-FPM, and MySQL. For D-Influencer job application.

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

2. Copy the `.env.example` file to `.env` and configure the environment variables

```bash
cp .env.example .env
```

3. Configure the environment variables

```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=laravel_user
DB_PASSWORD=your_password
```

4. Start the containers

```bash
docker-compose up -d --build
```

5. Install the dependencies

```bash
docker-compose exec php composer install
```

6. Generate the application key

```bash
docker-compose exec php php artisan key:generate
```

7. Run the migrations

```bash
docker-compose exec php php artisan migrate
```

8. Clear the cache

```bash
docker-compose exec php php artisan cache:clear
```

9. Clear the config

```bash
docker-compose exec php php artisan config:clear
```

10. Set the permissions for the storage and bootstrap/cache directories

```bash
docker-compose exec php chmod -R 777 storage bootstrap/cache
```

## Common Commands

View container logs

```bash
docker-compose logs
```

View specific container logs

```bash
docker-compose logs {container_name}
```

Access PHP container shell

```bash
docker-compose exec php bash
```

Access MySQL container shell

```bash
docker-compose exec mysql bash
```

Run migrations

```bash
docker-compose exec php php artisan migrate
```

Clear cache

```bash
docker-compose exec php php artisan cache:clear
```

Clear config

```bash
docker-compose exec php php artisan config:clear
```

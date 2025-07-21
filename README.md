# Laravel + Vue Project Setup

---

## 🔽 Clone and Launch the Project

```bash
git clone https://github.com/RomanZborovskiy/Laravel-Vue.git
cd Laravel-Vue

cp .env.example .env

docker-compose up -d --build

# Set correct permissions for the storage directory (for logs, cache, etc.)
sudo chown -R $USER:www-data storage
sudo chmod -R 775 storage

#  Install PHP Dependencies
docker compose exec php-fpm bash

composer install

php artisan key:generate
php artisan migrate
php artisan db:seed

exit

# Install Frontend Dependencies (Vue.js)
docker compose exec node sh

npm install

# Build for production:
npm run build

# Or for local development:
# npm run dev

🌐 Access
Laravel: http://localhost:8080

Vite (if using dev mode): http://localhost:5173
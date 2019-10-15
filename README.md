# Install dependencies
composer install

# Edit the env file and add DB params

# Create entitys
php bin/console doctrine:migrations:diff
# Run migrations
php bin/console doctrine:migrations:migrate

# Simple Laravel API Integration
# Setup Database
Open up the .env file, replace the values shown below with your database configuration.
```bash
DB_HOST=your database host
DB_DATABASE=your database name
DB_USERNAME=your database username
DB_PASSWORD=your database user password

```

# Basic setup
Install dependencies
```bash
 Composer install
```
# Run Migrations
```bash
 php artisan migrate
```
# Seed Data
```bash
 php artisan adverts:poll
```
# Generate Encryption key
```bash
 php artisan key:gen
```
# Start Application

```bash
 php artisan serve
```
# Run unit test
```bash
 vendor/bin/phpunit
```

# Run on Docker
Navigate to the directory on your terminal and run the command below

```bash
 docker-compose up -d or docker compose up -d
``` 
# Author
Anyaso Franklin <br />
franko172000@gmail.com




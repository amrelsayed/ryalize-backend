# About

Ryalize Backend Api's 

## Project Setup

### Install dependencies

```sh
composer install
```

### Create .env file

```sh
cp .env.example .env
```

### Add application key

```sh
php artisan key:generate
```

### Add DB Connection
After creating MySQL database

Update database credentials in .env file to use your setup credentials

```sh
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=my_sql_user_name
DB_PASSWORD=my_sql_password
```
### Run migrations and seed data

```sh
php artisan migrate --seed
```

### Run the Application with Dev Server

```sh
php artisan serve
```

### For Production

`public/index.php` is the entry point of the application

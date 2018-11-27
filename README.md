# blog
## Small blog app

- Laravel framework
- MySql for user auth
- MongoDB for posts

Create database and user
```
CREATE DATABASE blog DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
CREATE USER 'blog'@'localhost' IDENTIFIED WITH mysql_native_password BY 'secret';
GRANT ALL PRIVILEGES ON blog.* TO 'blog'@'localhost';
FLUSH PRIVILEGES;
```

Clone project
```
git clone https://github.com/petingo0/blog.git

composer install
```
Config .env with parameters of mysql database and mongodb database

Excecute to create database tables:
```
php artisan migrate
```



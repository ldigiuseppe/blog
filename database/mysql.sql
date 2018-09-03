ALTER USER 'blog'@'localhost' IDENTIFIED WITH mysql_native_password BY 'secret';
CREATE DATABASE blog;
GRANT ALL PRIVILEGES ON blog.* TO 'blog'@'localhost';
FLUSH PRIVILEGES;
CREATE DATABASE blog DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
CREATE USER 'blog'@'localhost' IDENTIFIED WITH mysql_native_password BY 'secret';
GRANT ALL PRIVILEGES ON blog.* TO 'blog'@'localhost';
FLUSH PRIVILEGES;

INSERT INTO blog.users (name, email, password)
values ('admin', 'admin@admin.com', '$2y$10$0Aox7Vyl9AgJ6iNtXOMIXuAtHxSo.eI7xbPayYV9ofK3fPd9MfJGO');


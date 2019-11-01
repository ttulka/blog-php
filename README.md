# Blog in PHP
Source code for http://blog.ttulka.com

## Docker Infrastructure

### Build Images
```
docker build -t ttulka/php:5.6.35-apache-rewrite src
docker build -t ttulka/blog-mysql db
```

### Run Images
```
docker run --rm -p 33060:3306 -e MYSQL_ROOT_PASSWORD=secret --name blog-mysql ttulka/blog-mysql

docker run -p 9090:80 --name my-apache-php -v $(pwd)/src:/var/www/html:ro ttulka/php:5.6.35-apache-rewrite-pdo-mysql
# under Windows:
docker run -p 9090:80 --name my-apache-php -v c:/Projects/test/src:/var/www/html:ro ttulka/php:5.6.35-apache-rewrite
```
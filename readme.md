# Setup instructions:
Requirements: **php 8** and **composer**


install packages:
```
composer install
```
create a sqlite database named 'db.sqlite':
```
touch db.sqlite
```

create a `.env` file that contains secret key for generating JWT tokens

```shell
JWT_SECRET=secret
```

generate database tables with this command:
```shell
php bin/doctrine orm:schema-tool:create
```
create a new user running this command: 
```shell
php bin/create-user   
```
after user is created start php server with this command:
```shell
php -S localhost:8080
```

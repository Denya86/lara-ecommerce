<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

##First copy and rename the .env envioroment file for our app:
`cp .env.example .env`

And finally we can run the container

`docker-compose up -d`

##For migrating data, we first must create an user for the database. 
So we first we access to the database this way:

`docker-compose exec db bash`

And then we can access to the mysql client

`mysql -u root -p`

The console will prompt asking for the password (MYSQL_ROOT_PASSWORD param on docker-compose.yml)

Now we should be able to see the database by typing:

`mysql> show databases;`

And create the user by typing the following commands:

`mysql> GRANT ALL ON laravel_docker.* TO 'admin'@'%' IDENTIFIED BY 'somesecretkey';
mysql> FLUSH PRIVILEGES;
mysql> EXIT;`

Now we can perform the migrations;

`docker-compose exec app php artisan migrate`
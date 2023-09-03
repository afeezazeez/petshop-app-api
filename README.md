
# Pet Shop API
> An ecommerce app api
## Description
This project was built with Laravel and MYSQL 


## Running the App
To run the App, you must have:
- **PHP** (https://www.php.net/downloads)
- **MySQL** (https://www.mysql.com/downloads/)
- **Docker** (https://www.docker.com/products/docker-desktop/)
- **Phpunit**

Clone the repository to your local machine using the command
```console
$ git clone *remote repository url*
```


### Environment
`.env` is generated automatically


### Booting app

```
./setup.sh start
```


### Stopping  app

```
./setup.sh stop
```

### Running larastan

```
./larastan.sh
```

### Running larastan

```
./php-insights.sh
```



You should be able to visit your app at your laravel app base url e.g http://localhost:8000
### Testing
To test, you can login with the default seeded admin credential
```
Email - admin@buckhill.co.uk
Password - admin
```

For users, default password is 'userpassword'. Feel free to grab any user from user listing endpoint and make use of default password to login

### PHPUNIT
To run general test, use command
```console
$ ./tests.sh
```


### SWAGGER API DOCUMENTATION
The documentation for the API can be found- http://localhost:8000/api/documentation

## LEVEL 3 CHALLENGE -  Price Calculator

This is located in package/afeezazeez/converter. Instructions can be found in its README.md

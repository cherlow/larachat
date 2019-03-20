# Project Title

A Laravel real time chat app using vue and laravel websockets

## Getting Started
Have composer and node installed
```
https://getcomposer.org/download/
```
```
https://nodejs.org/en/download/
```


clone the project from git hub

```
git clone https://github.com/cherlow/larachat.git
```
Then navigate to the directory

```
cd larachat
```
Run composer install and npm 

```
composer install
```
```
npm install
```
Edit the env file and set your database credentials
```
DB_DATABASE=YOUR_DB_NAME
DB_USERNAME=YOUR_DB_USERNAME
DB_PASSWORD=YOUR_DB_PASSWORD
```
Run the migrations
```
php artisan migrate
```
Run laravel development server and laravel websocket server
```
php artisan serve
```
```
php artisan websocket:serve
```

Create two user account and test the functionalities

## For Development
For development make sure to run 
```
npm run watch
```




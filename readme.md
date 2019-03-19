# Project Title

A Laravel real time chat app using vue and laravel websockets

## Getting Started
clone the project from git hub

```
git clone https://github.com/cherlow/larachat.git
```
Then navigate to to the directory

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
Run laravel development serve and laravel websoket server
```
php artisan serve
```
```
php artisan websocket:serve
```

Create two user account and test the functionalities

## Getting Started
For development make sure to run 
```
npm run watch
```




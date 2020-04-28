# Virtual Learning Platform (VLP)
## An application built on Laravel 7.* and Vue.js to allow learners to study online.
### Setup Instructions
1.  Clone the repository and cd into the directory
2.  Run ```composer install```
3.  Run ``` npm install ```
4.  Copy the .env.example to .env
5.  Run ```php artisan key:generate```
6.  Set the following database connection parameters in the .env file according to your server config 
    - DB_HOST
    - DB_PORT
    - DB_USERNAME
    - DB_PASSWORD
    - DB_DATABASE
7.  Run ```php artisan migrate --seed``` to migrate the database tables and load test data
8.  Run ```php artisan serve --port {PORT_NUMBER}```
9.  Open the app in ```http://localhost:{PORT_NUMBER}```
10. Use admin as both username and password
11. Run ```npm run watch``` to let webpack watch you Vue files for changes and automatically compiles the app
12. Run ```npm run prod``` for production ready front-end


### HAPPY CODING


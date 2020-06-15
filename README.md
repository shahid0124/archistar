#Migration Seeder CSV files 
   All laravel migration seeders csvs are located in storage/app/seeder
   
#Creating Migrations and running seeds 
    Please run the following command to create migrations and run seeds
        php artisan migrate:fresh --seed

 
#Running Unit test for a single file
    For quick testing one file `./vendor/bin/phpunit -c phpunit.xml --debug ./tests/Unit/Http/Api/PropertyControllerTest`
   For Running one test method `./vendor/bin/phpunit -c phpunit.xml --debug ./tests/Unit/Http/Api/PropertyControllerTest --filter testExample`

#UUID Generation 
For Uuid generation i have used two packages
    dyrynda/laravel-model-uuid 
        To install it -- composer require dyrynda/laravel-model-uuid
    dyrynda/laravel-efficient-uuid 
        To install it -- composer require dyrynda/laravel-efficient-uuid

We can also use laravel uuid but that will create a string field in the table and usually thats slow. However drynda efficent uuid creates a binary 
field which uses model to convert it to string and vice versa.

To run the migrations successfully please install these two packages
    


# Install Project locally

# Step 1

Install PHP and MySQL for Ubuntu. Verify your PHP version. Check and verify your MySQL version.
Install Composer globally. Install and configure Git. Download and install Postman.

# Step 2

Required packages for Phalcon Extension and Phalcon IDE helper have been added.

```
composer require ext-phalcon
composer require phalcon/ide-stubs
```

Required setting in order to enforce latest PHP version to date, into our project.

```
composer require php >= 7.4
```

Run the command `composer install` in the project directory, where the file `composer.json` is located, in order to create the `vendor` folder with project dependencies.

# Step 3

A new composer script has been added for running the built-in webserver.

```
"scripts": {
 "web": "@php -S localhost:8001"
}
```

Run the webserver by calling `composer run web`.

# Step 4

Copy the file `.env.example` to the same folder and remove the `.example` extension on the copied file.
Complete the information in the newly created `.env` config file with you local configuration.
Go on and create the database in MySQL, then run all the migrations up with the composer script from below.

```
composer run migrations up
```

# Step 5

Open Postman app and start making requests after you've started your webserver with `composer run web`.
Take a look at the `RouteProvider` class for making requests. This class includes all the routes, but it's not documented.
For more comprehensive information on how to make requests, please check the `docs` folder and import the `phalcon-blog-api.postman_collection.json` file into your Postman app.
The `phalcon-blog-api.open-api3.json` file was imported in the Swagger website, so please also check the online API documentation on the following [link](https://app.swaggerhub.com/apis-docs/alinmigea/phalcon-blog_api/1.0).

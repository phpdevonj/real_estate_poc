# Laravel Project Setup Guide

This document outlines the steps to set up and run the project on your local machine. 

## Prerequisites

Before you begin, ensure you have the following installed:

- PHP (8.2 or higher)
- Composer
- Node.js (latest version)
- npm (latest version)
- MySQL or MariaDB
- Laravel CLI
- A code editor like Visual Studio Code

## Installation Steps

### Step 1: Clone the Repository
Clone the project repository to your local machine:

git clone <repository-url>
cd <project-folder>

### Step 2: Create a copy of the .env file

cp .env.example .env
    Edit the .env file to configure your database connection and other settings:
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=<your-database-name>
    DB_USERNAME=<your-database-username>
    DB_PASSWORD=<your-database-password>

### Step 3: Install Dependencies

composer install

### Step 4: Install Node Modules

npm install

### Step 5: Generate an application key

php artisan key:generate

### Step 6: Create and Configure the Database

Log in to phpMyAdmin or your database management tool.
Create a new database matching the name in the .env file (DB_DATABASE).

### Step 7: Run Migrations and Seeders

php artisan migrate

php artisan db:seed

### Step 8:  Build Frontend Assets

npm run dev

### step 9: Allowed storage to link images

php artisan storage:link

### Step 10: Start the Development Server

    php artisan serve

    Watch and compile frontend changes:
    
    npm run dev

### Optional: Running Tests

    php artisan test

Notes
This project uses Laravel 11, Vue.js 3, Inertia.js, and the latest npm.
Ensure your local environment meets the version requirements for PHP, Laravel, and Node.js.
Refer to the Laravel Documentation for additional help.

Common Issues
Missing Dependencies: Run composer install and npm install again to ensure all dependencies are installed.
Migration Issues: Ensure the database is correctly configured in the .env file before running php artisan migrate.

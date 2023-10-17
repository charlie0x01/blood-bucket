# Blood Bucket

Welcome to the Blood Bucket, a platform designed to facilitate blood donation and save lives. This Readme provides essential information for users.

## Features

- **User Registration**: Users can create accounts, complete profiles, and manage their donation or blood-receiving history.

- **Search and Donation Matching**: Find blood matches with donors based on blood type and location.

- **Educational Resources**: Access information on the importance of blood donation and health benefits.

## Installation

To run this system locally, follow these steps:

1. Clone the repository: `git clone https://github.com/charlie0x01/blood-bucket.git`

2. Find the `.env.example` file in the root of the project and rename this file to `.env`
   
3. Navigate into your project in the terminal and run `composer install` to install dependencies.

4. Install dependencies: `npm install`

5. You must create your database on your server and on your `.env` file to update the following lines.

`DB_CONNECTION=mysql`
`DB_HOST=127.0.0.1`
`DB_PORT=3306`
`DB_DATABASE=homestead`
`DB_USERNAME=homestead`
`DB_PASSWORD=secret`

7. Artisan Commands
The first thing we are going to do is set the key that Laravel will use when doing encryption.

`php artisan key:generate`

8. run `php artisan migrate` to create database tables

9. run `php artisan db:seed` to fill the database with demo credentials

10. run `npm run dev`

11. Storage:link
After your project is installed you must run this command to link your public storage folder for user avatar uploads:

`php artisan storage:link`

11. run `php artisan serve` to run the project.

### Demo Credentials

**Admin:** admin@admin.com  
**Password:** secret

**User:** user@user.com  
**Password:** secret

### License

MIT: [http://anthony.mit-license.org](http://anthony.mit-license.org)

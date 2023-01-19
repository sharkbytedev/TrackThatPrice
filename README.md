# Track That Price
Track That Price (TTP) is a web service that allows users to track the prices of products on different online stores, and recieve email notifications about significant price changes. It also allows users to view the price history of a product, as well as compare identical products on different online stores.

### Uses:
- PHP 8
- Laravel
- Node.js (For [Puppeteer](https://github.com/puppeteer/puppeteer))
- MySQL

## Installing/Running
### Requirements:
- PHP 8 or higher
- Composer
- Node.js 18 and npm
- MySQL database (Or some other SQL database supported by Laravel. However, TTP was built with MySQL, so others may not work)

### Installing
1. Clone the repository with `git clone https://github.com/sharkbytedev/TrackThatPrice.git` and cd into the project directory.

2. Install dependencies
   `$ npm install`
   `$ composer install`

3. Rename `.env.example` to `.env` (Or make a copy), and fill in the following fields with the appropriate values for your setup
   `DB_CONNECTION=mysql`
   `DB_HOST=127.0.0.1`
   `DB_PORT=3306`
   `DB_DATABASE=laravel`
   `DB_USERNAME=root`
   `DB_PASSWORD=`

4. Generate an app key using `php artisan key:generate`

5. Run database migrations. 
   `$ php artisan migrate`
   `$ php artisan migrate --seed # Optionally, add --seed to fill the database with auto-generated users and products`

6. Run `start.bat` to run the app. By default, it is hosted at `http://localhost:8000`

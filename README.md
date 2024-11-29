
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>


---

# Laravel API Setup Guide

## Prerequisites
Ensure you have the following installed on your system:
- PHP >= 8.3
- Composer
- Laravel CLI
- MySQL or your preferred database
- Git
- Node.js and npm (if front-end or asset compilation is required)

---

## Steps to Clone and Run the Project

1. **Clone the Repository**  
   Use Git to clone the repository:

   ```bash
   git clone https://github.com/isaac-hash/Bill-payment-api.git
   ```

2. **Navigate to the Project Directory**  
   ```bash
   cd <repository-name>
   ```

3. **Install Dependencies**  
   Use Composer to install PHP dependencies:

   ```bash
   composer install
   ```

4. **Set Up Environment File**  
   Create a copy of the `.env.example` file as `.env`:

   ```bash
   cp .env.example .env
   ```

   Open the `.env` file and update the following:
   - **Database settings**:
     ```env
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=laravel_api
     DB_USERNAME=homestead
     DB_PASSWORD=secret
     ```
   - **Test environment settings** .
   Open the `.env.testing` file and update the following:
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=testing_database
   DB_USERNAME=homestead
   DB_PASSWORD=secret

5. **Generate Application Key**  
   ```bash
   php artisan key:generate
   ```

6. **Run Database Migrations**  
   Apply the migrations to create tables in the database:

   ```bash
   php artisan migrate
   ```

7. **Seed the Database (Optional)**  
   If your project includes seeders, run:

   ```bash
   php artisan db:seed
   ```

8. **Run the Application**  
   Start the development server:

   ```bash
   php artisan serve
   ```

   The application will be accessible at `http://localhost:8000`.

9. **Run Tests**  

   ```bash
   php artisan test
   ```
---

## Laravel Passport Setup (For Authentication)

10. **Install Laravel Passport**  
   Ensure Passport is installed by running the following command:

   ```bash
   composer require laravel/passport
   ```

11. **Run Passport Migrations**  
   Migrate the tables required by Passport:

   ```bash
   php artisan migrate
   ```

12. **Install Passport**  
   Run the Passport installation command to generate encryption keys:

   ```bash
   php artisan passport:install
   ```




## Notes
- Ensure your `.env` file is not included in the repository for security purposes.
- If you're using Laravel Passport, Sanctum, or other authentication libraries, provide specific setup instructions for them.

---

This will give others a clear and structured way to clone and run your Laravel API project. Let me know if you'd like additional sections added!


## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
=======
# Bill-payment-api
1fe9e4e32692a28a17f2567bba3eb282da7905ce

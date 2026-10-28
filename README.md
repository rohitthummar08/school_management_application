# Laravel Project – Setup Instructions

## Requirements

Make sure the following are installed on your system:

- PHP 8.4
- Laravel 13+
- Composer
- A supported database (MySQL, PostgreSQL, or SQLite, depending on your configuration)
- I used MySQL as database.

## Installation and Setup

### 1. Clone the Repository

```bash
git clone https://github.com/rohitthummar08/school_management_application.git
cd school_management_application
```

### 2. Configure the Environment

Copy the example environment file to create your local `.env` file.

```bash
cp .env.example .env
```

Update the `.env` file with your local configuration if required.

### 3. Install Dependencies

Install the PHP dependencies using Composer.

```bash
composer install
```

### 4. Generate the Application Key

```bash
php artisan key:generate
```

### 5. Run Database Migrations and Seeders

```bash
php artisan migrate --seed
```

This command runs the database migrations and seeders. The application is configured to create the required database tables and populate the initial static data, including the admin data.

**Note:** Ensure that the database exists and the database credentials in `.env` are configured correctly before running migrations, unless your project explicitly handles database creation automatically.

### 6. Start the Laravel Development Server

```bash
php artisan serve
```

The application will be available at:

`http://127.0.0.1:8000`

### 7. Start the Queue Worker

Open a separate terminal and run:

```bash
php artisan queue:work
```

Keep this process running to process queued jobs, including email-sending jobs.

## Email Configuration

By default, emails are logged to the application log file instead of being sent to actual email addresses.

You can find the logged email output in:

`storage/logs/laravel-[current_date].log`

To send real emails, update the mail configuration in your `.env` file with your SMTP provider's credentials.

For example:

```env
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-smtp-username
MAIL_PASSWORD=your-smtp-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="your-email@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

Replace the example values with your actual SMTP configuration. Never commit real credentials to the repository.

After updating the mail settings, restart the queue worker so that it picks up the new configuration.

## Notes

- The project uses **PHP 8.4** and **Laravel 13+**.
- Run `php artisan queue:work` in a separate terminal while testing queued email functionality.
- Ensure the `.env` file is configured correctly before running the application.
- The database migrations and seeders initialize the application's required tables and static admin data.

# laravel-large-csv-upload-websocket-interview-project

## Dependencies
- **PHP**: >= 8.1
- **Redis Server**: Make sure to have Redis Server installed and running.

## Getting Started

Follow these steps to get your project up and running.

### 1. Start Redis Server

Before proceeding, ensure that the Redis Server is installed and running on your system.


### 2. Copy Environment File

Make a copy of the `.env.example` file and save it as `.env`. You can do this manually or use the following command:

```bash
cp .env.example .env

```

### 3. Configure Mail Server for Functional Mail Notifications


### 4. Install PHP Dependencies

```bash
composer install

```

### 5. Install JavaScript Dependencies

```bash
npm install

```

### 6. Run Database Migrations

```bash
php artisan migrate

```

### 7. Start the Project

```bash
php artisan serve

```

To compile your assets (e.g., JavaScript and CSS), open a new terminal window and run:


```bash
npm run dev

```


### 8. Start Horizon

```bash
php artisan horizon

```


### 9. Start WebSockets Server

```bash
php artisan websockets:serve

```


Now, you are ready to go with your Laravel project!



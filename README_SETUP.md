# Nutrition Tracker - Setup Guide

A Laravel-based nutrition tracking application that helps users monitor their daily nutrition intake, manage recipes, and track biometric data.

## Table of Contents
- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Running the Project](#running-the-project)
- [Troubleshooting](#troubleshooting)

## Features

- User authentication and management
- Daily nutrition logging
- Recipe management with ingredients
- Biometric tracking (weight, measurements, etc.)
- Personalized nutrition goals
- Meal planning capabilities
- Real-time dashboard

## Requirements

### System Requirements
- **Operating System:** Windows 10+ (or Linux/macOS with similar setup)
- **Disk Space:** 2GB minimum

### Software Requirements

| Software | Version | Purpose |
|----------|---------|---------|
| PHP | 8.3+ | Backend framework |
| MySQL | 8.0+ | Database |
| Node.js | 18+ | Frontend tooling |
| npm | 8+ | Package manager |
| Composer | Latest | PHP dependency manager |



## Installation

### Step 1: Download & Navigate
```powershell
cd path/to/nutrition-tracker
```

### Step 2: Install PHP Dependencies
```powershell
composer install
```

### Step 3: Install Node Dependencies
```powershell
npm install
```

### Step 4: Configure Environment File
Copy the example environment file:
```powershell
Copy-Item .env.example .env
```

Edit `.env` with your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nutrition_tracker
DB_USERNAME=root
DB_PASSWORD=root
```

### Step 5: Generate Application Key
```powershell
php artisan key:generate
```

### Step 6: Run Database Migrations
```powershell
php artisan migrate
```

This will create all necessary database tables.

## Running the Project

### Prerequisites for Running
1. MySQL service must be running
2. PHP must be in your system PATH (or add it temporarily)
3. All dependencies installed (composer and npm)

### Add PHP to PATH (Windows)
```powershell
$env:PATH = "C:\php;" + $env:PATH
```

### Start Development Environment

**Option 1: Separate Terminals**

Terminal 1 - Start Laravel Server:
```powershell
cd c:\Users\retr0\Downloads\Project\nutrition-tracker
php artisan serve
```
Server will run on: `http://127.0.0.1:8000`

Terminal 2 - Start Vite Dev Server:
```powershell
cd c:\Users\retr0\Downloads\Project\nutrition-tracker
npm run dev
```
Vite will run on: `http://127.0.0.1:5173`

**Option 2: Using npm dev script (runs all processes)**
```powershell
npm run dev
```

### Access the Application
- Open browser and go to: `http://127.0.0.1:8000`

## Project Structure

```
nutrition-tracker/
├── app/
│   ├── Http/
│   │   └── Controllers/          # Request handlers
│   ├── Models/                   # Database models
│   │   ├── User.php
│   │   ├── DailyLog.php
│   │   ├── Recipe.php
│   │   ├── Ingredient.php
│   │   ├── UserGoal.php
│   │   └── Biometric.php
│   └── Providers/                # Service providers
├── database/
│   ├── migrations/               # Database schema files
│   ├── factories/                # Test data factories
│   └── seeders/                  # Database seeders
├── resources/
│   ├── css/                      # Stylesheets (Tailwind)
│   ├── js/                       # JavaScript files
│   └── views/                    # Blade templates
├── routes/
│   ├── web.php                   # Web routes
│   ├── auth.php                  # Authentication routes
│   └── console.php               # Console commands
├── config/                       # Configuration files
├── .env                          # Environment variables (DO NOT COMMIT)
├── .env.example                  # Example environment file
├── composer.json                 # PHP dependencies
├── package.json                  # Node dependencies
└── artisan                        # Laravel command runner
```

## Database Schema

### Main Tables
- **users** - User accounts and authentication
- **daily_logs** - Daily nutrition records
- **recipes** - Recipe definitions
- **ingredients** - Food ingredients database
- **recipe_ingredients** - Recipe composition
- **user_goals** - Personalized nutrition targets
- **biometrics** - Body measurements and metrics

## Troubleshooting

### Issue: "could not find driver (pdo_mysql)"
**Solution:**
1. Open `C:\php\php.ini`
2. Find `;extension=pdo_mysql` and uncomment it (remove `;`)
3. Restart PHP/Laravel server

### Issue: "Access denied for user 'root'@'localhost'"
**Solution:**
1. Verify MySQL is running: `tasklist | findstr mysql`
2. Check credentials in `.env` file
3. Ensure MySQL username/password is correct

### Issue: MySQL connection refused on port 3306
**Solution:**
1. Start MySQL service (if not running)
2. Verify port: `netstat -ano | findstr ":3306"`
3. Check `.env` port configuration

### Issue: "The database 'nutrition_tracker' does not exist"
**Solution:**
Run migrations (they will create the database):
```powershell
php artisan migrate
```

### Issue: Port 8000 already in use
**Solution:**
Use a different port:
```powershell
php artisan serve --port=8001
```

### Issue: npm scripts not found
**Solution:**
```powershell
npm install
```

## Development Commands

```powershell
# View available artisan commands
php artisan list

# Create a new model with migration
php artisan make:model ModelName -m

# Create a new controller
php artisan make:controller ControllerName

# Clear application cache
php artisan cache:clear

# Run tests
php artisan test

# Build frontend assets for production
npm run build

# Optimize application
php artisan optimize
```

## Environment Variables

Key environment variables in `.env`:

```env
APP_NAME=Laravel
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nutrition_tracker
DB_USERNAME=root
DB_PASSWORD=root

SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_STORE=database
```

## Technology Stack

- **Backend Framework:** Laravel 12
- **Frontend Framework:** Vite
- **CSS Framework:** Tailwind CSS
- **Database:** MySQL 8.0
- **Language:** PHP 8.3
- **Package Manager:** Composer, npm

## Support & Documentation

- [Laravel Docs](https://laravel.com/docs)
- [Vite Docs](https://vitejs.dev/)
- [Tailwind CSS Docs](https://tailwindcss.com/docs)
- [MySQL Docs](https://dev.mysql.com/doc/)

## Notes

- Keep `.env` file secure and do not commit to version control
- Always run migrations before first use
- Make sure both Laravel and Vite servers are running for full functionality
- Database will be created automatically during migration if it doesn't exist

---

**Last Updated:** December 1, 2025

# Makando - Food Ordering System

A dashboard-based Food Ordering System built with:

- Laravel
- AlpineJS 
- TailwindCSS 
Stripe (Payment Gateway)

This project covers key features for Customer, Restaurant Manager, and Administrator roles, complete with authentication, storage linking, and basic loyalty program functionality.

## Features

### Customer
- View available restaurants with category-based filtering (e.g., Asian, Western, Desserts).
- View detailed restaurant profiles including menus.
- Place orders with an option for Pickup or Delivery.
- Secure online payment integration via Stripe.
- Earn loyalty points (1 point per RM1 spent) for every order placed.

### Restaurant Manager
- View and manage incoming orders specific to their restaurants.
- Accept or Reject customer orders.
- View Sales Analytics:
    - Total sales (overall).
    - Today's sales.

### Administrator
- Approve newly registered restaurants.
- Ban or Disable restaurants as needed.
- (Optional) Dashboard analytics for system monitoring.

# System
- Authentication for all users.
- Role-based access control for Customer, Manager, and Admin.
- Storage linking for media (images, etc.).
- Vite for asset bundling (development and production).

## Project Structure

```
- app/
  - helpers.php
  - Http/
    - Controllers/
    - Middleware/
    - Requests/
  - Models/
    - ActivityLog.php
    - Cart.php
    - Category.php
    - CategoryRestaurant.php
    - Customer.php
    - Menu.php
    - MenuImage.php
    - Order.php
    - OrderItem.php
    - Permission.php
    - PermissionRole.php
    - RecordLog.php
    - Restaurant.php
    - Role.php
    - RoleUser.php
    - Type.php
    - User.php
  - Notifications/
    - UserCreated.php
    - UserPasswordUpdated.php
  - Observers/
    - PermissionRoleObserver.php
    - RoleObserver.php
    - RoleUserObserver.php
    - UserObserver.php
  - Providers/
    - AppServiceProvider.php
    - PermissionServiceProvider.php
  - View/
    - Components/
- bootstrap/
  - app.php
  - providers.php
- config/
  - app.php
  - auth.php
  - cache.php
  - cashier.php
  - constant.php
  - database.php
  - filesystems.php
  - logging.php
  - mail.php
  - queue.php
  - sanctum.php
  - services.php
  - session.php
- database/
  - database.sqlite
  - factories/
    - UserFactory.php
  - migrations/
    - ...
  - seeders/
    - ...
- public/
  - storage/
  - android-chrome-192x192.png
  - android-chrome-512x512.png
  - apple-touch-icon.png
  - favicon-16x16.png
  - favicon-32x32.png
  - favicon.ico
  - hot
  - index.php
  - robots.txt
  - site.webmanifest
  - build/
    - ...
  - img/
- resources/
  - css/
  - js/
  - views/
- routes/
  - api.php
  - auth.php
  - console.php
  - web.php
- storage/
  - app/
  - framework/
  - logs/
- tests/
  - TestCase.php
  - Feature/
  - Unit/
- vendor/
  - ...
- artisan
- CHANGELOG.md
- composer.json
- composer.lock
- LICENSE
- package.json
- phpunit.xml
- postcss.config.js
- README.md
- tailwind.config.js
- vite.config.js
```

## Installation

Clone this repository to get started.

Execute the following commands in project directory to install dependencies:

```bash
npm install
composer install
```

Execute the following commands in project directory to create .env and set application key.

```
cp .env.example .env
php artisan key:generate
```

Execute the following command in project directory for database migration.

```
php artisan migrate --seed
```

Create storage link (This is required to properly serve uploaded images and files)

```
php artisan storage:link
```

Execute the following commands in project directory to run Valet development server.

```
valet run
valet link
```

Alternatively, you can use for standard local development:

```
php artisan serve
```

This project utilize Vite for source code bundling. To run, execute one of the following commands:

```bash
npm run dev
npm run build
npm run preview
```

Note that `npm run build` command must be executed when running development server.

## Payment Gateway Setup

This project uses Stripe for payment transactions.

You must set your Stripe API keys in .env:

```
STRIPE_KEY=your_stripe_public_key
STRIPE_SECRET=your_stripe_secret_key
```

Test cards available via Stripe for testing purposes.

## Assumptions and Architecture Decisions

- Separation by Role: Customer, Manager, and Admin have distinct permissions and dashboard views.
- Order Flow: Customers can order from any restaurant, managers only manage their own restaurants.
- Payment: Stripe is chosen for its ease of integration and testability.
- Loyalty Program: Simple 1 point = RM1 system, designed to be extendable for future reward schemes.
- Tech Choices:
    - Laravel for scalable, secure backend.
    - AlpineJS to keep frontend lightweight and reactive without heavy SPA frameworks.
    - TailwindCSS for rapid, consistent UI styling.

## Additional Notes

- This system supports pickup and delivery order types.
- Restaurants require approval before becoming visible to customers.
- Admin panel includes restaurant approval and ban features.
- Loyalty points are accumulated automatically upon successful order payment.
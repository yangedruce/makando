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
- Role-based access control for Customer, Restaurant Manager, and Admin.
- Storage linking for media (images, etc.).
- Vite for asset bundling (development and production).

## Project Structure

Below is the clickable project structure for easy navigation:

- [app/](app/)
  - [helpers.php](app/helpers.php)
  - [Http/](app/Http/)
    - [Controllers/](app/Http/Controllers/)
    - [Middleware/](app/Http/Middleware/)
    - [Requests/](app/Http/Requests/)
  - [Models/](app/Models/)
    - [ActivityLog.php](app/Models/ActivityLog.php)
    - [Cart.php](app/Models/Cart.php)
    - [Category.php](app/Models/Category.php)
    - [CategoryRestaurant.php](app/Models/CategoryRestaurant.php)
    - [Customer.php](app/Models/Customer.php)
    - [Menu.php](app/Models/Menu.php)
    - [MenuImage.php](app/Models/MenuImage.php)
    - [Order.php](app/Models/Order.php)
    - [OrderItem.php](app/Models/OrderItem.php)
    - [Permission.php](app/Models/Permission.php)
    - [PermissionRole.php](app/Models/PermissionRole.php)
    - [RecordLog.php](app/Models/RecordLog.php)
    - [Restaurant.php](app/Models/Restaurant.php)
    - [Role.php](app/Models/Role.php)
    - [RoleUser.php](app/Models/RoleUser.php)
    - [Type.php](app/Models/Type.php)
    - [User.php](app/Models/User.php)
  - [Notifications/](app/Notifications/)
    - [UserCreated.php](app/Notifications/UserCreated.php)
    - [UserPasswordUpdated.php](app/Notifications/UserPasswordUpdated.php)
  - [Observers/](app/Observers/)
    - [PermissionRoleObserver.php](app/Observers/PermissionRoleObserver.php)
    - [RoleObserver.php](app/Observers/RoleObserver.php)
    - [RoleUserObserver.php](app/Observers/RoleUserObserver.php)
    - [UserObserver.php](app/Observers/UserObserver.php)
  - [Providers/](app/Providers/)
    - [AppServiceProvider.php](app/Providers/AppServiceProvider.php)
    - [PermissionServiceProvider.php](app/Providers/PermissionServiceProvider.php)
  - [View/](app/View/)
    - [Components/](app/View/Components/)
- [bootstrap/](bootstrap/)
  - [app.php](bootstrap/app.php)
  - [providers.php](bootstrap/providers.php)
- [config/](config/)
  - [app.php](config/app.php)
  - [auth.php](config/auth.php)
  - [cache.php](config/cache.php)
  - [cashier.php](config/cashier.php)
  - [constant.php](config/constant.php)
  - [database.php](config/database.php)
  - [filesystems.php](config/filesystems.php)
  - [logging.php](config/logging.php)
  - [mail.php](config/mail.php)
  - [queue.php](config/queue.php)
  - [sanctum.php](config/sanctum.php)
  - [services.php](config/services.php)
  - [session.php](config/session.php)
- [database/](database/)
  - [database.sqlite](database/database.sqlite)
  - [factories/](database/factories/)
    - [UserFactory.php](database/factories/UserFactory.php)
  - [migrations/](database/migrations/)
    - [0001_01_01_000000_create_users_table.php](database/migrations/0001_01_01_000000_create_users_table.php)
    - [0001_01_01_000001_create_cache_table.php](database/migrations/0001_01_01_000001_create_cache_table.php)
    - [0001_01_01_000002_create_jobs_table.php](database/migrations/0001_01_01_000002_create_jobs_table.php)
    - ...
  - [seeders/](database/seeders/)
    - ...
- [public/](public/)
  - [storage/](public/storage/)
  - [android-chrome-192x192.png](public/android-chrome-192x192.png)
  - [android-chrome-512x512.png](public/android-chrome-512x512.png)
  - [apple-touch-icon.png](public/apple-touch-icon.png)
  - [favicon-16x16.png](public/favicon-16x16.png)
  - [favicon-32x32.png](public/favicon-32x32.png)
  - [favicon.ico](public/favicon.ico)
  - [hot](public/hot)
  - [index.php](public/index.php)
  - [robots.txt](public/robots.txt)
  - [site.webmanifest](public/site.webmanifest)
  - [build/](public/build/)
    - ...
  - [img/](public/img/)
- [resources/](resources/)
  - [css/](resources/css/)
  - [js/](resources/js/)
  - [views/](resources/views/)
- [routes/](routes/)
  - [api.php](routes/api.php)
  - [auth.php](routes/auth.php)
  - [console.php](routes/console.php)
  - [web.php](routes/web.php)
- [storage/](storage/)
  - [app/](storage/app/)
  - [framework/](storage/framework/)
  - [logs/](storage/logs/)
- [tests/](tests/)
  - [TestCase.php](tests/TestCase.php)
  - [Feature/](tests/Feature/)
  - [Unit/](tests/Unit/)
- [vendor/](vendor/)
  - ...
- [artisan](artisan)
- [CHANGELOG.md](CHANGELOG.md)
- [composer.json](composer.json)
- [composer.lock](composer.lock)
- [LICENSE](LICENSE)
- [package.json](package.json)
- [phpunit.xml](phpunit.xml)
- [postcss.config.js](postcss.config.js)
- [README.md](README.md)
- [tailwind.config.js](tailwind.config.js)
- [vite.config.js](vite.config.js)

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

- Separation by Role: Customer, Restaurant Manager, and Admin have distinct permissions and dashboard views.
- Order Flow: Customers can order from any restaurant, Restaurant Managers only manage their own restaurants.
- Payment: Stripe is chosen for its ease of integration and testability.
- Loyalty Program: Simple 1 point = RM1 system, designed to be extendable for future reward schemes. Accumulated points can be redeemed during checkout.
- Tech Choices:
    - Laravel for scalable, secure backend.
    - AlpineJS to keep frontend lightweight and reactive without heavy SPA frameworks.
    - TailwindCSS for rapid, consistent UI styling.

## Additional Notes

- This system supports pickup and delivery order types.
- Restaurants require approval before becoming visible to customers.
- Admin panel includes restaurant approval and ban features.
- Loyalty points are accumulated automatically upon successful order payment.
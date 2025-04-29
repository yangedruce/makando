# Makando - Food Ordering System

A dashboard-based Food Ordering System built with:

- Laravel
- AlpineJS 
- TailwindCSS 
- Stripe (Payment Gateway)

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

## Testing Credentials

Use the following test accounts to access the system with different roles:

### Admin Account

```
Email: admin@email.com
Password: admin123
```

### Restaurant Manager Accounts

```
Email: manager1@email.com
Password: manager123
```

```
Email: manager2@email.com
Password: manager123
```

### Customer Accounts

```
Email: customer1@email.com
Password: customer123
```

```
Email: customer2@email.com
Password: customer123
```

```
Email: customer3@email.com
Password: customer123
```

Note:
- All test accounts are pre-seeded during database seeding.
- You can simulate different role-based views and features by logging in with the respective accounts.

## Assumptions and Architecture Decisions

### Authentication/Authorization
- There is a users table and customers table where only Customer have record in customers table.
- Users are differentiated by roles (Customer, Restaurant Manager, Admin)
- Role-based permissions control sidebar visibility and accessible routes.

### Admin Specific Role
- Admin have full system control.
- Admin can create and update user and customer.
- Admin can create and update role and permissions.

### Role-Specific Dashboard Content
- Customer dashboard: Create order, view Order status.
- Restaurant Manager dashboard: View/manage orders for their restaurants.
- Admin dashboard: Full system overview (approval, users, roles, restaurants).

### Restaurant Approval Workflow
- Restaurant Manager can submit restaurant details. Restaurants require approval before becoming visible to customers.
- Admin must approve a restaurant before it goes live. 
- Admin can ban restaurants in the Admin Panel.

### Separation of Concerns
- "Managements" (Restaurant, Menu, Menu Type) is for Managers/Admin.
- "Configurations" (User, Role) is strictly Admin-only.

### Multi-Restaurant Support
- Customer can order from multiple restaurants, but usually one order links to one restaurant at a time.
- Restaurant Managers can own multiple restaurants.

### Shop
- Display only active and approved restaurants.
- Allow filtering by category (e.g., Asian, Western, Desserts).
- Support search by restaurant name.
- Show restaurant information: restaurant name, address, category and status (open/closed).
- Allow direct navigation to view a restaurant’s menu.

### Order Management
- Customers create orders.
- Customers can choose either pickup or delivery order types.
- Restaurant Managers process orders (accept/reject).
- Admin oversees all orders if needed.

### Order Cart Behavior
- Customers have an individual cart for each restaurant.
- Each restaurant cart can hold multiple menu items.
- Only the latest cart for the selected restaurant is shown.
- The active cart is switched only when the customer views a menu from a different restaurant.
- When a cart is successfully checked out, it is automatically cleared to prevent duplicate orders.

### Payment Gateway
- Stripe is chosen for its ease of integration and testability.

### Loyalty Program
- Simple 1 point = RM1 system, designed to be extendable for future reward schemes.
- Accumulated points can be redeemed during checkout where 1 point = RM0.01.
- Loyalty points are accumulated automatically upon successful order payment and completed order.

## Future Roadmap

### Short-Term Enhancements
- Send real-time notifications (email/SMS/push) to Customers and Restaurant Managers for order status updates.
- Add detailed analytics for Restaurant Managers, including sales trends, peak hours, and best-selling items.
- Allow customers to filter past orders by date, restaurant, and order status.
- Allow restaurants to mark items as "On Promotion" and highlight discounts in the menu.

### Mid-Term Features
- Add support for additional payment methods (e.g., Billplz, PayPal, GrabPay) for Malaysian and Southeast Asian markets.
- Implement tiered loyalty programs (e.g., Silver, Gold, Platinum) and special discounts based on accumulated points.
- Automatically set restaurants as closed outside of their configured operating hours.
- Track key admin actions (approvals, bans, user changes) for security and auditing.
- Allow admins and restaurant managers to create and manage discount coupons.
- Enable admins and restaurant managers to initiate refunds through Stripe for canceled or disputed orders.
- Allow Admins and Restaurant Managers to manually create orders in the system on behalf of walk-in or phone customers. Walk-in orders can skip online payment and optionally be marked as "Paid (Cash)" or "Pending Payment.

### Long-Term Vision
- Make Makando installable on mobile devices, supporting offline access and push notifications.
- Introduce subscription plans for restaurants (e.g., Free, Premium) with different commission rates or feature access.
- Support English, Malay, Chinese for broader market coverage.
- Allow customers to view and pay in different currencies based on their location.
- Enable customers to leave reviews and ratings for restaurants and menu items.
- Integrate with delivery services (e.g., Lalamove, GrabExpress) to offer real-time delivery tracking.
- Build dedicated mobile apps for Customer and Restaurant Manager using Laravel API + Flutter.

### Bonus Nice-to-Haves
- Reward customers with badges for milestones (e.g., "First Order", "Frequent Buyer").
- Allow restaurants to register themselves and upload documents for admin approval.
- Enable real-time chat between customers and restaurants for customizations or inquiries.
- Allow customers to favorite restaurants or menu items for quicker access.

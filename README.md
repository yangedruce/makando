# Makando

Source code for Makando.

Tech stacks:

-   Laravel
-   AlpineJS
-   TailwindCSS

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

Execute the following commands in project directory to run Valet development server.

```
valet run
valet link
```

This project utilize Vite for source code bundling. To run, execute one of the following commands:

```bash
npm run dev
npm run build
npm run preview
```

Note that `npm run build` command must be executed when running development server.

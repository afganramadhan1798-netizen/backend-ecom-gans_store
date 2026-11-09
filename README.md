<p align="center">
  <img
    src="public/images/Logo.png"
    alt="Gan's Store Logo"
    width="180"
  />
</p>

<h1 align="center">Gan's Store</h1>

<p align="center">
  A Modern Full-Stack E-Commerce Website
</p>

# Gan's Store — E-Commerce Website

A web-based e-commerce application built with Vue.js, Laravel, and MySQL. Gan's Store provides an online shopping experience with product management, shopping cart, wishlist, checkout, order management, and an admin dashboard.

## About The Project

Gan's Store is a full-stack e-commerce project designed to simplify online shopping and store management.

The application separates the frontend and backend into two repositories. The frontend handles the user interface and interactions, while the backend provides REST API services, authentication, business logic, and database management.

## Features

### Customer Features

- User registration and login.
- Browse available products.
- View product details.
- Browse product categories.
- Add products to shopping cart.
- Update product quantities in cart.
- Remove items from cart.
- Manage wishlist.
- Manage delivery address.
- Checkout and create orders.
- View order history and order details.
- Cancel orders according to system rules.

### Admin Features

- Admin dashboard.
- Manage products (Create, Read, Update, Delete).
- Upload product images.
- Manage product categories.
- View registered users.
- Update user roles.
- Activate or deactivate user accounts.
- View customer orders.
- Update order statuses.

## Tech Stack

### Frontend

- Vue.js
- Vite
- JavaScript
- Axios
- CSS

### Backend

- PHP 8.3+
- Laravel 13
- Laravel Sanctum
- REST API

### Database

- MySQL

## Project Architecture

Gan's Store uses a separated frontend and backend architecture.

```text
Gan's Store
│
├── Frontend
│   ├── Vue.js
│   ├── Vite
│   ├── Axios
│   └── CSS
│
└── Backend
    ├── Laravel 13
    ├── Laravel Sanctum
    ├── REST API
    └── MySQL
```

## Repositories

| Component | Repository |
|---|---|
| Frontend | Add your frontend repository URL here |
| Backend | [backend-ecom-gans_store](https://github.com/afganramadhan1798-netizen/backend-ecom-gans_store) |

## Database Structure

The application uses MySQL with the following main tables:

| Table | Description |
|---|---|
| users | User account information |
| user_addresses | Customer addresses |
| categories | Product categories |
| products | Product information |
| carts | Shopping carts |
| cart_items | Cart items |
| wishlists | Customer wishlist |
| orders | Customer orders |
| order_items | Order details |
| personal_access_tokens | Laravel Sanctum tokens |

Laravel supporting tables are also used for migrations, sessions, cache, and job processing.

## Getting Started

Follow the instructions below to run the application locally.

### Prerequisites

Make sure you have installed:

- PHP 8.3 or higher.
- Composer.
- Node.js and npm.
- MySQL.
- Git.
- Laragon or another local development environment.

### 1. Clone the Backend Repository

```bash
git clone https://github.com/afganramadhan1798-netizen/backend-ecom-gans_store.git

cd backend-ecom-gans_store
```

### 2. Install Backend Dependencies

```bash
composer install
```

### 3. Configure Environment Variables

Copy `.env.example` into `.env`.

```bash
cp .env.example .env
```

Configure your local database connection:

```env
APP_NAME="Gan's Store"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gans_store_backend
DB_USERNAME=root
DB_PASSWORD=
```

Update the database values according to your local MySQL configuration.

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Run Database Migrations

```bash
php artisan migrate
```

If you have a database backup containing existing project data, import it into MySQL before using the application with that data.

### 6. Create Storage Link

```bash
php artisan storage:link
```

This command allows publicly accessible product images stored on Laravel's public disk to be served through the application.

### 7. Start Laravel Server

```bash
php artisan serve
```

The backend API will be available at:

```text
http://127.0.0.1:8000/api
```

## Frontend Setup

Clone your frontend repository separately.

```bash
git clone YOUR_FRONTEND_REPOSITORY_URL
cd YOUR_FRONTEND_PROJECT_FOLDER
```

Install dependencies:

```bash
npm install
```

Create a `.env` file in the frontend project root:

```env
VITE_API_BASE_URL=http://127.0.0.1:8000/api
```

Run the development server:

```bash
npm run dev
```

The frontend will be available at the local URL provided by Vite.

## API Authentication

Gan's Store uses Laravel Sanctum for API authentication.

After successful login, the frontend receives an authentication token and sends it with protected API requests through the Authorization header.

```http
Authorization: Bearer YOUR_ACCESS_TOKEN
Accept: application/json
```

Protected endpoints require a valid authentication token.

## Main API Endpoints

### Public Endpoints

| Method | Endpoint |
|---|---|
| POST | `/api/register` |
| POST | `/api/login` |
| GET | `/api/products` |
| GET | `/api/products/{product}` |
| GET | `/api/categories` |

### Customer Endpoints

| Method | Endpoint |
|---|---|
| GET | `/api/user` |
| POST | `/api/logout` |
| GET | `/api/orders` |
| POST | `/api/orders` |
| GET | `/api/cart` |
| POST | `/api/cart/items` |
| GET | `/api/wishlist` |
| POST | `/api/wishlist` |
| GET | `/api/address` |
| PUT | `/api/address` |

### Admin Endpoints

| Method | Endpoint |
|---|---|
| GET | `/api/admin/users` |
| PATCH | `/api/admin/users/{id}/role` |
| PATCH | `/api/admin/users/{id}/status` |
| GET | `/api/admin/products` |
| POST | `/api/admin/products` |
| PUT | `/api/admin/products/{product}` |
| DELETE | `/api/admin/products/{product}` |
| GET | `/api/admin/categories` |
| POST | `/api/admin/categories` |
| PUT | `/api/admin/categories/{category}` |
| DELETE | `/api/admin/categories/{category}` |
| GET | `/api/admin/orders` |
| PATCH | `/api/admin/orders/{order}/status` |

## Security Notes

- Never commit `.env` files containing credentials.
- Keep application keys and database passwords private.
- Protected API routes use Laravel Sanctum authentication.
- Admin endpoints require administrator authorization.
- User account status is checked by the backend middleware.

## Development Notes

- Frontend and backend are maintained in separate repositories.
- The backend communicates with the frontend through REST API.
- Axios is used for HTTP communication.
- Product images are managed through Laravel's public storage disk.
- MySQL is used as the primary database.

## Future Improvements

Potential future improvements include:

- Payment gateway integration.
- Shipping service integration.
- Product reviews and ratings.
- Order notifications.
- Sales analytics dashboard.
- Improved mobile experience.

## Author

**Afgan Ramadhan**

Full-Stack Web Development Project

## License

This project is developed for learning and portfolio purposes.

---

**Gan's Store — Online Shopping Made Simple.**

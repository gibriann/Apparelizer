# FirmosStore - Laravel 13

E-commerce application for custom apparel printing, migrated from Laravel 7 to Laravel 13.

## Features

- User authentication and authorization (Admin, Owner, Customer roles)
- Product management
- Shopping cart
- Shipping cost calculation via RajaOngkir API
- Payment gateway integration via Midtrans (Sandbox)
- Order tracking
- Transaction reports
- Admin dashboard

## Tech Stack

- **Framework**: Laravel 13.x
- **PHP**: 8.3+
- **Database**: SQLite (default) / MySQL
- **Payment Gateway**: Midtrans
- **Shipping API**: RajaOngkir

## Installation

### Prerequisites

- PHP 8.3 or higher
- Composer
- Node.js & NPM

### Setup Steps

1. Clone the repository
```bash
git clone <repository-url>
cd FirmosStore-Laravel11
```

2. Install dependencies
```bash
composer install
npm install
```

3. Configure environment
```bash
cp .env.example .env
php artisan key:generate
```

4. Configure database and API keys in `.env`:
```env
DB_CONNECTION=sqlite
# or for MySQL:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=firmosstore
# DB_USERNAME=root
# DB_PASSWORD=

# Midtrans Configuration (Get from https://dashboard.midtrans.com/)
MIDTRANS_SERVER_KEY=your_server_key
MIDTRANS_CLIENT_KEY=your_client_key
MIDTRANS_IS_PRODUCTION=false

# RajaOngkir Configuration (Get from https://rajaongkir.com/)
RAJAONGKIR_API_KEY=your_api_key
```

5. Run migrations and seeders
```bash
php artisan migrate:fresh --seed
```

6. Build assets
```bash
npm run build
```

7. Start development server
```bash
php artisan serve
```

Application will be available at `http://localhost:8000`

## Default Users

After seeding, you can login with:

**Admin Account:**
- Email: `superadmin@gmail.com`
- Password: `123456`

**Owner Account:**
- Email: `owner@gmail.com`
- Password: `654321`

## API Keys

### Midtrans (Payment Gateway)
1. Register at https://dashboard.midtrans.com/
2. Get your Server Key and Client Key from Settings
3. Use Sandbox mode for testing

### RajaOngkir (Shipping Cost API)
1. Register at https://rajaongkir.com/
2. Get your API Key
3. Starter plan is sufficient for basic usage

## Deployment

### Other Options
- Fly.io
- Render.com
- Traditional VPS with Docker

## Migration Notes

This project was migrated from Laravel 7 (2020) to Laravel 13 (2026) with the following changes:

- Updated all dependencies to Laravel 13 compatible versions
- Migrated routes from string-based to class-based syntax
- Updated model namespaces from `App\` to `App\Models\`
- Fixed middleware registration in `bootstrap/app.php`
- Moved hardcoded API keys to environment variables
- Updated all controllers to use proper model namespaces
- Fixed database migrations and seeders structure

## License

GPL-3.0. See [LICENSE](LICENSE).

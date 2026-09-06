🧾 Invoices Management System

A web-based invoicing system built with Laravel, designed to help businesses create, track, and manage customer invoices, products, and payment statuses — with reporting and data visualization built in.

✨ Features

🔐 Authentication & Authorization

- User registration and login (Laravel Breeze)
- Email verification
- Password reset / update
- Role and permission management (Spatie Laravel Permission)
- User management (admin can create/manage users and roles)

🧾 Invoices

- Create, edit, and delete invoices
- Add multiple products/sections per invoice
- Attach files/documents to invoices
- View, preview, and download invoice attachments
- Print invoices
- Export invoices to Excel
- Invoice status management (Paid / Unpaid / Partial)
- Filter invoices by payment status

📦 Products & Sections

- Manage products (CRUD)
- Manage sections/categories (CRUD)
- Link products to sections and invoices dynamically

🗄️ Archive

- Archive old/completed invoices
- Dedicated archive view separate from active invoices

📊 Dashboard & Reports

- Interactive charts (bar, pie, line) showing:
  - Invoice counts by status
  - Total amounts by status
  - Monthly invoice counts
  - Monthly revenue totals
- Invoices report with search
- Customers report with search

📬 Notifications

- Automatic notifications sent to users when a new invoice is created

🏗️ Tech Stack

**Backend:** PHP 8.2, Laravel 12
**Auth:** Laravel Breeze, Spatie Laravel Permission
**Charts & Reporting:** Laravel Charts, LarapexCharts, Chart.js
**Excel Export:** Maatwebsite/Excel
**Frontend:** Blade, Tailwind CSS, JavaScript, Vite
**Testing:** Pest / PHPUnit

📁 Project Structure

Key backend directories:

```
app/
├── Http/
│   ├── Controllers/     # Invoices, Products, Sections, Users, Roles, Reports, Dashboard...
│   └── Requests/
├── Models/              # invoices, products, sections, invoices_deatailes, invoices_attachement, User
├── Notifications/       # AddInvoice notification
└── Exports/             # InvoiceExcel export class

database/
├── factories/
├── migrations/
└── seeders/

resources/
└── views/               # Blade templates

routes/
├── web.php
└── auth.php
```

⚙️ Installation

1. Clone the repository
```bash
git clone https://github.com/mhmd-shokr/Invoices_System.git
cd Invoices_System
```

2. Install PHP dependencies
```bash
composer install
```

3. Install JS dependencies
```bash
npm install
```

4. Configure environment
```bash
cp .env.example .env
php artisan key:generate
```

5. Configure the database

Update the database settings in `.env`, then run:
```bash
php artisan migrate
```

If seeders are available:
```bash
php artisan db:seed
```

6. Create storage link
```bash
php artisan storage:link
```

7. Build frontend assets
```bash
npm run build
```

8. Start the application
```bash
php artisan serve
```

🔐 Environment Variables

Configure the required values in `.env`:

```
APP_NAME=
APP_ENV=
APP_KEY=
APP_URL=

DB_CONNECTION=
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

MAIL_MAILER=
MAIL_HOST=
MAIL_PORT=
MAIL_USERNAME=
MAIL_PASSWORD=
```

Never commit `.env` files or secret keys to GitHub.

🚀 Current Status

| Module | Status |
|---|---|
| Authentication | ✅ |
| Roles & Permissions | ✅ |
| Invoices (CRUD) | ✅ |
| Products & Sections | ✅ |
| File Attachments | ✅ |
| Invoice Status Management | ✅ |
| Archive | ✅ |
| Excel Export | ✅ |
| Print Invoice | ✅ |
| Dashboard & Charts | ✅ |
| Reports (Invoices/Customers) | ✅ |
| Automated Testing | 🚧 |

🔮 Future Improvements

- Increase automated test coverage
- Add a REST API layer for external/mobile clients
- PDF export for invoices
- Improve reporting filters and export options

👨‍💻 Author

**Mohamed Shokr**
Laravel Backend Developer
PHP · Laravel · MySQL · Spatie Permission · Laravel Charts

⭐ If you find this project useful, feel free to explore the source code and leave a star.

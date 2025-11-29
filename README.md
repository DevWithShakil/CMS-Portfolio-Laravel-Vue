# 🛠️ Portfolio CMS – Backend API (Laravel)

A robust and scalable **RESTful API** built with **Laravel**, designed to power the Portfolio Content Management System.  
It handles authentication, content management, media storage, site settings, and serves data to both the **Admin Dashboard** and the **Public Frontend**.

---

## ✨ Key Features

-   **🔐 Authentication** – Secure login using Laravel Sanctum
-   **📡 RESTful API** – CRUD for Projects, Skills, Blogs, Experience, Education
-   **📂 File Handling** – Upload/manage images, thumbnails & documents
-   **⚙️ Dynamic Settings** – Website configurations via API
-   **🔍 Global Search** – Search across multiple models
-   **📬 Contact System** – Stores frontend contact inquiries
-   **🌱 Database Seeding** – Ready-made factories & seeders

---

## 🛠️ Tech Stack

-   **Framework:** Laravel 10/11
-   **Language:** PHP 8.1+
-   **Database:** PostgreSQL / MySQL
-   **Auth:** Laravel Sanctum
-   **Storage:** Local Disk / AWS S3

---

## 🚀 Getting Started

Follow the steps below to set up the backend locally.

---

### 1️⃣ Prerequisites

-   PHP 8.1+
-   Composer
-   PostgreSQL / MySQL
-   Git

---

### 2️⃣ Installation

```bash
cd backend-laravel
composer install
```

3️⃣ Environment Configuration

cp .env.example .env

Update .env:

DB_CONNECTION=
DB_HOST=
DB_PORT=5432
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
APP_URL=
FRONTEND_URL=

4️⃣ Generate App Key & Migrate Database

php artisan key:generate
php artisan migrate:fresh --seed

5️⃣ Storage Link

php artisan storage:link

6️⃣ Run Server
php artisan serve

📡 API Documentation Overview
🔓 Public Routes

| Method | Endpoint             | Description               |
| ------ | -------------------- | ------------------------- |
| POST   | `/api/login`         | Admin login               |
| POST   | `/api/contacts`      | Submit contact form       |
| GET    | `/api/projects`      | Get projects (`?limit=3`) |
| GET    | `/api/skills`        | Get skills (`?all=true`)  |
| GET    | `/api/blogs`         | Get published blogs       |
| GET    | `/api/settings`      | Get settings & profile    |
| GET    | `/api/public-search` | Global public search      |

🔒 Admin Routes (Sanctum Protected)
Prefix: /api/admin

| Method | Endpoint         | Description             |
| ------ | ---------------- | ----------------------- |
| GET    | `/profile`       | Get admin profile       |
| PUT    | `/profile`       | Update profile/password |
| GET    | `/notifications` | Unread message count    |
| CRUD   | `/projects`      | Manage projects         |
| CRUD   | `/skills`        | Manage skills           |
| CRUD   | `/blogs`         | Manage blogs            |
| PUT    | `/settings/{id}` | Update site settings    |

📄 License
This project uses the MIT License.

❤️ Developed by Md. Shakil Khan

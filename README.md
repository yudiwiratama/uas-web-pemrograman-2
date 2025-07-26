# E-Course / E-Learning / Learning Management System (LMS)

## Preview
<img width="1278" height="704" alt="image" src="https://github.com/user-attachments/assets/a1c2ac90-e4e4-40d6-9b4c-fd8abd2bea41" />


---

# 🎓 Learning Management System (LMS)

A fully functional and production-ready Learning Management System built with **Laravel 11**, supporting comprehensive course and material management, user authentication, file uploads, and admin moderation.

---

---

## 🧩 Features

* User authentication and role-based access (User & Admin)
* Course and material management (CRUD)
* Support for multiple file types (videos, documents, audio, images)
* HTML-based article input
* Comment system for course discussions
* Admin approval workflow for submitted content
* Responsive UI with Tailwind CSS

### 👥 User Roles

* **Users**: Can create courses/materials, participate in discussions
* **Admins**: Can approve content, manage users, and oversee the system

---

## 🔧 Recent Fixes & Improvements

* ✅ Fixed route conflicts (`/courses/create`, `/materials/create`)
* ✅ CRUD enhancements: consistent data display and HTTP method alignment
* ✅ File upload system improved with type-specific validation (MKV added)
* ✅ Optimized validation logic based on material type

---

## 🎬 Supported File Types

| Type     | Formats                          | Max Size | Notes                       |
| -------- | -------------------------------- | -------- | --------------------------- |
| Video    | MP4, AVI, MOV, WMV, FLV, **MKV** | 10MB     | For lectures/tutorials      |
| Document | PDF                              | 10MB     | For handouts/references     |
| Audio    | MP3, WAV, AAC, OGG               | 20MB     | For podcasts/voice lectures |
| Image    | JPEG, PNG, GIF, WebP             | 5MB      | For illustrations/diagrams  |
| Article  | HTML (rich text input)           | -        | No file upload required     |

> ⚠️ Note: Increase PHP upload limits to enable larger file uploads (see below).

---

## ⚙️ PHP Configuration for File Uploads

By default, PHP limits uploads to **2MB**. To increase:

1. Locate `php.ini`:

   ```bash
   php --ini
   ```

2. Modify values:

   ```ini
   upload_max_filesize = 50M
   post_max_size = 50M
   max_execution_time = 300
   memory_limit = 256M
   ```

3. Restart your web server:

   ```bash
   # Apache
   sudo systemctl restart apache2

   # Nginx + PHP-FPM
   sudo systemctl restart php8.3-fpm
   sudo systemctl restart nginx
   ```

4. Verify:

   ```bash
   php -r "echo ini_get('upload_max_filesize');"
   ```

---

## 🚀 Quick Start Guide

### Requirements

* PHP 8.2+
* Composer
* Laravel 11
* MySQL/PostgreSQL
* Node.js & npm

### Installation

```bash
git clone <your-repo-url>
cd learning-dev

composer install
npm install

cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan storage:link

npm run build
php artisan serve
```

### Default Credentials

```bash
Admin
Email: admin@admin.com
Password: password

User
Email: john@example.com
Password: password
```

---

## 🧑‍🏫 How to Use

### For Users

* View courses: `/courses`
* Create material: `/materials/create` (login required)
* Create course: `/courses/create` (auto-approved)

### For Admins

* Manage pending materials: `/admin/approvals`
* Full access to courses, materials, users, and comments

---

## ⚙️ System Architecture

**Backend:**

* Laravel 11, PHP 8.2+
* Sanctum for authentication
* MySQL/PostgreSQL
* Laravel Storage (public disk)

**Frontend:**

* Tailwind CSS, Vite
* Blade templates
* Vanilla JS for interactions

**Security:**

* CSRF protection
* File validation (type & size)
* Role-based access control

---



## 🚀 Deployment Options

###  VPS / Cloud Server (Ubuntu)

```bash
# Server Setup
sudo apt install nginx mysql-server php8.2-fpm php8.2-mysql php8.2-xml php8.2-zip php8.2-curl php8.2-mbstring -y

# Project Setup
git clone ...
composer install --optimize-autoloader --no-dev
npm install && npm run build
php artisan migrate --force
php artisan storage:link
```

### Docker 🐳 (Recommended)

```bash
# Quick Start
git clone ...
./docker-deploy.sh deploy

# Access:
# App: http://localhost:8000
# phpMyAdmin: http://localhost:8080
# Redis Commander: http://localhost:8081
```

Supports:

* Laravel + Nginx + Supervisor
* MySQL, Redis, phpMyAdmin
* Background queues & scheduled tasks

---

## 📦 Docker Overview

**Folder Structure:**

```
learning-dev/
├── Dockerfile
├── docker-compose.yml
├── docker-deploy.sh
└── docker/
    ├── nginx.conf
    ├── php.ini
    ├── supervisord.conf
```

**Commands:**

```bash
./docker-deploy.sh deploy     # Deploy
./docker-deploy.sh stop       # Stop all
./docker-deploy.sh logs       # View logs
docker-compose exec app bash # Access app container
```

---


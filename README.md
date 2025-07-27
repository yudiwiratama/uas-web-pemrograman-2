# E-Course / E-Learning / Learning Management System (LMS)

## Preview
<img width="1278" height="704" alt="image" src="https://github.com/user-attachments/assets/a1c2ac90-e4e4-40d6-9b4c-fd8abd2bea41" />


---

# Learning Management System (LMS)

Production ready LMS dibuat dengan framework Laravel 11

---

## Fitur

* Authentikasi pengguna dan akses berdasarkan roles (Pengguna & Admin)
* Pengelolaan kursus dan materi dengan CRUD (Create Reade Update Delete)
* Dukungan untuk berbagai jenis file (video, dokumen, audio, gambar)
* Sistem komentar untuk diskusi

### User Roles

* **Users**: Dapat membuat course, dan berpartisipasi dalam diskusi 
* **Admins**: Approve content, manage user, dan melihat keseluruhan isi dari courses

---

## PHP Configuration for File Uploads

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

## Quick Start Guide

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


## Deployment Options

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

### Docker (Recommended)

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

## Docker Overview

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

## Changelogs

* Fixed route conflicts (`/courses/create`, `/materials/create`)
* CRUD enhancements: consistent data display and HTTP method alignment
* File upload system improved with type-specific validation (MKV added)
* Optimized validation logic based on material type

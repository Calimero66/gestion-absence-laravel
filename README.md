<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# 📆 Gestion d'Absence - Laravel 11

A simple and efficient absence management system built with **Laravel 11**, **Breeze**, **Blade**, **Tailwind CSS**, and **MySQL**. Teachers can record student absences, and students can view them and upload justifications. Email notifications are sent based on absence thresholds.

---

## 🚀 Features

- 🔐 Authentication with Laravel Breeze (Blade version)
- 👨‍🏫 Teachers manage absences for their assigned classes
- 👨‍🎓 Students can view their absences and upload justifications
- 📁 File upload & download (PDF, PNG, JPG)
- 📬 Email notifications based on absence thresholds (5, 10, 15)
- 🎨 Tailwind CSS UI

---

## 👥 Roles

### 👨‍🏫 Teacher

- Can view their assigned **classes** and **students**.
- Can **add absences** for students.
- Can **see uploaded justifications** for each absence.
- Can **download and verify justification files**.
- Can **update the absence status** to:
  - `Absent`
  - `Justified` (if a valid file is uploaded)
  - `Rejected` (if justification is invalid)

### 👨‍🎓 Student

- Can view their **personal absence records**.
- Can **upload justification documents** for any of their absences.
- Can **download previously uploaded justifications**.
- Automatically receives email alerts when absence thresholds are reached.

---

## 📬 Email Notifications

Students are notified via email when their total absence count passes key thresholds:

| Threshold | Description                     |
|-----------|---------------------------------|
| > 5       | First warning                   |
| > 10      | Second warning (serious)        |
| > 15      | Final warning (disciplinary)    |

Each level sends a **different email**, and notifications are only sent once per threshold.

---

## ⚙️ Installation

```bash
git clone https://github.com/Calimero66/gestion-absence-laravel
cd gestion-absence-laravel

composer install
npm install

cp .env.example .env
php artisan key:generate

# Configure .env (DB + Mail)
php artisan migrate --seed
php artisan storage:link

npm run dev
php artisan serve

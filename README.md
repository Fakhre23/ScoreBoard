# 🏆 University Leaderboard System (ScoreBoard Project)

![Laravel](https://img.shields.io/badge/Laravel-11-red?style=for-the-badge&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.3-blue?style=for-the-badge&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-Database-orange?style=for-the-badge&logo=mysql)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-Framework-38B2AC?style=for-the-badge&logo=tailwind-css)
![Fedora](https://img.shields.io/badge/Fedora-Linux-294172?style=for-the-badge&logo=fedora)
![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)

---

### 🎯 Overview

The **University Leaderboard System (ScoreBoard Project)** is a web platform built with **Laravel** to manage universities, users, and events — and to track their performance and ranking dynamically.  
It helps universities organize competitions, record participation, and display real-time leaderboards in a clean and interactive interface.

---

## 🚀 Features

### 👥 User Management

-   Role-based accounts (Admin, Ambassador, Vice Ambassador, Student)
-   Auto-link users to their universities
-   Full CRUD for users with validation

### 🎓 University & Event Management

-   Create, approve, and manage university events
-   Limit event participation (`max_participants`)
-   Automatic event status updates (Approved, Pending, Rejected)

### 🏅 Scoring & Leaderboards

-   Track participation and compute total user scores
-   Automatic ranking updates for users and universities
-   Top users and top universities leaderboard pages

### 🕒 History Tracking

-   All user actions (registration, participation, updates) logged in `user_history`

### 🔐 Access Control

-   Role-based authorization and clean middleware protection

---

## 🧩 Tech Stack

| Layer               | Technology                    |
| ------------------- | ----------------------------- |
| **Framework**       | Laravel 11                    |
| **Frontend**        | Blade, TailwindCSS, Alpine.js |
| **Database**        | MySQL                         |
| **Server**          | Apache / Nginx                |
| **Environment**     | Fedora Linux                  |
| **Version Control** | Git & GitHub                  |

---

## ⚙️ Installation Guide

### 1️⃣ Clone the Repository

```bash
git clone https://github.com/yourusername/scoreboard.git
cd scoreboard
```

### 2️⃣ Install Dependencies

```bash
composer install
npm install
npm run dev
```

### 3️⃣ Environment Setup

Copy the example environment file:

```bash
cp .env.example .env
```

Then update:

-   `DB_DATABASE=scoreboard`
-   `DB_USERNAME=root`
-   `DB_PASSWORD=yourpassword`

### 4️⃣ Generate App Key & Migrate Database

```bash
php artisan key:generate
php artisan migrate --seed
```

### 5️⃣ Start the Server

```bash
php artisan serve
```

Now open your browser at 👉 **[http://127.0.0.1:8000](http://127.0.0.1:8000)**

---

## 🧠 What I Learned

💡 Through building this system, I learned:

-   Deep understanding of **Laravel MVC structure**
-   How to use **Eloquent relationships** efficiently
-   Implementing **real-time validation and scoring logic**
-   Designing scalable **role-based access control**
-   Handling **database relations** between users, events, and universities
-   Creating a consistent and responsive UI using **Blade + TailwindCSS**

---

## 🧑‍💻 Author

**👤 Fakhre Tamimie**
 Software Development
 
💼 [LinkedIn](https://www.linkedin.com/in/fakhretamimie)
📧 [fakhre@vibes.solutions](fakhre@vibes.solutions)
📧 [fakhretamimie@gmail.com](fakhretamimie@gmail.com)

---

## ⭐ Future Improvements

-   [ ] Live leaderboard updates via WebSockets
-   [ ] API for mobile integration
-   [ ] AI-based performance insights
-   [ ] Admin dashboard analytics

---

> “The goal is not to build software, but to build impact through software.” 💪




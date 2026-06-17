<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

---

## 🔥 Shajahan Tandoori Grills

An AI-powered restaurant ordering system built with Laravel 12, featuring authentic Multan cuisine, smart food recommendations, and a complete order management workflow.

**🌐 Live Demo:** [ai-restaurant-system.up.railway.app](https://ai-restaurant-system.up.railway.app)

---

## 📖 About

Shajahan Tandoori Grills is a full-stack restaurant web application that lets customers browse a curated menu, get AI-assisted food suggestions, place orders, and track them in real time. Admins get a dedicated dashboard to manage food items, categories, orders, and users.

## ✨ Features

- **User Authentication** — secure registration and login for customers, with a separate admin login flow
- **Dynamic Menu** — browse dishes by category, with pricing, discounts, and effective-price calculations
- **AI Food Assistant** — an integrated AI agent that helps users discover dishes based on their preferences
- **Shopping Cart & Checkout** — add items to cart, review the order, and check out smoothly
- **Order Tracking** — customers can follow their order status from placement to delivery
- **Admin Dashboard** — manage foods, categories, orders, and users from one place
- **User Profile** — manage personal details and notification preferences
- **Responsive Design** — built with Tailwind CSS for a clean experience across devices

## 🛠️ Tech Stack

| Layer | Technology |
|---|---|
| Backend | Laravel 12 (PHP 8.2+) |
| Frontend | Blade Templates, Tailwind CSS |
| Database | MySQL (production)  |
| Hosting | Railway |
| AI Integration | Anthropic API |

## 🚀 Getting Started

### Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js & npm
- MySQL 

### Installation

```bash
# Clone the repository
git clone https://github.com/salmanDevHub/AI-Restaurant-System.git
cd AI-Restaurant-System

# Install PHP dependencies
composer install

# Install JS dependencies
npm install

# Set up environment file
cp .env.example .env
php artisan key:generate

# Run migrations
php artisan migrate

# Build frontend assets
npm run build

# Start the development server
php artisan serve
```

Visit `http://localhost:8000` in your browser.

### Demo Accounts

| Role | Email | Password |
|---|---|---|
| Demo User | user@shahjan.com | user123 |
| Admin | admin@shahjan.com | admin123 |

## 📁 Project Structure

```
app/
├── Http/Controllers/
│   ├── Admin/         # Admin panel controllers
│   ├── User/           
│   └── AIAgentController.php
├── Models/             
└── Services/
    └── AIAgentService.php

resources/views/
├── admin/               # Admin dashboard views
├── auth/                # Login & registration
└── user/                # Menu, cart, orders, profile
```

## 🌍 Deployment

This project is deployed on [Railway](https://railway.app) with a MySQL database. The live version is available at:

👉 **[https://ai-restaurant-system.up.railway.app](ai-restaurant-system.up.railway.app)**


## 👤 Author

**Salman**
GitHub: [@salmanDevHub](https://github.com/salmanDevHub)

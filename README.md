
# 📰 News Aggregator API

A simple yet robust **News Aggregator Backend** built with **Laravel**, designed to fetch, store, and serve news articles from multiple external sources.  
The system supports **filtering, search, and user preference–based recommendations** — all without authentication.

---

## 🚀 Features

- Aggregates news from **three sources** ( NewsAPI, The Guardian, New York Times)
- Updates news data every **6 hours** automatically via scheduled jobs
- Filters news by:
    - Date
    - **Source**
    - **Category**
    - **Author**
- Supports **search** through multiple fields (title, content, category, source)
- Handles **visitor-based preferences** (stored by unique visitor identifier)
- Implements **SOLID principles** and **clean architecture**

---

## 🧠 System Design Overview

The project is divided into cleanly separated layers:

- **Services:** Each news source implements a `NewsServiceInterface` and defines a `fetch()` method.
- **Aggregator:** The `NewsAggregatorService` class aggregates from all service providers and persists new data.
- **Scheduler:** A Laravel cron job runs every 6 hours to pull and store new articles.

### Visitor Preferences & Middleware

The system handles visitor tracking and preferences through:

- **VisitorMiddleware:** Creates and manages unique visitor IDs via cookies
- **PreferenceService:** Stores and retrieves visitor preferences
- **Request Merging:** Automatically injects visitor context into all requests

```php
// Simplified flow:
Request → VisitorMiddleware → Controller → PreferenceService → Response
```

Key components:

1. **Cookie Management:**
        - Secure, HTTP-only configuration
        - Automatic ID generation for new visitors

2. **Preference Storage:**
        - Categories
        - Sources
        - Keywords
        - Last visit timestamp

3. **Request Enhancement:**
        - Visitor ID injection
        - Preference context merging
        - Automatic preference application

---

## 🏗️ Tech Stack

- **Backend:** Laravel 12
- **Database:** MySQL
- **Cache:** Redis (optional)
- **HTTP Client:** Laravel HTTP client for API consumption
- **Scheduler/Queue:** Laravel Scheduler (for periodic updates)

---

## ⚙️ Setup Instructions

### 1. Clone the repository

```bash
git clone https://github.com/rahmanakorede442/newsAggregator.git
cd newsAggregator
```

### 2. Install dependencies

```bash
composer install
```

### 3. Set up environment variables

Copy `.env.example` to `.env`:

```bash
cp .env.example .env
```

Then configure your database and credential settings:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=news_aggregator
DB_USERNAME=root
DB_PASSWORD=

NEWS_API_KEY=
NYT_API_KEY=
GUARDIAN_API_KEY=

CACHE_DRIVER=redis
QUEUE_CONNECTION=database
```

### 4. Generate the application key

```bash
php artisan key:generate
```

### 5. Run migrations

```bash
php artisan migrate
```

### 6. (Optional) Seed initial data

```bash
php artisan db:seed
```

### 7. Run the aggregator manually

```bash
php artisan schedule:work
```

Or let it run automatically every 6 hours (already configured in `app/Console/Kernel.php`).

---

## 🧾 API Documentation

All endpoints are documented in Postman:
👉 [View the Postman Documentation](https://documenter.getpostman.com/view/22260651/2sB3WtqyEP)

Example endpoints:

* `GET /api/news` → Fetch paginated and filtered news
* `GET /api/preferences` → Get visitor preferences
* `POST /api/preferences` → Save visitor preferences
* `GET /api/sources` → Get available news sources
* `GET /api/authors` → Get available news authors
* `GET /api/categories` → Get available categories

---

## 🧩 Example Query

```bash
GET /api/news?search=politics&date=2025-11-01&category=World&visitor_id=abc123
```

Returns news articles matching the query and/or the visitor's stored preferences.

---

## 🧰 Scheduler Setup (for periodic updates)

Set up the Laravel scheduler on your server (e.g., in cron):

```bash
* */6 * * * php /path-to-your-project/artisan schedule:run >> /dev/null 2>&1
```

This ensures news is refreshed every 6 hours.

---

## 🧑‍💻 Development

Run the local server:

```bash
php artisan serve
```

You can also use Laravel Sail or Docker if you prefer containerized development.

---

## 🧱 Project Architecture Highlights

* **Interface Segregation:** Each news source service implements a shared `NewsServiceInterface`
* **Dependency Inversion:** The `NewsAggregatorService` depends only on abstractions, not concrete implementations
* **Single Responsibility:** Each service handles one source; aggregator handles merging and persistence
* **Open/Closed Principle:** New sources can be added without modifying the aggregator

---

## 🏁 Conclusion

This project demonstrates clean backend design, modularity, and maintainability while meeting performance and simplicity requirements for a small-scale, production-ready news aggregator.

---

**Author:** Abdulmujeeb
**Framework:** Laravel 12
**Language:** PHP 8.3
**License:** MIT

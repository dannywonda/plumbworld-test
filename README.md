````markdown
# Laravel 10 – Plumbworld Test

A web-based plumbing service management application built with Laravel 10. This project includes features such as job scheduling, customer management, and an admin dashboard.

---

## ⚙️ Setup Instructions

### 1. Clone the Repository
```bash
git clone https://github.com/dannywonda/plumbworld-test.git
cd plumbworld
````

### 2. Install PHP Dependencies with Composer

```bash
composer update
```

> If you don't have Composer installed, get it from [https://getcomposer.org](https://getcomposer.org).

### 3. Install JavaScript Dependencies with NPM

```bash
npm install
```

> Make sure Node.js is installed. You can download it from [https://nodejs.org](https://nodejs.org).

### 4. Create and Configure `.env` File

```bash
cp .env.example .env
```

Open `.env` and configure your database and mail settings.

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Run Migrations and Seed the Database

```bash
php artisan migrate --seed
```

### 7. Serve the Application

```bash
php artisan serve
```

Visit: [http://localhost:8000](http://localhost:8000)

### 8. Build Frontend Assets

```bash
npm run dev        # For development
npm run build      # For production
```

## 📝 Notes

* This project is built with **Laravel 10**, **Vite**, and **Tailwind CSS**.
* Ensure your `.env` file is properly configured before running `migrate` and `db:seed`.
* The seeders may include demo content or default users. You can customize them in `database/seeders/`.

> ⚠️ **Note on Laravel Versions:**
> I initially started this project using **Laravel 12** (which is available on my system), but due to some local compatibility issues, I reverted to **Laravel 10** to ensure stability and complete the project within the available timeframe. The current implementation is fully compatible with Laravel 10 and uses best practices aligned with it.

---

## ✅ Optional Enhancements (Planned or Incomplete)

* [ ] Authentication
* [ ] Email verification for new users
* [ ] Job notification system
* [ ] Full admin dashboard UI
* [ ] Unit and feature tests

---

## 📄 License

MIT License

---

## 👤 Author

**Danny Wonda**
GitHub: [@dannywonda](https://github.com/dannywonda)

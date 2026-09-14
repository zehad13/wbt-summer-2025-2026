# ChaJoy – Online Beverage Ordering System

A university Web Technologies project built with **PHP + MySQL** using a
simple, hand-rolled **MVC** structure (no frameworks). Demonstrates PHP
conditionals, loops, string functions, form validation, PHP sessions,
AJAX, JSON, and full MySQL CRUD operations.

## 1. Setup (XAMPP / WAMP)

1. Copy the whole `ChaJoy` folder into your `htdocs` (XAMPP) or `www` (WAMP) directory.
2. Start Apache and MySQL from your control panel.
3. Open **phpMyAdmin** (`http://localhost/phpmyadmin`).
4. Click **Import**, choose `database/chajoy_db.sql`, and run it.
   This creates the `chajoy_db` database, all tables, and sample data
   (3 accounts + 4 categories + 9 beverages).
5. Check `config/database.php` — the defaults (`root` / empty password)
   match a standard XAMPP/WAMP install. Change them if yours differs.
6. Visit `http://localhost/ChaJoy/` in your browser.

> If your folder is not directly at `/ChaJoy/`, update `BASE_URL` in
> `config/config.php` to match.

## 2. Demo Accounts

All sample accounts use the password: **password123**

| Role     | Email                  |
|----------|-------------------------|
| Admin    | admin@chajoy.com        |
| Delivery | delivery@chajoy.com     |
| Customer | customer@chajoy.com     |

## 3. Project Structure (MVC)

```
ChaJoy/
├── config/          -> database.php (connection), config.php (app bootstrap)
├── controllers/      -> business logic, one file per feature area
├── models/           -> all direct database (mysqli) operations
├── views/            -> HTML/PHP templates, organized by role
│   ├── customer/
│   ├── admin/
│   ├── delivery/
│   ├── auth/
│   └── layouts/       (shared header/footer for each area)
├── includes/functions.php -> shared helpers (validation, string utils, auth guards)
├── public/           -> css/, js/, images/
├── database/chajoy_db.sql
└── index.php          -> single front controller / router
```

**Model = Database operations** (`models/*.php` — plain mysqli + prepared statements)
**View = HTML/UI** (`views/*.php`)
**Controller = business logic** (`controllers/*.php`, called from `index.php`)

Every request goes through `index.php?page=...`, which is a simple
`switch` statement dispatching to the right controller function — easy
to trace and explain during a viva/defense.

## 4. Key Features Implemented

- Customer registration & login with PHP sessions, password hashing, and
  full server-side validation (required fields, email format, phone format,
  password length/match, duplicate email check)
- Beverage listing with **AJAX search + category filtering** (JSON responses,
  no page reload) — see `ajax_beverage_search` in `BeverageController.php`
- Shopping cart with **AJAX quantity update/remove** and live totals
- Checkout with delivery info + COD/Online payment, auto-generated Order ID,
  and stock deduction
- Order tracking with a visual stage tracker (Pending → Preparing → Ready for
  Pickup → Out for Delivery → Delivered), with conditional cancel button
- Customer dashboard, order history, profile editing, password change
- Admin dashboard with live stats, beverage/category CRUD (via modal forms),
  order management with **AJAX status updates**, delivery-person assignment,
  customer & delivery-personnel lists
- Delivery personnel dashboard with **AJAX pickup / mark-delivered** actions,
  restricted to orders assigned to that specific delivery person
- Role-based access control via `requireRole()` — admins, customers, and
  delivery personnel each only see their own areas

## 5. Adding Real Images

The UI currently shows a 🥤 emoji as a placeholder for beverage photos so
the site works immediately with zero setup. To use real photos:

1. Drop image files into `public/images/` (filenames are listed in
   `database/chajoy_db.sql`, e.g. `cappuccino.jpg`).
2. In the view files (e.g. `views/customer/home.php`, `beverages.php`),
   replace `<div class="beverage-img">🥤</div>` with
   `<img src="public/images/<?php echo $b['image']; ?>" class="beverage-img">`.

## 6. Notes for Your Report / Viva

- **Conditionals**: role checks (`requireRole`), stock availability checks,
  order-status logic, cancel-button visibility (`canCancelOrder()`).
- **Loops**: `foreach` used throughout views to render beverages, cart items,
  orders, categories.
- **Strings**: `generateOrderId()`, `slugify()`, `truncateText()`,
  `formatMoney()` in `includes/functions.php` use `strlen()`, `substr()`,
  `strtolower()`, `str_replace()`, `strtoupper()`.
- **AJAX + JSON**: beverage search/filter, add/update/remove cart item,
  admin order status update, delivery pickup/delivered — all return
  `json_encode()`'d responses consumed by vanilla `XMLHttpRequest`.
- **Security**: `password_hash()`/`password_verify()`, prepared statements
  everywhere, `htmlspecialchars()` output escaping via the `clean()` helper,
  session-based auth, role-based route guards.

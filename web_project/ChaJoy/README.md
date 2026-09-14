# ChaJoy – Online Beverage Ordering System

A university Web Technologies project built with **PHP + MySQL** using a simple, hand-rolled **MVC structure** without any external frameworks.

## 1. Setup (XAMPP / WAMP)

1. Copy the whole `ChaJoy` folder into your `htdocs` (XAMPP) or `www` (WAMP) directory.
2. Start **Apache** and **MySQL** from the control panel.
3. Open **phpMyAdmin**:
   `http://localhost/phpmyadmin`
4. Click **Import** and select:
   `database/chajoy_db.sql`
5. Import the SQL file to create the database, tables, and sample data.
6. Check `config/database.php` and update the database credentials if required.
7. Open the project in your browser:

   `http://localhost/ChaJoy/`

> If the project folder is located somewhere else, update `BASE_URL` in `config/config.php`.

## 2. Demo Accounts

All sample accounts use the password:

`password123`

 Role     | Email                                             

 Admin    | (:admin@chajoy.com)       
 Delivery | (:delivery@chajoy.com) 
 Customer | (:customer@chajoy.com) 

## 3. Project Structure

```text
ChaJoy/
├── config/
│   ├── database.php
│   └── config.php
│
├── controllers/
│   └── Feature controllers
│
├── models/
│   └── Database operations
│
├── views/
│   ├── customer/
│   ├── admin/
│   ├── delivery/
│   ├── auth/
│   └── layouts/
│
├── includes/
│   └── functions.php
│
├── public/
│   ├── css/
│   ├── js/
│   └── images/
│
├── database/
│   └── chajoy_db.sql
│
└── index.php
```

### MVC Structure

* **Model:** Handles database operations.
* **View:** Handles the HTML and user interface.
* **Controller:** Handles application logic and connects Models with Views.
* **index.php:** Works as the main entry point and router.

## 4. Key Features

### Customer

* User registration and login
* Session-based authentication
* Beverage browsing
* AJAX beverage search
* Category filtering
* Shopping cart
* AJAX cart quantity update and item removal
* Checkout system
* Cash on Delivery and online payment options
* Order placement and tracking
* Order history
* Customer dashboard
* Profile editing
* Password change

### Admin

* Admin dashboard
* Beverage management
* Add, edit, and delete beverages
* Category management
* Add, edit, and delete categories
* Order management
* AJAX order status updates
* Delivery-person assignment
* Customer management
* Delivery personnel management

### Delivery Personnel

* Delivery dashboard
* View assigned orders
* AJAX pickup action
* Mark orders as delivered
* Access restricted to assigned orders

### Security

* Password hashing
* Password verification
* Prepared SQL statements
* Server-side form validation
* Session-based authentication
* Role-based access control
* HTML output escaping

## 5. AJAX Features

The system uses **AJAX and JSON** for several operations without requiring a full page reload, including:

* Beverage search and filtering
* Cart quantity updates
* Cart item removal
* Admin order status updates
* Delivery pickup and delivery actions

## 6. Real Beverage Images

The project currently supports beverage images through:

```text
public/images/
```

To use real beverage images, place the image files inside this folder and use the corresponding image filename stored in the database.

## 7. Technologies Used

* **PHP**
* **MySQL**
* **HTML5**
* **CSS3**
* **JavaScript**
* **AJAX**
* **JSON**
* **XAMPP / Apache**
* **phpMyAdmin**

## 8. Database

The project uses MySQL as its database system.

The database contains information related to:

* Users
* Categories
* Beverages
* Cart
* Orders
* Order Items
* Delivery Personnel
* Payments

The database file is located at:

```text
database/chajoy_db.sql
```

# REPLATE — Food Waste Reduction Platform

Helping restaurants reduce food waste by selling surplus meals at discounted prices while promoting sustainable consumption.

---

## About

REPLATE is a web-based platform that connects restaurants with customers looking for affordable meals made from surplus food. Instead of wasting perfectly good food, restaurants can publish available meals on the platform, allowing users to purchase them at lower prices.

The platform aims to reduce food waste, support local businesses, and encourage environmentally responsible consumption.

---

## Features

- Browse available surplus meals from restaurants.
- User registration and secure login.
- Restaurant dashboard for meal management.
- Shopping cart and online checkout.
- PayPal payment integration.
- Email confirmation using PHPMailer.
- Order history and account management.
- Sales and revenue reports for restaurants.
- Loyalty points and discount rewards.
- Responsive design for desktop and mobile devices.

---

## Project Structure

```
REPLATE/
│
├── css/
├── img/
├── js/
├── payment/
├── vendor/
│
├── index.php
├── login.php
├── signup.php
├── myaccount.php
├── myorder.php
├── foods.php
├── payment.php
├── reports.php
├── sendEmail.php
├── dbcon.php
├── dbfoods.sql
└── README.md
```

---

## Technology Stack

| Layer | Technology |
|-------|------------|
| Frontend | HTML5, CSS3, Bootstrap, JavaScript |
| Backend | PHP |
| Database | MySQL |
| Payment | PayPal API |
| Email | PHPMailer |
| Server | Apache (InfinityFree / XAMPP) |

---

## Main Modules

### User Module
- Register
- Login
- Browse meals
- Shopping cart
- Place orders
- View order history

### Restaurant Module
- Add meals
- Manage food items
- View orders
- Generate reports

### Admin Module
- Manage users
- Manage restaurants
- View reports
- Monitor system activities

---

## Enterprise Features

- Responsive Web Design using Bootstrap.
- Secure online payments with PayPal API.
- Email notifications using PHPMailer.
- Google Sign-In integration.
- Sales and order reporting.
- Loyalty reward system.

---

## Database

The project uses a MySQL database named:

```
dbfoods
```

Import the included SQL file before running the project:

```
dbfoods.sql
```

---

## Setup

1. Import the database:
```
dbfoods.sql
```

2. Update database credentials inside:

```
dbcon.php
```

3. Upload the project files to:

```
htdocs/
```

or

```
public_html/
```

4. Open the website in your browser.

---

## Team

Developed as a graduation project.

**Project Name:** REPLATE

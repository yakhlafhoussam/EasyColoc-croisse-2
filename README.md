# 🏠 Colocation Management System — README

## 📌 Project Overview

The **Colocation Management System** is a web application designed to manage shared housing between roommates.
It helps users organize colocations, manage members, track shared expenses, validate payments, and rate roommates.

This project is developed using:

* **Laravel**
* **Docker**
* **PostgreSQL**
* **Tailwind CSS**
* **MVC Architecture**

---

## 🎯 Project Objectives

The platform allows users to:

* Create and manage colocations
* Invite members via email
* Manage shared expenses
* Confirm payments between roommates
* Rate members inside a colocation
* Maintain transparent financial tracking

---

## 👤 User Roles

* **Owner** → Creates and manages a colocation.
* **Member** → Participates in expenses and payments.

Ownership is handled through the **membership role** inside the members table.

---

## ⚙️ Main Features

### ✅ Authentication & Profile

* Register & Login
* Profile management
* Upload profile image
* Personal information update

### 🏠 Colocation Management

* Create colocation
* Define maximum members
* Manage colocation status
* Owner defined via membership role

### 👥 Membership Management

* Join / leave colocation
* Role system:

  * owner
  * member
* Join and leave history

### 💸 Expenses Management

* Add shared expenses
* Categorize expenses
* Track payer
* Expense history

### 💳 Payments

* Member-to-member payments
* Receiver confirmation
* Payment status validation

### ⭐ Rating System

* Rate roommates
* Star rating system
* Feedback description

### ✉️ Invitation System

* Send invitation by email
* Invitation expiration date
* Accept or reject invitation

---

## 🗄️ Database Structure

### Tables

* users
* colocations
* members
* categories
* expenses
* payments
* ratings
* invitations

Laravel automatically generates:

* `id`
* `created_at`
* `updated_at`

(Optional)

* `deleted_at` using Soft Deletes

---

## 📊 UML Diagrams

### 🧩 Use Case Diagram

![use case diagram](/uml/usecase.png)


---

### 🏗️ Class Diagram

📷 *(Insert Class Diagram image here)*

![Class Diagram](/uml/class.png)


---

## 🐳 Project Execution Using Docker

### 📦 Services

The project runs using Docker containers:

* **PHP / Laravel**
* **PostgreSQL Database**
* **Pgadmin**
* **puml**

---

### 1️⃣ Clone Repository

```bash
git clone https://github.com/yakhlafhoussam/EasyColoc-croisse-2.git
cd EasyColoc
```

---

### 2️⃣ Start Docker Containers

```bash
docker compose up -d --build
```

---

### 3️⃣ Enter Laravel Container

```bash
docker compose exec php sh
```

---

### 4️⃣ Install Dependencies

```bash
composer install
```

---

### 5️⃣ Environment Configuration

```bash
cp .env.example .env
php artisan key:generate
```

Configure database credentials according to Docker service names.

Example:

```
DB_HOST=postgres
DB_PORT=5432
```

---

### 6️⃣ Run Migrations

```bash
php artisan migrate
```

(Optional)

```bash
php artisan db:seed
```

---

### 7️⃣ Run Laravel Server

Laravel server runs automatically from Docker configuration.

Application available at:

```
http://localhost:9090
```

---

## 🔐 Security

* Password hashing
* Middleware authorization
* Form Request validation
* Payment confirmation protection

---

## 🚀 Future Improvements

* Notifications system
* Dashboard statistics
* Expense analytics
* Mobile responsiveness improvements

---

## 👨‍💻 Author

**Houssam Yk**
Full Stack Web Developer — YouCode Safi

---

## 📄 License

Educational project developed within training context.

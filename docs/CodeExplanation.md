# Project Code Explanation
## Agriculture Equipment Rental System (AERS)

This document provides a technical walkthrough of the project code, designed to help you understand how the system works under the hood. This is ideal for explaining the project during presentations or vivas.

### 1. Project Architecture

The project follows a **Model-View-Controller (MVC)** inspired architecture, adapted for Core PHP.

-   **Model (`backend/models`)**: Handles direct database interactions (SQL queries).
-   **View (`frontend/pages`)**: The user interface (HTML/PHP pages).
-   **Controller (`backend/controllers`)**: Processing logic, handling form submissions, and directing data between Models and Views.

### 2. Directory Structure

```
/agriculture-equipment-rental
├── backend/                # Server-side logic
│   ├── config/             # Configuration files
│   │   └── db.php          # Database connection (PDO)
│   ├── controllers/        # Business logic
│   │   ├── AuthController.php      # Login/Register logic
│   │   ├── BookingController.php   # Booking management
│   │   └── EquipmentController.php # Equipment CRUD
│   ├── models/             # Database Classes
│   │   ├── User.php
│   │   ├── Equipment.php
│   │   └── Booking.php
│   └── ...
├── database/               # SQL scripts
│   └── schema.sql          # Database table definitions
├── docs/                   # Documentation
├── frontend/               # Client-side code
│   ├── assets/             # CSS, Images, JS
│   ├── includes/           # Reusable components (Header, Footer)
│   └── pages/              # Web pages using the backend
│       ├── auth/           # Login/Register pages
│       ├── farmer/         # Farmer specific pages
│       ├── owner/          # Owner specific pages
│       └── admin/          # Admin specific pages
├── index.php               # Landing Page
└── setup_admin.php         # Utility to create admin user
```

### 3. Key Files Explained

#### Backend (The Brain)

**1. `backend/config/db.php`**
-   **Purpose**: Establishes the connection to the MySQL database.
-   **Key Code**: Uses `PDO` (PHP Data Objects) for secure database access, preventing SQL Injection.

**2. `backend/models/User.php`**
-   **Purpose**: Manages user data.
-   **Key Functions**:
    -   `register()`: Hashes the password (`password_hash`) and saves the user.
    -   `login()`: Verifies the email and checks the password (`password_verify`).

**3. `backend/controllers/AuthController.php`**
-   **Purpose**: Handles the logic when a user submits a login or registration form.
-   **process**:
    1.  Receives `POST` data from the form.
    2.  Sanitizes input (security).
    3.  Calls `User` model to save/check data.
    4.  Starts a `session` to keep the user logged in.
    5.  Redirects to the appropriate Dashboard.

#### Frontend (The Face)

**1. `frontend/includes/header.php`**
-   **Purpose**: Prevents code duplication. Contains the Navigation Bar.
-   **Smart Logic**: It checks `$_SESSION['role']` to decide whether to show "Login" links or "Dashboard/Logout" links.

**2. `frontend/pages/farmer/browse_equipment.php`**
-   **Purpose**: Allows farmers to search for machines.
-   **Key Code**: Fetches equipment data using `EquipmentController` and displays it in a loop using HTML Cards.

**3. `frontend/pages/auth/login.php`**
-   **Purpose**: The login form.
-   **Action**: Submits data to `backend/controllers/user_actions.php` (which uses `AuthController`).

### 4. Database Schema (`database/schema.sql`)

-   **users**: Stores basic info and `role` (farmer/owner/admin).
-   **equipment**: Stores machine details, related to an `owner_id`.
-   **bookings**: Connects a `farmer_id` and `equipment_id` with dates and `status` (pending/approved).

### 5. How a Booking Works (End-to-End)

1.  **Farmer** clicks "Book" on `details.php`.
2.  Form sends dates to `backend/controllers/booking_actions.php`.
3.  **Controller** verifies the user is logged in.
4.  **Controller** calls `Booking->create()`.
5.  **Model** runs `INSERT INTO bookings ...`.
6.  **Owner** sees the booking in `owner/booking_requests.php`.
7.  **Owner** clicks "Approve".
8.  **Controller** runs `UPDATE bookings SET status='approved'`.
9.  **Farmer** sees contact details on their dashboard.

### 6. Security Features

-   **Password Hashing**: Passwords are never stored as plain text.
-   **Session Management**: Pages check if a user is logged in before showing private data.
-   **Input Sanitization**: Prevents malicious scripts from being entered into forms.
-   **Config Protection**: The `.htaccess` file prevents anyone from reading database credentials.

# Project Setup Guide

This guide provides step-by-step instructions to set up the **Agriculture Equipment Rental System** on a new computer (e.g., a client's laptop).

## 1. Prerequisites (Software Required)

Before starting, ensure the following software is installed on the computer:

*   **XAMPP**: This serves as the local server (Apache) and database (MySQL).
    *   Download from: [https://www.apachefriends.org/download.html](https://www.apachefriends.org/download.html)
    *   Install with default settings (ensure Apache and MySQL are selected).
*   **Web Browser**: Chrome, Firefox, or Edge.
*   **Text Editor (Optional)**: VS Code or Notepad (for viewing code if needed).

---

## 2. Installation Steps

### Step 1: Start the Server
1.  Open the **XAMPP Control Panel**.
2.  Click **Start** next to **Apache**.
3.  Click **Start** next to **MySQL**.
4.  Ensure both turn green.

### Step 2: Deploy the Project Files
1.  Locate the XAMPP installation directory (usually `C:\xampp\`).
2.  Open the `htdocs` folder (`C:\xampp\htdocs\`).
3.  Copy the entire project folder `agriculture-equipment-rental` into `htdocs`.
    *   **CRITICAL**: The folder name **MUST** be exactly `agriculture-equipment-rental`.
    *   Final path should look like: `C:\xampp\htdocs\agriculture-equipment-rental\`

### Step 3: Setup the Database
1.  Open your web browser and go to: [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
2.  Click on **New** in the left sidebar.
3.  Create a database named: `agriculture_rental_db`
    *   *Note: This name matches the configuration in `backend/config/db.php`.*
4.  Select the newly created database (`agriculture_rental_db`) on the left.
5.  Click the **Import** tab in the top menu.
6.  Click **Choose File** and locate the SQL files in the project's `database` folder:
    *   First, select and import `schema.sql`.
    *   (Optional) Then, select and import `seed.sql` (if you want sample data).
    *   (Important) Then, select and import `create_admin.sql` (to create the admin account).
7.  Click **Go** at the bottom to execute the import for each file.

---

## 3. Configuration (If needed)

The project comes pre-configured for a standard XAMPP setup.

*   **Database Credentials**:
    *   File: `backend/config/db.php`
    *   Default User: `root`
    *   Default Password: (empty)
    *   *If your XAMPP installation has a password for root, you must edit this file to match.*

---

## 4. Running the Application

1.  Open your web browser.
2.  Visit: [http://localhost/agriculture-equipment-rental](http://localhost/agriculture-equipment-rental)
3.  You should see the Home Page.

### Admin Login
*   **URL**: [http://localhost/agriculture-equipment-rental/frontend/pages/auth/login.php](http://localhost/agriculture-equipment-rental/frontend/pages/auth/login.php)
*   **Email**: `admin@aers.com`
*   **Password**: `admin123`

---

## Troubleshooting

*   **"Database Connection Failed"**:
    *   Ensure MySQL is running in XAMPP.
    *   Check if the database name in phpMyAdmin matches `agriculture_rental_db`.
    *   Check if `backend/config/db.php` has the correct username/password.

*   **"Object not found" or 404 Errors**:
    *   Ensure the project folder in `htdocs` is named exactly `agriculture-equipment-rental`.
    *   The application uses hardcoded paths like `/agriculture-equipment-rental/...`, so renaming the folder will break links.

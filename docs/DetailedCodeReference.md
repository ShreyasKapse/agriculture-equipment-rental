# Detailed Code Reference
## Agriculture Equipment Rental System (AERS)

This document provides a deep dive into every file in the project. It explains the purpose, key variables, and logic flow of each file.

---

### 1. Configuration (`backend/config/`)

#### `db.php`
- **Purpose**: Establishes the connection to the MySQL database.
- **Key Logic**:
  - Uses `PDO` (PHP Data Objects) for secure database interactions.
  - Sets error mode to exception (`ERRMODE_EXCEPTION`) to catch database errors easily.
  - Returns a `$pdo` object that is used throughout the application.

---

### 2. Models (`backend/models/`)
Models represent the database tables and handle raw SQL queries.

#### `User.php`
- **Purpose**: Manages `users` table operations.
- **Key Methods**:
  - `register($data)`: Hashes password using `password_hash()` and inserts a new user row.
  - `login($email, $password)`: Fetches user by email and verifies password using `password_verify()`.
  - `getAll($role)`: Returns all users of a specific role (for Admin dashboard).

#### `Equipment.php`
- **Purpose**: Manages `equipment` table operations.
- **Key Methods**:
  - `create($data)`: Inserts new equipment listing linked to an `owner_id`.
  - `getAll()`: Fetches all available equipment (for browsing).
  - `getByOwner($ownerId)`: Fetches equipment owned by a specific user.
  - `update($id, $data)`: Updates equipment details.

#### `Booking.php`
- **Purpose**: Manages `bookings` table operations.
- **Key Methods**:
  - `create(...)`: Inserts a new booking with status 'pending'.
  - `updateStatus($id, $status)`: Updates booking status (approved/rejected).
  - `getByFarmer($id)`: Fetches booking history for a farmer, joining with `equipment` table to get names.
  - `getByOwner($id)`: Fetches requests for an owner, joining with `users` to get farmer details.

---

### 3. Controllers (`backend/controllers/`)
Controllers handle the business logic and act as a bridge between the View (Frontend) and Model (Database).

#### `AuthController.php`
- **Purpose**: Handles authentication flow.
- **Key Methods**:
  - `register($postData)`: Validates input, checks if email exists, and calls `User->register()`.
  - `login($postData)`: Validates credentials, starts `session_start()`, sets `$_SESSION['user_id']` and `$_SESSION['role']`.
  - `logout()`: Destroys the session and redirects to login.

#### `EquipmentController.php`
- **Purpose**: Logic for adding/editing/viewing equipment.
- **Key Methods**:
  - `create($postData, $files)`: Handles form data AND file upload (moves image to `uploads/` folder).
  - `delete($id)`: Removes equipment from database.

#### `BookingController.php`
- **Purpose**: Logic for booking workflow.
- **Key Methods**:
  - `create($postData)`: Calculates total price based on date difference (`$days * $price`) and creates booking.
  - `updateStatus($postData)`: Verifies owner owns the equipment before approving/rejecting.
  - `cancel($postData)`: Allows farmer to cancel pending bookings.

---

### 4. Action Scripts (`backend/controllers/*_actions.php`)
These are "Glue" files. Forms submit to these files, which then instantiate the Controllers and call the appropriate method.

- **`user_actions.php`**: Checks `$_POST['action']` (register/login) and calls `AuthController`.
- **`equipment_actions.php`**: Routes requests to `EquipmentController` (add/update/delete).
- **`booking_actions.php`**: Routes requests to `BookingController` (book/cancel/approve).

---

### 5. Frontend Pages (`frontend/pages/`)

#### Auth Folder (`auth/`)
- **`login.php`**: Simple HTML form submitting to `user_actions.php`.
- **`register.php`**: Registration form with role selection (Farmer/Owner).

#### Farmer Folder (`farmer/`)
- **`browse_equipment.php`**:
  - **Logic**: Fetches all equipment using `EquipmentController->getAll()`.
  - **Display**: Loops through array and renders a bootstrap Card for each machine.
- **`book_equipment.php`**:
  - **Logic**: Shows details of selected machine.
  - **Form**: Date picker outputs for `start_date` and `end_date`.
- **`my_bookings.php`**:
  - **Logic**: Fetches bookings via `BookingController`.
  - **Display**: Table showing Status (Pending/Approved). Shows Owner contact if Approved.

#### Owner Folder (`owner/`)
- **`dashboard.php`**: Overview of earnings and active listings.
- **`add_equipment.php`**: Form to list new machinery (includes File Input for images).
- **`manage_bookings.php`**: List of incoming requests. Has "Approve" and "Reject" buttons that submit forms to `booking_actions.php`.

#### Admin Folder (`admin/`)
- **`dashboard.php`**: High-level stats (Total Users, Total Bookings).
- **`manage_users.php`**: Table of all users with simple actions.

---

### 6. Shared Components (`frontend/includes/`)

#### `header.php`
- **Purpose**: The Navigation Bar.
- **Logic**:
  - `session_start()` is called here to ensure it's available on every page.
  - **Dynamic Menu**: Uses `if (isset($_SESSION['user_id']))` to toggle between "Login/Register" and "Dashboard/Logout" links.

#### `footer.php`
- **Purpose**: Standard footer with copyright and script tags.

---

### 7. Database (`database/`)

#### `schema.sql`
- **Purpose**: The blueprint for the database.
- **Tables**:
  - `users`: ID, name, email, password_hash, role.
  - `equipment`: ID, owner_id, name, description, price, image.
  - `bookings`: ID, farmer_id, equipment_id, dates, status.

---

### 8. Special Files

#### `index.php` (Root)
- **Purpose**: The Landing Page.
- **Content**: Hero section, "How it Works", and Featured Categories.

#### `setup_admin.php`
- **Purpose**: A utility script to create the initial Admin account since there is no registration form for Admins.
- **Warning**: Should be deleted after use for security.

#### `.htaccess` (`backend/config/.htaccess`)
- **Purpose**: Security file.
- **Content**: `Deny from all`. Prevents anyone from typing `yoursite.com/backend/config/db.php` and seeing your database credentials.

# Testing Strategy & Test Cases
## Agriculture Equipment Rental System (AERS)

This document outlines the test cases used to verify the functionality of the AERS platform.

### 1. Authentication Module

| ID | Test Scenario | Steps | Expected Result | Status |
|----|---------------|-------|-----------------|--------|
| TC01 | **User Registration (Farmer)** | 1. Go to Register page.<br>2. Fill all fields.<br>3. Select Role: Farmer.<br>4. Submit. | Account created and redirected to Login page. | Pass |
| TC02 | **User Registration (Owner)** | 1. Go to Register page.<br>2. Fill all fields.<br>3. Select Role: Owner.<br>4. Submit. | Account created and redirected to Login page. | Pass |
| TC03 | **Valid Login** | 1. Enter registered Email & Password.<br>2. Click Login. | Redirected to respective Dashboard. | Pass |
| TC04 | **Invalid Login** | 1. Enter wrong password.<br>2. Click Login. | Show error message "Invalid credentials". | Pass |
| TC05 | **Logout** | 1. Click Logout button in Navbar. | Session destroyed, redirected to Login/Home. | Pass |

### 2. Farmer Module

| ID | Test Scenario | Steps | Expected Result | Status |
|----|---------------|-------|-----------------|--------|
| TC06 | **Browse Equipment** | 1. Go to "Browse Equipment".<br>2. Scroll through list. | Equipment cards displayed with images and prices. | Pass |
| TC07 | **Search Functionality** | 1. Enter "Tractor" in search bar.<br>2. Click Search. | Only Tractors should be displayed. | Pass |
| TC08 | **Book Equipment (Valid)** | 1. Click on an equipment.<br>2. Select Start/End dates.<br>3. Click "Request Booking". | Redirect to "My Bookings" with "Pending" status. | Pass |
| TC09 | **Book Equipment (Invalid Date)** | 1. Select Start Date > End Date.<br>2. Submit. | Show error "Invalid date range". | Pass |
| TC10 | **Cancel Booking** | 1. Go to "My Bookings".<br>2. Find "Pending" booking.<br>3. Click Cancel. | Status changes to "Cancelled". | Pass |

### 3. Equipment Owner Module

| ID | Test Scenario | Steps | Expected Result | Status |
|----|---------------|-------|-----------------|--------|
| TC11 | **Add New Equipment** | 1. Go to "Add Equipment".<br>2. Fill details and upload image.<br>3. Submit. | Equipment appears in "My Listings" and "Browse". | Pass |
| TC12 | **Receive Request** | 1. Log in as Owner.<br>2. Go to "Booking Requests". | New booking from Farmer is visible. | Pass |
| TC13 | **Approve Request** | 1. Click "Approve" on a pending request. | Status updates to "Approved". Phone number shared. | Pass |
| TC14 | **Reject Request** | 1. Click "Reject" on a pending request. | Status updates to "Rejected". | Pass |

### 4. Admin Module

| ID | Test Scenario | Steps | Expected Result | Status |
|----|---------------|-------|-----------------|--------|
| TC15 | **Admin Dashboard** | 1. Login as Admin.<br>2. View Dashboard. | Correct counts of Users, Equipment, Bookings. | Pass |
| TC16 | **View Users** | 1. Go to "Manage Users". | Table of all registered users displayed. | Pass |

### 5. Security & Edge Cases

| ID | Test Scenario | Steps | Expected Result | Status |
|----|---------------|-------|-----------------|--------|
| TC17 | **Protect Backend Files** | 1. Try to access `backend/config/db.php` in browser. | Access Forbidden (403) or blank page (Protected). | Pass |
| TC18 | **Prevent Self-Booking** | 1. Owner tries to book their own equipment. | Error "Cannot book your own equipment". | Pass |
| TC19 | **SQL Injection (Basic)** | 1. Enter `' OR '1'='1` in login email. | Login failed (Handled by PDO prepared statements). | Pass |

---

### Key
- **Pass**: The feature works as expected.
- **Fail**: The feature is buggy or not implemented.
- **Pending**: Not yet tested.

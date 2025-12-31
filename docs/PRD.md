📄 Product Requirements Document (PRD)
🌾 Agriculture Equipment Rental System (AERS)
1. Introduction

The Agriculture Equipment Rental System (AERS) is a web-based platform designed to connect farmers who need agricultural equipment with equipment owners who are willing to rent their machinery.

This project is being developed as a final year diploma project for students and also as a real-world client solution aimed at solving accessibility and affordability issues in rural agriculture.

Traditionally, many farmers cannot afford expensive machinery such as tractors, harvesters, or rotavators. At the same time, many farmers and equipment owners have idle machinery that remains unused for long periods. This system bridges that gap by providing a digital rental marketplace.

The platform enables:

Farmers to browse, book, and rent equipment

Equipment owners to list machinery and earn rental income

Administrators to monitor, control, and manage the platform

The system uses a Three-Tier Architecture and is implemented using HTML, CSS, JavaScript, PHP, and MySQL, ensuring simplicity, affordability, and easy deployment in academic environments.

2. Problem Statement

Agricultural equipment is expensive and inaccessible to small-scale farmers.

Farmers lack a centralized platform to find nearby equipment.

Equipment owners struggle to find customers efficiently.

Existing solutions are either offline, unorganized, or costly.

3. Objectives & Goals
Primary Goals

Enable affordable access to agricultural machinery.

Allow equipment owners to earn additional income.

Provide a transparent and secure rental process.

Secondary Goals

Digitize agricultural rentals.

Improve efficiency in farming operations.

Create a scalable platform for future enhancements.

4. Target Users & Personas
👨‍🌾 Farmer (Customer)

Needs equipment for short-term agricultural tasks

Price-sensitive

Requires simple and clear UI

🚜 Equipment Owner

Owns one or more machines

Wants to monetize unused equipment

Needs control over approvals and availability

🛠 Admin

Oversees platform operations

Manages users, equipment, and bookings

Ensures data integrity and security

5. Scope of the Product
In Scope (Current Project)

User authentication

Equipment listing

Booking system

Role-based dashboards

Admin monitoring

Out of Scope (Future)

Mobile apps

AI recommendations

GPS tracking

Government scheme APIs

6. User Stories
👨‍🌾 Farmer User Stories

Register and log in securely

View available equipment

Search equipment by category

View price, availability, and owner details

Book equipment by paying 10% advance

Track booking status

View booking history

Contact equipment owner

Make online payments (future)

🚜 Equipment Owner User Stories

Register and log in

Add, update, and delete equipment

Upload equipment images

View booking requests

Approve or reject bookings

View rental history and income

🛠 Admin User Stories

Secure admin login

Manage farmers and owners

Approve or remove equipment

Monitor bookings

Generate usage reports

Analyze demand trends

7. Functional Requirements
7.1 Authentication & Authorization

Secure login & registration

Role-based access control

Encrypted passwords

Session management

7.2 Equipment Management

Add/edit/delete equipment

Upload images

Set price per day/hour

Availability toggle

7.3 Booking Management

Select rental dates

Automatic cost calculation

10% advance booking

Booking status workflow:

Pending → Approved / Rejected

7.4 Payment Management

Advance payment record

Payment status tracking

Payment method storage

7.5 Admin Management

User moderation

Equipment verification

Booking monitoring

Basic reporting

8. Non-Functional Requirements

Performance: Page load < 3 seconds

Security: Encrypted passwords, validated inputs

Scalability: Modular codebase

Usability: Simple UI for rural users

Reliability: Consistent booking & payment records

9. System Architecture
🧠 Architecture Pattern

Three-Tier Architecture

Frontend (HTML, CSS, JS)
        ↓
Backend (PHP)
        ↓
Database (MySQL)

10. Component Architecture
10.1 Frontend Components

Pages

Home

Login / Register

Equipment Listing

Booking Page

Farmer Dashboard

Owner Dashboard

Admin Dashboard

Responsibilities

Form validation

Display data

Send API requests

Navigation handling

10.2 Backend Components

Modules

Authentication Module

User Management

Equipment Management

Booking Management

Admin Control Module

Technology

Core PHP

Apache Server (XAMPP)

10.3 Database Components
Tables

users

equipment

bookings

payments

reviews

Relationships

One Owner → Many Equipment

One Farmer → Many Bookings

One Equipment → Many Bookings

11. Data Models

(Your models are correct and retained; only cleaned conceptually)

Users: farmer / owner / admin

Equipment: owner-linked machinery

Bookings: rental lifecycle

Payments: advance & status

Reviews: feedback & ratings

12. MVP Definition
MVP Features

Login & registration

Equipment listing

Booking request

Owner approval

Admin monitoring

Excluded from MVP

Full payment gateway

Location services

Mobile app

AI & IoT

13. Simple UI Prototypes

(Text-based prototypes retained for diploma submission)

Home Page

Login/Register

Equipment Listing

Booking Page

Owner Dashboard

Admin Dashboard

14. Tech Stack
Frontend

HTML5

CSS3

Bootstrap 5

JavaScript

Backend

PHP (Core PHP)

Database

MySQL

Server & Tools

XAMPP

Apache

phpMyAdmin

Git (Version Control)

15. Security Requirements

Password hashing

Role-based access

Input sanitization

Session timeout handling

16. Implementation Plan (Section-wise)

Project setup + Git repository

Database schema creation

Authentication module

Equipment module

Booking module

Owner dashboard

Admin dashboard

Testing & debugging

Documentation finalization

Each section will be:

Implemented

Tested

Debugged

Committed to Git

17. Testing Strategy

Unit testing per module

Manual UI testing

Edge case handling:

Double booking

Payment failure

Invalid login

Final system testing

18. Documentation Structure
/docs
 ├── PRD.md
 ├── Architecture.md
 ├── Database.md
 ├── API.md
 ├── Testing.md
 └── UserManual.md

19. Future Enhancements

Mobile application

Online payment gateway

Multi-language support

Location-based search

AI demand prediction

IoT equipment tracking

Government scheme integration

20. Success Metrics

Number of active users

Successful bookings

Owner earnings

System uptime

User satisfaction
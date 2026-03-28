
===========================================================
BLOG MANAGEMENT SYSTEM (Raw PHP & MySQL)
===========================================================

1. PROJECT OVERVIEW
-------------------
A lightweight, secure Blog Management System built with Raw PHP 
and MySQL. Features include user authentication, role management, 
image uploads, and a commenting system.

2. SYSTEM REQUIREMENTS
----------------------
- PHP 7.4 or higher
- MySQL / MariaDB
- Apache Server (XAMPP / WAMP / Laragon)

3. INSTALLATION STEPS
---------------------
Step 1: Database Setup
- Open phpMyAdmin (http://localhost/phpmyadmin).
- Create a new database named: blog_system
- Import the 'database.sql' file provided (or copy-paste the SQL code 
  found in the documentation).

Step 2: File Placement
- Copy all project files into your server's root directory:
  (e.g., C:/xampp/htdocs/blog-system/)

Step 3: Configuration
- Open 'db.php' and update the credentials ($host, $user, $pass) 
  if they differ from your local setup.

Step 4: Permissions
- Ensure the 'uploads/' folder has write permissions so users 
  can upload blog images.

4. USER ROLES
-------------
- Admin: Can manage all content (setup via DB 'role' column).
- User: Default role. Can create, edit, and view their own blogs 
  and comment on others.

5. FILE STRUCTURE
-----------------
- db.php            : Database connection & Session start
- register.php      : User account creation
- login.php         : Secure login portal
- logout.php        : Session termination
- dashboard.php     : User's private blog management area
- create_blog.php   : Interface to add new posts with images
- edit_blog.php     : Interface to update existing posts
- view_blog.php     : Detailed post view with commenting system
- uploads/          : Storage for blog images
- database schema   : it's the sql command 
===========================================================
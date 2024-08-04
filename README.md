# School Assignment: Sales and Client Management System Website

## Project Overview

This project is a web-based application designed to manage sales and client information. It includes various modules for user authentication, managing client data, recording calls, and more. The project utilizes PHP for the backend and MySQL for database management, with the frontend styled using Bootstrap and custom CSS. JavaScript, including jQuery and DataTables, is used for client-side scripting to enhance interactivity. The application also incorporates HTML for structure and CSS for styling, ensuring a responsive and user-friendly interface. Additionally, it features comprehensive policies such as privacy policy, cookie policy, and acceptable use policy.

## Features and Functionality 
* **User Authentication:** Sign-in, reset password, and change password functionalities.
* **Client Management:** Add, edit, and delete client information
* **Sales Management:** Record and manage sales data.
* **Call Management:** Log and track calls with clients
* **Dashboard:** Overview of key metrics and quick access to various features.
* **Policies:** Display privacy policy, cookie policy, and acceptable use policy.

Created an interactive, secure and database driven web site that will allow clients to: register, update, authenticate, maintain state using sessions/cookies, upload and manage remote files, create/send email notifications, search and display records from a database.

Initial DB Setup, Site Constants, State Maintenance, Dynamic Nav, and Secure Login Functionality including Web Logging, User Registration/Update, and Database Creation/Population, Record Searching/Displaying, File Upload and Password Update, User Communication, Admin Authentication, Site Administration and Website Policies.



## File Structure
### Root Directory

* **index.php** - The main landing page.
* **logout.php** - Handles user logout functionality.
* **README.md** - This file.
* **reset.php** - Handles password reset functionality.
* **sign-in.php** - Handles user sign-in.
* **dashboard.php** - The main dashboard.

### SQL Folder

* **sql/calls.sql** - SQL script for the calls table.
* **sql/clients.sql** - SQL script for the clients table.
* **sql/users.sql** - SQL script for the users table.


### Includes Folder

* **includes/constants.php** - Defines constants used across the project.
* **includes/db.php** - Database connection file.
* **includes/footer.php** - Footer component.
* **includes/functions.php** - Contains various helper functions.
* **includes/header.php** - Header component.

### Policies

* **PrivacyPolicy.php** - Displays the privacy policy.
* **AUP.php** - Displays the acceptable use policy.
* **CookiePolicy.php** - Displays the cookie policy.
 
### Pages

* **salespeople.php** - Manages salespeople information.
* **calls.php** - Manages call records.
* **change-password.php** - Allows users to change their password.
* **clients.php** - Manages client information.

### CSS Folder

* **css/bootstrap.min.css** - Bootstrap CSS.
* **css/styles.css** - Custom styles.

### Logs
* **mail/mail.log** - Log file for mail activities.



## Usage

1. **User Sign-in:**
    * Users can sign in via the sign-in.php page.

2. **Dashboard**
    * After signing in, users are redirected to the dashboard.php where they can access various features.
3. **Manage Clients:**
    * Use clients.php to add, edit, and delete client information.

4. **Record Calls:**
    * Log calls with clients using calls.php

5. **Change Password:**
    * Users can change their password through the change-password.php page.

6. **Reset Password:**
    * Users can reset their password using the reset.php page.

7. **Manage Salespeople:**
    * Users can change their password through the change-password.php page.

8. **Policies**
    * Access privacy, cookie, and acceptable use policies through their respective PHP files.




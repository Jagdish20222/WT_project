<?php
/**
 * init_db.php
 * Database Initialization Script
 * 
 * Purpose: Creates database and users table for the project
 * Run this file ONCE before using the application
 * URL: http://localhost/Project__/init_db.php
 * 
 * Creates:
 * - Database: wt_project_db
 * - Table: users (id, name, email, password, created_at)
 */

$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'wt_project_db';

// Connect to MySQL server (no database selected yet)
$conn = mysqli_connect($host, $user, $password);

if (!$conn) {
    die('<div style="padding:2rem;background:#fee2e2;color:#991b1b;border-radius:8px;margin:2rem;font-family:Arial">
         <h3>❌ MySQL Connection Failed</h3>
         <p>Error: ' . htmlspecialchars(mysqli_connect_error(), ENT_QUOTES, 'UTF-8') . '</p>
         <p>Please ensure XAMPP MySQL service is running.</p>
         </div>');
}

// Create database if it doesn't exist
$sqlCreateDb = "CREATE DATABASE IF NOT EXISTS $dbname CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";

if (!mysqli_query($conn, $sqlCreateDb)) {
    die('<div style="padding:2rem;background:#fee2e2;color:#991b1b;border-radius:8px;margin:2rem;font-family:Arial">
         <h3>❌ Database Creation Failed</h3>
         <p>Error: ' . htmlspecialchars(mysqli_error($conn), ENT_QUOTES, 'UTF-8') . '</p>
         </div>');
}

// Select the newly created database
mysqli_select_db($conn, $dbname);

// Create users table with proper structure
$sqlCreateTable = "CREATE TABLE IF NOT EXISTS users (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if (!mysqli_query($conn, $sqlCreateTable)) {
    die('<div style="padding:2rem;background:#fee2e2;color:#991b1b;border-radius:8px;margin:2rem;font-family:Arial">
         <h3>❌ Table Creation Failed</h3>
         <p>Error: ' . htmlspecialchars(mysqli_error($conn), ENT_QUOTES, 'UTF-8') . '</p>
         </div>');
}

// Close connection
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Initialized</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>✅ Database Initialized Successfully</h2>
            <div class="message success">
                <p><strong>Database Created:</strong> <?php echo htmlspecialchars($dbname, ENT_QUOTES, 'UTF-8'); ?></p>
                <p><strong>Table Created:</strong> users</p>
                <p>Your project database is ready to use!</p>
            </div>
            <div class="text-center mt-2">
                <a href="users_index.php" class="btn btn-primary">Go to User Management</a>
                <a href="index.html" class="btn btn-secondary">Back to Home</a>
            </div>
        </div>
    </div>
</body>
</html>
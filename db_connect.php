<?php
/**
 * db_connect.php
 * Database Connection File
 * 
 * Purpose: Establishes a mysqli connection to MySQL database
 * Used by: All PHP files requiring database access
 * Database: wt_project_db (Web Technology Project Database)
 * 
 * Note: This file does not echo messages to allow clean HTML output
 * Connection errors will terminate execution with a friendly message
 */

// Database Configuration - XAMPP default settings
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'wt_project_db');

// Establish connection to MySQL server and select database
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check if connection was successful
if (!$conn) {
    // Connection failed - display error and stop execution
    die("<div style='font-family: Arial, sans-serif; padding: 2rem; background: #fee2e2; color: #991b1b; border-radius: 8px; max-width: 600px; margin: 2rem auto;'>
        <h3 style='margin-top: 0;'>❌ Database Connection Failed</h3>
        <p><strong>Error:</strong> " . htmlspecialchars(mysqli_connect_error(), ENT_QUOTES, 'UTF-8') . "</p>
        <p>Please ensure:</p>
        <ul>
            <li>XAMPP MySQL service is running</li>
            <li>Database 'wt_project_db' exists (run init_db.php first)</li>
            <li>Database credentials are correct</li>
        </ul>
        </div>");
}

// Set character encoding to UTF-8 for proper international character support
mysqli_set_charset($conn, 'utf8mb4');

// Connection successful - $conn is now available for database operations
// No echo here to keep included pages clean
?>

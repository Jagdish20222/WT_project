<?php
/**
 * setup_db.php
 * One-time setup script to create database and students table
 * 
 * Purpose: Creates the crud_db database and students table with required fields
 * Usage: Run once from browser (http://localhost/Project__/setup_db.php)
 * After running, you can use the CRUD operations
 */

// Connect to MySQL server without selecting a database
$conn = mysqli_connect('localhost', 'root', '');

if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}

// Step 1: Create database if it doesn't exist
$createDB = "CREATE DATABASE IF NOT EXISTS crud_db CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci";
if (mysqli_query($conn, $createDB)) {
    $dbMessage = "✓ Database 'crud_db' created or already exists.";
} else {
    die("Error creating database: " . mysqli_error($conn));
}

// Step 2: Select the database
mysqli_select_db($conn, 'crud_db');

// Step 3: Create students table with required fields
$createTable = "CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if (mysqli_query($conn, $createTable)) {
    $tableMessage = "✓ Table 'students' created or already exists.";
} else {
    die("Error creating table: " . mysqli_error($conn));
}

// Step 4: Insert sample data for testing (optional)
$sampleData = [
    ['John Doe', 'john@example.com', 'john123'],
    ['Jane Smith', 'jane@example.com', 'jane456'],
    ['Alex Kumar', 'alex@example.com', 'alex789']
];

$insertCount = 0;
$stmt = mysqli_prepare($conn, 'INSERT INTO students (name, email, password) VALUES (?, ?, ?)');

foreach ($sampleData as $student) {
    mysqli_stmt_bind_param($stmt, 'sss', $student[0], $student[1], $student[2]);
    // Use @ to suppress duplicate key warnings
    if (@mysqli_stmt_execute($stmt)) {
        $insertCount++;
    }
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Setup Complete</title>
    <link rel="stylesheet" href="crud_styles.css">
</head>
<body>
    <div class="container" style="max-width: 600px; margin: 3rem auto; text-align: center;">
        <h1 style="color: #2575fc;">✓ Setup Complete</h1>
        <div style="background: #f0fdf4; border-left: 4px solid #16a34a; padding: 1rem; margin: 1rem 0; text-align: left;">
            <p><?php echo $dbMessage; ?></p>
            <p><?php echo $tableMessage; ?></p>
            <p>✓ Inserted <?php echo $insertCount; ?> sample record(s).</p>
        </div>
        <p>Your database is ready for CRUD operations!</p>
        <a href="crud_index.php" class="btn">Go to CRUD Dashboard</a>
    </div>
</body>
</html>

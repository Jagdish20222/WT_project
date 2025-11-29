<?php

require_once 'config.php';

// Initialize variables for form data and messages
$name = $email = $password = '';
$errors = [];
$success = '';

// Process form submission - INSERT operation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Step 1: Collect and sanitize input data
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Step 2: Server-side validation
    if ($name === '') {
        $errors[] = 'Name is required.';
    }
    if ($email === '') {
        $errors[] = 'Email is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please provide a valid email address.';
    }
    if ($password === '') {
        $errors[] = 'Password is required.';
    } elseif (strlen($password) < 6) {
        $errors[] = 'Password must be at least 6 characters long.';
    }

    // Step 3: If no errors, perform INSERT operation
    if (empty($errors)) {
        // Use prepared statement to prevent SQL injection
        $stmt = mysqli_prepare($conn, 'INSERT INTO students (name, email, password) VALUES (?, ?, ?)');
        
        if ($stmt) {
            // Bind parameters: s = string type
            mysqli_stmt_bind_param($stmt, 'sss', $name, $email, $password);
            
            // Execute the INSERT query
            if (mysqli_stmt_execute($stmt)) {
                // Success - redirect to index page with success message
                mysqli_stmt_close($stmt);
                mysqli_close($conn);
                header('Location: crud_index.php?success=Student added successfully!');
                exit;
            } else {
                // Check if error is due to duplicate email (UNIQUE constraint)
                if (mysqli_errno($conn) === 1062) {
                    $errors[] = 'Email already exists. Please use a different email.';
                } else {
                    $errors[] = 'Database error: ' . mysqli_stmt_error($stmt);
                }
            }
            
            mysqli_stmt_close($stmt);
        } else {
            $errors[] = 'Failed to prepare statement: ' . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Student - INSERT Operation</title>
    <link rel="stylesheet" href="crud_styles.css">
</head>
<body>
    <div class="container">
        <a href="crud_index.php" class="back-link">← Back to Dashboard</a>
        
        <h1>Add New Student</h1>
        <p style="text-align: center; color: #64748b; margin-bottom: 1.5rem;">
            CREATE Operation - INSERT INTO students
        </p>

        <!-- Display validation errors -->
        <?php if (!empty($errors)): ?>
            <div class="message error">
                <strong>Please correct the following errors:</strong>
                <ul style="margin-left: 1.5rem; margin-top: 0.5rem;">
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Insert Form -->
        <form method="POST" action="insert.php">
            <label for="name">Name: <span style="color: red;">*</span></label>
            <input type="text" 
                   id="name" 
                   name="name" 
                   value="<?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>" 
                   required 
                   placeholder="Enter full name">

            <label for="email">Email: <span style="color: red;">*</span></label>
            <input type="email" 
                   id="email" 
                   name="email" 
                   value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>" 
                   required 
                   placeholder="student@example.com">

            <label for="password">Password: <span style="color: red;">*</span></label>
            <input type="password" 
                   id="password" 
                   name="password" 
                   required 
                   minlength="6"
                   placeholder="Minimum 6 characters">

            <div style="margin-top: 1.5rem; text-align: center;">
                <input type="submit" value="Add Student" class="btn-primary">
                <a href="crud_index.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>

        <!-- SQL Query Explanation for Journal -->
        <div style="margin-top: 2rem; padding: 1rem; background: #f8fafc; border-radius: 6px;">
            <h3 style="color: #475569; font-size: 1rem; margin-bottom: 0.5rem;">SQL Query Used:</h3>
            <code style="background: white; padding: 0.5rem; display: block; border-radius: 4px; font-size: 0.9rem;">
                INSERT INTO students (name, email, password) VALUES (?, ?, ?)
            </code>
            <p style="margin-top: 0.5rem; color: #64748b; font-size: 0.9rem;">
                Uses prepared statements to safely insert data and prevent SQL injection.
            </p>
        </div>
    </div>
</body>
</html>

<?php
// Close database connection
mysqli_close($conn);
?>

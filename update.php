<?php

require_once 'config.php';

// Initialize variables
$id = $name = $email = $password = '';
$errors = [];
$studentFound = false;

// Step 1: Get student ID from URL parameter
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Fetch existing student data to prefill the form - SELECT operation
    $stmt = mysqli_prepare($conn, 'SELECT id, name, email, password FROM students WHERE id = ?');
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($row = mysqli_fetch_assoc($result)) {
        // Student found - prefill form with existing data
        $studentFound = true;
        $name = $row['name'];
        $email = $row['email'];
        $password = $row['password'];
    }
    
    mysqli_stmt_close($stmt);
}

// If student not found, redirect to index with error
if (!$studentFound && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    mysqli_close($conn);
    header('Location: crud_index.php?error=Student not found.');
    exit;
}

// Step 2: Process form submission - UPDATE operation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Server-side validation
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
    if ($id <= 0) {
        $errors[] = 'Invalid student ID.';
    }

    // Step 3: If no errors, perform UPDATE operation
    if (empty($errors)) {
        // Use prepared statement for secure UPDATE query
        $stmt = mysqli_prepare($conn, 'UPDATE students SET name = ?, email = ?, password = ? WHERE id = ?');
        
        if ($stmt) {
            // Bind parameters: sss = 3 strings, i = 1 integer
            mysqli_stmt_bind_param($stmt, 'sssi', $name, $email, $password, $id);
            
            // Execute the UPDATE query
            if (mysqli_stmt_execute($stmt)) {
                // Check if any row was actually updated
                if (mysqli_stmt_affected_rows($stmt) > 0) {
                    mysqli_stmt_close($stmt);
                    mysqli_close($conn);
                    header('Location: crud_index.php?success=Student updated successfully!');
                    exit;
                } else {
                    // No changes made (same data submitted)
                    mysqli_stmt_close($stmt);
                    mysqli_close($conn);
                    header('Location: crud_index.php?success=No changes were made.');
                    exit;
                }
            } else {
                // Check if error is due to duplicate email
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
    <title>Update Student - UPDATE Operation</title>
    <link rel="stylesheet" href="crud_styles.css">
</head>
<body>
    <div class="container">
        <a href="crud_index.php" class="back-link">← Back to Dashboard</a>
        
        <h1>Update Student Record</h1>
        <p style="text-align: center; color: #64748b; margin-bottom: 1.5rem;">
            UPDATE Operation - Modify Existing Record (ID: <?php echo htmlspecialchars($id, ENT_QUOTES, 'UTF-8'); ?>)
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

        <!-- Update Form - Prefilled with existing data -->
        <form method="POST" action="update.php">
            <!-- Hidden field to pass student ID -->
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id, ENT_QUOTES, 'UTF-8'); ?>">

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
                   value="<?php echo htmlspecialchars($password, ENT_QUOTES, 'UTF-8'); ?>" 
                   required 
                   minlength="6"
                   placeholder="Minimum 6 characters">

            <div style="margin-top: 1.5rem; text-align: center;">
                <input type="submit" value="Update Student" class="btn-primary">
                <a href="crud_index.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>

        <!-- SQL Query Explanation for Journal -->
        <div style="margin-top: 2rem; padding: 1rem; background: #f8fafc; border-radius: 6px;">
            <h3 style="color: #475569; font-size: 1rem; margin-bottom: 0.5rem;">SQL Query Used:</h3>
            <code style="background: white; padding: 0.5rem; display: block; border-radius: 4px; font-size: 0.9rem;">
                UPDATE students SET name = ?, email = ?, password = ? WHERE id = ?
            </code>
            <p style="margin-top: 0.5rem; color: #64748b; font-size: 0.9rem;">
                Uses prepared statements to safely update data. The WHERE clause ensures only the specific record is modified.
            </p>
        </div>
    </div>
</body>
</html>

<?php
// Close database connection
mysqli_close($conn);
?>

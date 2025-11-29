<?php
// create_user.php
// Shows a form to create a user and handles form submission to insert into users table.

include_once 'db_connect.php'; // provides $conn

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if ($name === '') $errors[] = 'Name is required.';
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required.';
    if ($password === '' || strlen($password) < 6) $errors[] = 'Password must be at least 6 characters.';

    if (empty($errors)) {
        // Hash password
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = mysqli_prepare($conn, "INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'sss', $name, $email, $hash);
            if (mysqli_stmt_execute($stmt)) {
                $success = 'User created successfully.';
                // Clear form fields
                $name = $email = '';
            } else {
                $errors[] = 'Database error: ' . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt);
        } else {
            $errors[] = 'Prepare failed: ' . mysqli_error($conn);
        }
    }
}

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create User - Web Technology Project</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <div class="form-container">
      <h2>➕ Create New User</h2>

      <?php if (!empty($errors)): ?>
        <div class="message error">
          <strong>❌ Please fix the following errors:</strong>
          <ul>
            <?php foreach ($errors as $e): ?>
              <li><?php echo htmlspecialchars($e, ENT_QUOTES, 'UTF-8'); ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <?php if ($success): ?>
        <div class="message success">
          <strong>✅ <?php echo htmlspecialchars($success, ENT_QUOTES, 'UTF-8'); ?></strong>
        </div>
      <?php endif; ?>

      <form method="post" action="create_user.php">
        <label for="name">Full Name *</label>
        <input type="text" id="name" name="name" 
               value="<?php echo isset($name) ? htmlspecialchars($name, ENT_QUOTES, 'UTF-8') : ''; ?>" 
               placeholder="Enter full name" required>

        <label for="email">Email Address *</label>
        <input type="email" id="email" name="email" 
               value="<?php echo isset($email) ? htmlspecialchars($email, ENT_QUOTES, 'UTF-8') : ''; ?>" 
               placeholder="user@example.com" required>

        <label for="password">Password *</label>
        <input type="password" id="password" name="password" 
               placeholder="Minimum 6 characters" required>

        <button class="btn" type="submit">Create User</button>
      </form>

      <div class="text-center mt-2">
        <a href="read_users.php" class="btn btn-secondary">View All Users</a>
        <a href="users_index.php" class="btn btn-secondary">Back to Dashboard</a>
      </div>
    </div>
  </div>
</body>
</html>
<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
    echo "Method Not Allowed";
    exit;
}

// Step 1: Collect data from $_POST
$name     = isset($_POST['name']) ? trim($_POST['name']) : '';
$email    = isset($_POST['email']) ? trim($_POST['email']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$confirm  = isset($_POST['confirmPassword']) ? $_POST['confirmPassword'] : '';
$phone    = isset($_POST['phone']) ? trim($_POST['phone']) : '';

// Step 2: Server-side validation
$errors = [];
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
if ($confirm !== '' && $password !== $confirm) {
    $errors[] = 'Passwords do not match.';
}
if ($phone !== '' && !preg_match('/^\d{10}$/', $phone)) {
    $errors[] = 'Phone must be 10 digits (optional).';
}

// Step 3: Output result page (errors or success)
?><!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Registration Result</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>
    body{font-family:Segoe UI, Arial, sans-serif;background:#f4f7fb;padding:2rem}
    .box{max-width:640px;margin:2rem auto;background:#fff;padding:1.5rem;border-radius:10px;box-shadow:0 6px 18px rgba(0,0,0,0.06)}
    h1{margin:0 0 1rem;color:#2575fc}
    .errors{border-left:4px solid #e53e3e;background:#fff5f5;padding:0.8rem 1rem;color:#9b2c2c}
    .success{border-left:4px solid #16a34a;background:#f0fdf4;padding:0.8rem 1rem;color:#065f46}
    .meta{margin-top:1rem;color:#334155}
    a.button{display:inline-block;margin-top:1rem;padding:0.5rem 0.9rem;background:#2575fc;color:#fff;border-radius:6px;text-decoration:none}
    ul{margin:0.5rem 0 0.5rem 1.1rem}
  </style>
</head>
<body>
  <div class="box">
    <h1>Registration Result</h1>
<?php if (!empty($errors)): ?>
    <div class="errors">
        <strong>The following errors occurred:</strong>
        <ul>
            <?php foreach ($errors as $err): ?>
                <li><?php echo htmlspecialchars($err, ENT_QUOTES, 'UTF-8'); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <p class="meta">Please go back and correct the form.</p>
    <a class="button" href="javascript:history.back()">Back</a>
<?php else: ?>
    <div class="success">
        <strong>Registration successful!</strong>
        <p>Welcome, <?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>.</p>
        <p>Your email: <?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php if ($phone !== ''): ?>
            <p>Phone: <?php echo htmlspecialchars($phone, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endif; ?>
    </div>
    <p class="meta">You may now return to the <a href="index.html">Home</a> or <a href="chat.php">Chat Room</a>.</p>
    <a class="button" href="index.html">Home</a>
<?php endif; ?>
  </div>
</body>
</html>

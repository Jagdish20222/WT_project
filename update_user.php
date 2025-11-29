<?php

include_once 'db_connect.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    die('Invalid user id');
}

$errors = [];
$success = '';

// If POST, process update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if ($name === '') $errors[] = 'Name is required.';
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required.';

    if (empty($errors)) {
        if ($password !== '') {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = mysqli_prepare($conn, "UPDATE users SET name = ?, email = ?, password = ? WHERE id = ?");
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, 'sssi', $name, $email, $hash, $id);
                if (mysqli_stmt_execute($stmt)) {
                    $success = 'User updated successfully.';
                } else {
                    $errors[] = 'Database error: ' . mysqli_error($conn);
                }
                mysqli_stmt_close($stmt);
            } else {
                $errors[] = 'Prepare failed: ' . mysqli_error($conn);
            }
        } else {
            // Update without changing password
            $stmt = mysqli_prepare($conn, "UPDATE users SET name = ?, email = ? WHERE id = ?");
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, 'ssi', $name, $email, $id);
                if (mysqli_stmt_execute($stmt)) {
                    $success = 'User updated successfully.';
                } else {
                    $errors[] = 'Database error: ' . mysqli_error($conn);
                }
                mysqli_stmt_close($stmt);
            } else {
                $errors[] = 'Prepare failed: ' . mysqli_error($conn);
            }
        }
    }
}

// Load current user data for form (fresh from DB)
$stmt = mysqli_prepare($conn, "SELECT id, name, email FROM users WHERE id = ?");
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
if (!$res || mysqli_num_rows($res) === 0) {
    die('User not found');
}
$user = mysqli_fetch_assoc($res);
mysqli_stmt_close($stmt);

?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Edit User</title>
  <style>
    body{font-family:Segoe UI, Arial, sans-serif;background:#f4f7fb;padding:2rem}
    .card{max-width:640px;margin:1.5rem auto;background:#fff;padding:1.2rem;border-radius:10px;box-shadow:0 6px 18px rgba(0,0,0,0.06)}
    label{display:block;margin-top:0.6rem}
    input{width:100%;padding:0.5rem;margin-top:0.25rem}
    .btn{margin-top:0.8rem;padding:0.5rem 0.8rem;background:#2575fc;color:#fff;border:none;border-radius:6px}
    .errors{color:#b91c1c}
    .success{color:#065f46}
    a.link{display:inline-block;margin-top:0.6rem}
  </style>
</head>
<body>
  <div class="card">
    <h1>Edit User</h1>

    <?php if (!empty($errors)): ?>
      <div class="errors"><strong>Errors:</strong>
        <ul>
          <?php foreach ($errors as $e): ?>
            <li><?php echo htmlspecialchars($e); ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <?php if ($success): ?>
      <div class="success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>

    <form method="post" action="update_user.php?id=<?php echo $id; ?>">
      <label for="name">Name</label>
      <input id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>">

      <label for="email">Email</label>
      <input id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>">

      <label for="password">New Password (leave blank to keep current)</label>
      <input id="password" name="password" type="password">

      <button class="btn" type="submit">Update</button>
    </form>

    <p><a class="link" href="read_users.php">Back to Users</a></p>
  </div>
</body>
</html>
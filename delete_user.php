<?php
// delete_user.php
// Confirm and delete a user by id
include_once 'db_connect.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    die('Invalid user id');
}

// If POST with confirm, perform delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['confirm']) && $_POST['confirm'] === 'yes') {
        $stmt = mysqli_prepare($conn, "DELETE FROM users WHERE id = ?");
        mysqli_stmt_bind_param($stmt, 'i', $id);
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            header('Location: read_users.php');
            exit;
        } else {
            $err = 'Delete failed: ' . mysqli_error($conn);
        }
    } else {
        header('Location: read_users.php');
        exit;
    }
}

// Load user name to show in confirmation
$stmt = mysqli_prepare($conn, "SELECT name, email FROM users WHERE id = ?");
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
  <title>Delete User</title>
  <style>
    body{font-family:Segoe UI, Arial, sans-serif;background:#f4f7fb;padding:2rem}
    .card{max-width:640px;margin:1.5rem auto;background:#fff;padding:1.2rem;border-radius:10px;box-shadow:0 6px 18px rgba(0,0,0,0.06)}
    .danger{color:#b91c1c}
    .btn{margin-right:8px;padding:0.5rem 0.8rem;background:#2575fc;color:#fff;border:none;border-radius:6px}
    .btn-danger{background:#ef4444}
  </style>
</head>
<body>
  <div class="card">
    <h1 class="danger">Delete User</h1>
    <p>Are you sure you want to delete <strong><?php echo htmlspecialchars($user['name']); ?></strong> (<?php echo htmlspecialchars($user['email']); ?>)?</p>
    <?php if (isset($err)): ?><p style="color:red"><?php echo htmlspecialchars($err); ?></p><?php endif; ?>
    <form method="post" action="delete_user.php?id=<?php echo $id; ?>">
      <button class="btn btn-danger" type="submit" name="confirm" value="yes">Yes, delete</button>
      <button class="btn" type="submit" name="confirm" value="no">No, cancel</button>
    </form>
    <p><a href="read_users.php">Back to Users</a></p>
  </div>
</body>
</html>
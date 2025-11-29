<?php
/**
 * fetch_users.php
 * Includes `db_connect.php` to connect to `project_db` and displays the
 * contents of the `users` table in a simple HTML table with basic styling.
 */

// Include the database connection. This will print a connection status message.
require_once 'db_connect.php';

// At this point $conn is available and connected to project_db (or script exited).

// Query all users
$sql = 'SELECT id, name, email, password FROM users ORDER BY id ASC';
$result = mysqli_query($conn, $sql);
if ($result === false) {
    echo '<p style="color:red;">Query failed: ' . htmlspecialchars(mysqli_error($conn), ENT_QUOTES, 'UTF-8') . '</p>';
    exit;
}

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Users — Project DB</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>
    body{font-family:Segoe UI, Arial, sans-serif;background:#f4f7fb;padding:2rem}
    .wrap{max-width:900px;margin:2rem auto;background:#fff;padding:1.2rem;border-radius:10px;box-shadow:0 6px 18px rgba(0,0,0,0.06)}
    h1{color:#2575fc;margin:0 0 1rem}
    table{width:100%;border-collapse:collapse;margin-top:1rem}
    th,td{border:1px solid #e2e8f0;padding:0.6rem;text-align:left}
    th{background:#f8fafc}
    .center{text-align:center}
    a.button{display:inline-block;margin-top:1rem;padding:0.45rem 0.75rem;background:#2575fc;color:#fff;border-radius:6px;text-decoration:none}
  </style>
</head>
<body>
  <div class="wrap">
    <h1 class="center">Registered Users</h1>
    <?php if (mysqli_num_rows($result) === 0): ?>
      <p>No users found. Make sure you ran <code>insert_data.php</code>.</p>
    <?php else: ?>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Password</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
              <td><?php echo htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8'); ?></td>
              <td><?php echo htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8'); ?></td>
              <td><?php echo htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8'); ?></td>
              <td><?php echo htmlspecialchars($row['password'], ENT_QUOTES, 'UTF-8'); ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php endif; ?>

    <div class="center">
      <a class="button" href="insert_data.php">(Re)create data</a>
    </div>
  </div>
</body>
</html>

<?php
// Free result and close connection
mysqli_free_result($result);
mysqli_close($conn);
?>

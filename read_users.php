<?php

include_once 'db_connect.php';

// SQL query to fetch all users, ordered by ID (newest first can use DESC)
$sql = "SELECT id, name, email, created_at FROM users ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

// Check if query execution was successful
if (!$result) {
    die('<div class="message error">Database query failed: ' . htmlspecialchars(mysqli_error($conn), ENT_QUOTES, 'UTF-8') . '</div>');
}

// Count total users for display
$totalUsers = mysqli_num_rows($result);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View All Users - Web Technology Project</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h1 class="text-center" style="color:white; text-shadow:2px 2px 4px rgba(0,0,0,0.3);">👥 User Management</h1>
    
    <div style="background:white; padding:2rem; border-radius:12px; box-shadow:0 4px 20px rgba(0,0,0,0.15);">
      <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem; flex-wrap:wrap; gap:1rem;">
        <h2 style="margin:0; color:#667eea;">All Users</h2>
        <div>
          <a class="btn btn-success" href="create_user.php">➕ Add New User</a>
          <a class="btn btn-secondary" href="users_index.php">← Back to Dashboard</a>
        </div>
      </div>

      <div class="message info" style="margin-bottom:1rem;">
        <strong>Total Users:</strong> <?php echo $totalUsers; ?>
      </div>

      <?php if ($totalUsers === 0): ?>
        <!-- Empty state: No users found -->
        <div style="text-align:center; padding:3rem; color:#64748b;">
          <p style="font-size:3rem; margin:0;">💭</p>
          <h3>No Users Found</h3>
          <p>Get started by adding your first user!</p>
          <a href="create_user.php" class="btn btn-primary mt-1">Add First User</a>
        </div>
      <?php else: ?>
        <!-- Users table -->
        <div style="overflow-x:auto;">
          <table>
            <thead>
              <tr>
                <th style="width:60px; text-align:center;">ID</th>
                <th>Name</th>
                <th>Email</th>
                <th style="width:180px;">Registered At</th>
                <th style="width:180px; text-align:center;">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                  <td style="text-align:center; font-weight:600;"><?php echo htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8'); ?></td>
                  <td><?php echo htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                  <td><?php echo htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                  <td><?php echo htmlspecialchars($row['created_at'], ENT_QUOTES, 'UTF-8'); ?></td>
                  <td style="text-align:center;">
                    <a class="btn btn-warning" href="update_user.php?id=<?php echo $row['id']; ?>"
                       style="margin:0.2rem;">✏️ Edit</a>
                    <a class="btn btn-danger" href="delete_user.php?id=<?php echo $row['id']; ?>" 
                       style="margin:0.2rem;"
                       onclick="return confirm('Are you sure you want to delete this user?');">🗑️ Delete</a>
                  </td>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
<?php 
// Free result set and close database connection
mysqli_free_result($result);
mysqli_close($conn); 
?>
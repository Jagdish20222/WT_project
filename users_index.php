<?php
// users_index.php
// Simple navigation page for the user management CRUD module
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>User Management</title>
    <style>
        body{font-family:Segoe UI, Arial, sans-serif;background:#f4f7fb;padding:2rem}
        .card{max-width:760px;margin:2rem auto;background:#fff;padding:1.2rem;border-radius:10px;box-shadow:0 6px 18px rgba(0,0,0,0.06)}
        a.btn{display:inline-block;padding:0.6rem 0.9rem;background:#2575fc;color:#fff;border-radius:6px;text-decoration:none;margin-right:8px}
    </style>
</head>
<body>
    <div class="card">
        <h1>User Management</h1>
        <p>Use the links below to manage users.</p>
        <p>
            <a class="btn" href="create_user.php">Create User</a>
            <a class="btn" href="read_users.php">View Users</a>
            <a class="btn" href="init_db.php">Init DB</a>
            <a class="btn" href="index.html">Back to Site</a>
        </p>
    </div>
</body>
</html>
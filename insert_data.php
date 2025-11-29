<?php
/**
 * insert_data.php
 * Creates the `project_db` database (if missing), the `users` table, and inserts sample records.
 * Run this once from your browser under XAMPP (e.g. http://localhost/Project__/insert_data.php).
 */

// DB server credentials (XAMPP default: root with no password)
$host = 'localhost';
$user = 'root';
$pass = '';
$dbName = 'project_db';

// Create connection to MySQL server (no database selected yet)
$conn = mysqli_connect($host, $user, $pass);
if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
}

// Create the database if it does not exist
$sql = "CREATE DATABASE IF NOT EXISTS `" . mysqli_real_escape_string($conn, $dbName) . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci";
if (!mysqli_query($conn, $sql)) {
    die('Database creation failed: ' . mysqli_error($conn));
}

// Select the database
mysqli_select_db($conn, $dbName);

// Create the users table if not exists
$createTable = <<<SQL
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(150) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
SQL;

if (!mysqli_query($conn, $createTable)) {
    die('Table creation failed: ' . mysqli_error($conn));
}

// Insert sample data — we use prepared statements to be safe.
$samples = [
    ['Alice Johnson', 'alice@example.com', 'alice123'],
    ['Bob Singh', 'bob@example.com', 'bobsecure'],
    ['Carla Gomez', 'carla@example.com', 'carlapass']
];

$stmt = mysqli_prepare($conn, 'INSERT INTO users (name, email, password) VALUES (?, ?, ?)');
if (!$stmt) {
    die('Prepare failed: ' . mysqli_error($conn));
}

// Note: In a real app you should store hashed passwords e.g. password_hash().
// For simplicity in this exercise we store plaintext (not recommended for production).
foreach ($samples as $row) {
    mysqli_stmt_bind_param($stmt, 'sss', $row[0], $row[1], $row[2]);
    // Use @ to ignore duplicate insert error if run multiple times
    @mysqli_stmt_execute($stmt);
}

mysqli_stmt_close($stmt);

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Insert Sample Data</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>
    body{font-family:Segoe UI, Arial, sans-serif;background:#f4f7fb;padding:2rem}
    .box{max-width:720px;margin:2rem auto;background:#fff;padding:1.5rem;border-radius:10px;box-shadow:0 6px 18px rgba(0,0,0,0.06);text-align:center}
    a.button{display:inline-block;margin-top:1rem;padding:0.5rem 0.9rem;background:#2575fc;color:#fff;border-radius:6px;text-decoration:none}
  </style>
</head>
<body>
  <div class="box">
    <h1>Insert Sample Data</h1>
    <p>Database <strong><?php echo htmlspecialchars($dbName, ENT_QUOTES, 'UTF-8'); ?></strong> and table <code>users</code> are ready.</p>
    <p>Inserted sample records (duplicates are ignored if you run this multiple times).</p>
    <a class="button" href="fetch_users.php">View Users</a>
  </div>
</body>
</html>

<?php
// Close connection
mysqli_close($conn);
?>

<?php
/**
 * crud_index.php
 * Main dashboard page - Displays all student records (SELECT operation)
 * 
 * Purpose: Shows all records from students table with Edit/Delete actions
 * Operations: Performs SELECT query to fetch all student data
 * Links to: insert.php (add new), update.php (edit), delete.php (remove)
 */

// Include database connection
require_once 'config.php';

// Fetch all students from database - SELECT operation
$query = "SELECT id, name, email, password, created_at FROM users ORDER BY id DESC";
$result = mysqli_query($conn, $query);

// Check if query was successful
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

// Count total records
$totalRecords = mysqli_num_rows($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Dashboard - Student Management</title>
    <link rel="stylesheet" href="crud_styles.css">
</head>
<body>
    <div class="container">
        <h1>📚 Student Management System</h1>
        <p style="text-align: center; color: #64748b; margin-bottom: 1.5rem;">
            CRUD Operations: Create, Read, Update, Delete
        </p>

        <!-- Display success message if passed via URL -->
        <?php if (isset($_GET['success'])): ?>
            <div class="message success">
                ✓ <?php echo htmlspecialchars($_GET['success'], ENT_QUOTES, 'UTF-8'); ?>
            </div>
        <?php endif; ?>

        <!-- Display error message if passed via URL -->
        <?php if (isset($_GET['error'])): ?>
            <div class="message error">
                ✗ <?php echo htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8'); ?>
            </div>
        <?php endif; ?>

        <!-- Add New Student Button -->
        <div style="margin-bottom: 1rem;">
            <a href="insert.php" class="btn btn-success">+ Add New Student</a>
            <span style="float: right; color: #64748b;">
                Total Records: <strong><?php echo $totalRecords; ?></strong>
            </span>
        </div>

        <!-- Students Table - READ operation display -->
        <?php if ($totalRecords > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['password'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['created_at'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="action-links">
                                <!-- Edit button - passes ID to update.php -->
                                <a href="update.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">Edit</a>
                                <!-- Delete button - passes ID to delete.php with confirmation -->
                                <a href="delete.php?id=<?php echo $row['id']; ?>" 
                                   class="btn btn-danger" 
                                   onclick="return confirm('Are you sure you want to delete this student?');">
                                   Delete
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <!-- Empty state when no records exist -->
            <div class="empty-state">
                <p>📭 No students found in the database.</p>
                <a href="insert.php" class="btn btn-primary">Add First Student</a>
            </div>
        <?php endif; ?>

        <!-- Footer with back link -->
        <div style="margin-top: 2rem; text-align: center;">
            <a href="index.html" class="btn btn-secondary">← Back to Main Site</a>
        </div>
    </div>
</body>
</html>

<?php
// Free result and close connection
mysqli_free_result($result);
mysqli_close($conn);
?>

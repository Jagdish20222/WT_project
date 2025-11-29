<?php


// Include database connection
require_once 'config.php';

// Step 1: Get student ID from URL parameter
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Step 2: First verify the student exists before deleting
    $checkStmt = mysqli_prepare($conn, 'SELECT id FROM students WHERE id = ?');
    mysqli_stmt_bind_param($checkStmt, 'i', $id);
    mysqli_stmt_execute($checkStmt);
    $checkResult = mysqli_stmt_get_result($checkStmt);
    
    if (mysqli_num_rows($checkResult) > 0) {
        // Student exists - proceed with DELETE operation
        mysqli_stmt_close($checkStmt);
        
        // Use prepared statement for secure DELETE query
        $deleteStmt = mysqli_prepare($conn, 'DELETE FROM students WHERE id = ?');
        
        if ($deleteStmt) {
            // Bind parameter: i = integer type
            mysqli_stmt_bind_param($deleteStmt, 'i', $id);
            
            // Execute the DELETE query
            if (mysqli_stmt_execute($deleteStmt)) {
                // Check if a row was actually deleted
                if (mysqli_stmt_affected_rows($deleteStmt) > 0) {
                    mysqli_stmt_close($deleteStmt);
                    mysqli_close($conn);
                    // Success - redirect with success message
                    header('Location: crud_index.php?success=Student deleted successfully!');
                    exit;
                } else {
                    // No rows affected (shouldn't happen since we checked existence)
                    mysqli_stmt_close($deleteStmt);
                    mysqli_close($conn);
                    header('Location: crud_index.php?error=Failed to delete student.');
                    exit;
                }
            } else {
                // Query execution failed
                mysqli_stmt_close($deleteStmt);
                mysqli_close($conn);
                header('Location: crud_index.php?error=Database error: ' . urlencode(mysqli_error($conn)));
                exit;
            }
        } else {
            // Failed to prepare statement
            mysqli_close($conn);
            header('Location: crud_index.php?error=Failed to prepare delete statement.');
            exit;
        }
    } else {
        // Student not found
        mysqli_stmt_close($checkStmt);
        mysqli_close($conn);
        header('Location: crud_index.php?error=Student not found.');
        exit;
    }
} else {
    // Invalid or missing ID parameter
    mysqli_close($conn);
    header('Location: crud_index.php?error=Invalid student ID.');
    exit;
}

// This code should never be reached due to header redirects above
// But included for safety
mysqli_close($conn);
header('Location: crud_index.php');
exit;
?>

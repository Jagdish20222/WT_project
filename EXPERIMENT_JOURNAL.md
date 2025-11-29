# PHP-MySQL CRUD Operations - Experiment 8
## Web Technology Minor Project (EXTC under CSE)

---

## Experiment Title
**PHP-MySQL CRUD (Create, Read, Update, Delete) Operations for Student Management System**

---

## Aim
To design and implement a complete CRUD application using PHP and MySQL database, demonstrating INSERT, UPDATE, DELETE, and SELECT operations with proper form validation and user interface.

---

## Theory

### What is CRUD?
CRUD stands for the four basic operations performed on database records:
- **CREATE** - Insert new records into database (INSERT)
- **READ** - Retrieve and display records from database (SELECT)
- **UPDATE** - Modify existing records in database (UPDATE)
- **DELETE** - Remove records from database (DELETE)

### Technologies Used
1. **PHP (Hypertext Preprocessor)** - Server-side scripting language for web development
2. **MySQL** - Relational database management system
3. **MySQLi** - PHP extension for MySQL database connectivity
4. **HTML5** - Structure and forms
5. **CSS3** - Styling and responsive design

### Database Table Structure
```sql
CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)
```

---

## File Structure and Explanations

### 1. **config.php** - Database Configuration
**Purpose:** Centralized database connection file that establishes mysqli connection.

**Key Features:**
- Defines database credentials (host, username, password, database name)
- Creates mysqli connection using `mysqli_connect()`
- Handles connection errors with proper error messages
- Sets character encoding to UTF-8
- Used by all other PHP files via `require_once`

**Code Explanation:**
```php
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
```
This creates a connection object `$conn` that is used throughout the application.

---

### 2. **setup_db.php** - Database Setup Script
**Purpose:** One-time script to create database and table structure.

**Operations Performed:**
1. Connects to MySQL server without selecting database
2. Creates `crud_db` database if not exists
3. Selects the newly created database
4. Creates `students` table with required fields
5. Inserts sample data for testing

**SQL Queries Used:**
```sql
CREATE DATABASE IF NOT EXISTS crud_db;
CREATE TABLE IF NOT EXISTS students (...);
INSERT INTO students (name, email, password) VALUES (?, ?, ?);
```

**Usage:** Run once from browser at `http://localhost/Project__/setup_db.php`

---

### 3. **crud_index.php** - READ Operation (SELECT)
**Purpose:** Main dashboard that displays all student records in a table format.

**Operation:** **SELECT** - Retrieves all records from database

**SQL Query:**
```sql
SELECT id, name, email, password, created_at FROM students ORDER BY id DESC
```

**Key Features:**
- Fetches all student records using `mysqli_query()`
- Displays data in HTML table with borders
- Shows total record count
- Provides Edit and Delete action buttons for each row
- Displays success/error messages from URL parameters
- Uses `htmlspecialchars()` to prevent XSS attacks

**Process Flow:**
1. Include config.php for database connection
2. Execute SELECT query
3. Check if query succeeded
4. Loop through results using `mysqli_fetch_assoc()`
5. Display each record in table row
6. Provide action links (Edit/Delete) for each record

---

### 4. **insert.php** - CREATE Operation (INSERT)
**Purpose:** Add new student records to the database.

**Operation:** **INSERT** - Adds new record to students table

**SQL Query:**
```sql
INSERT INTO students (name, email, password) VALUES (?, ?, ?)
```

**Key Features:**
- Displays form with name, email, and password fields
- Performs server-side validation
- Uses **prepared statements** to prevent SQL injection
- Handles duplicate email errors (UNIQUE constraint)
- Redirects to index page on success

**Process Flow:**
1. Display empty form (GET request)
2. Collect form data on submission (POST request)
3. Validate input data
4. Prepare INSERT statement using `mysqli_prepare()`
5. Bind parameters with `mysqli_stmt_bind_param()`
6. Execute query with `mysqli_stmt_execute()`
7. Redirect to crud_index.php with success message

**Validation Rules:**
- Name: Required
- Email: Required, valid email format
- Password: Required, minimum 6 characters

---

### 5. **update.php** - UPDATE Operation
**Purpose:** Modify existing student records in the database.

**Operation:** **UPDATE** - Changes existing record data

**SQL Queries:**
```sql
-- Fetch existing data
SELECT id, name, email, password FROM students WHERE id = ?

-- Update record
UPDATE students SET name = ?, email = ?, password = ? WHERE id = ?
```

**Key Features:**
- Receives student ID via URL parameter (`?id=123`)
- Fetches existing data and prefills form
- Uses hidden input field to pass ID with form
- Validates updated data
- Uses prepared statements for security
- Checks affected rows to confirm update
- Redirects to index on success

**Process Flow:**
1. Get ID from URL (`$_GET['id']`)
2. Fetch existing record to prefill form
3. Display form with current values
4. On submission, validate new data
5. Execute UPDATE query with WHERE clause
6. Check `mysqli_stmt_affected_rows()` to verify update
7. Redirect with success message

**Important:** The WHERE clause (`WHERE id = ?`) ensures only the specific record is updated.

---

### 6. **delete.php** - DELETE Operation
**Purpose:** Remove student records from the database.

**Operation:** **DELETE** - Removes record permanently

**SQL Queries:**
```sql
-- Verify student exists
SELECT id FROM students WHERE id = ?

-- Delete record
DELETE FROM students WHERE id = ?
```

**Key Features:**
- Receives student ID via URL parameter
- Verifies record exists before deletion
- Uses prepared statement for security
- JavaScript confirmation before delete (`onclick="return confirm(...)"`)
- Redirects to index with success/error message
- No form display (direct operation)

**Process Flow:**
1. Get ID from URL (`$_GET['id']`)
2. Verify student exists with SELECT query
3. If exists, prepare DELETE statement
4. Execute DELETE query
5. Check affected rows
6. Redirect to index page with message

**Security Note:** Always verify record exists before deletion to prevent unnecessary database queries.

---

### 7. **crud_styles.css** - Styling
**Purpose:** Provides clean, modern UI for all CRUD pages.

**Features:**
- Gradient background (purple theme)
- Centered white container with shadow
- Responsive table design
- Button styling (primary, success, warning, danger)
- Form input styling with focus effects
- Success/error message boxes
- Mobile responsive design with media queries

**Design Elements:**
- Color scheme: Blue (#2575fc), Green (#16a34a), Red (#dc2626), Orange (#f59e0b)
- Font: Segoe UI, Arial, sans-serif
- Border radius: 6-12px for modern look
- Box shadows for depth
- Hover effects on buttons and table rows

---

## CRUD Operations Summary

### 1. CREATE (INSERT)
**File:** insert.php  
**Query:** `INSERT INTO students (name, email, password) VALUES (?, ?, ?)`  
**Method:** POST form submission with prepared statements

### 2. READ (SELECT)
**File:** crud_index.php  
**Query:** `SELECT id, name, email, password, created_at FROM students ORDER BY id DESC`  
**Method:** mysqli_query() with fetch loop

### 3. UPDATE
**File:** update.php  
**Query:** `UPDATE students SET name = ?, email = ?, password = ? WHERE id = ?`  
**Method:** Prefilled form + POST submission with WHERE clause

### 4. DELETE
**File:** delete.php  
**Query:** `DELETE FROM students WHERE id = ?`  
**Method:** Direct execution via URL parameter with confirmation

---

## Security Features Implemented

1. **Prepared Statements**: Used `mysqli_prepare()` and parameter binding to prevent SQL injection attacks
2. **Input Validation**: Server-side validation for all form inputs
3. **XSS Prevention**: Used `htmlspecialchars()` to sanitize output
4. **Email Uniqueness**: UNIQUE constraint on email field prevents duplicates
5. **Error Handling**: Proper error messages without exposing sensitive information
6. **JavaScript Confirmation**: User confirmation before delete operation

---

## How to Run the Application

### Prerequisites
- XAMPP installed with Apache and MySQL running
- PHP version 7.4 or higher
- MySQL database

### Setup Steps

1. **Start XAMPP**
   - Open XAMPP Control Panel
   - Start Apache and MySQL services

2. **Place Files**
   - Copy all project files to `C:\xampp\htdocs\Project__\`

3. **Run Setup**
   - Open browser and navigate to: `http://localhost/Project__/setup_db.php`
   - This creates database and table automatically

4. **Access Application**
   - Main dashboard: `http://localhost/Project__/crud_index.php`
   - Or click "CRUD System" link from main website

5. **Test Operations**
   - Click "Add New Student" to insert records (CREATE)
   - View all students in table (READ)
   - Click "Edit" button to update records (UPDATE)
   - Click "Delete" button to remove records (DELETE)

---

## Testing Checklist

- [ ] Database and table created successfully
- [ ] Sample data inserted
- [ ] Can view all records in table format
- [ ] Can add new student (INSERT works)
- [ ] Form validation works (empty fields, invalid email)
- [ ] Duplicate email prevention works
- [ ] Can edit existing student (UPDATE works)
- [ ] Form prefills with existing data
- [ ] Can delete student (DELETE works)
- [ ] Confirmation dialog appears before delete
- [ ] Success/error messages display correctly
- [ ] Responsive design works on mobile

---

## Conclusion

This experiment successfully demonstrates the implementation of complete CRUD operations using PHP and MySQL. The application includes:

✓ All four CRUD operations (CREATE, READ, UPDATE, DELETE)  
✓ Proper database connection and error handling  
✓ Form validation and security measures  
✓ Clean, responsive user interface  
✓ Prepared statements for SQL injection prevention  
✓ User-friendly success/error messages  

The modular file structure makes the code maintainable and easy to understand. Each operation is isolated in its own file with clear comments explaining the logic.

---

## Future Enhancements

1. Password hashing using `password_hash()` and `password_verify()`
2. User authentication and session management
3. Search and filter functionality
4. Pagination for large datasets
5. Export data to CSV/PDF
6. Image upload for student profiles
7. AJAX for operations without page reload
8. Input sanitization using prepared statements for all queries

---

## References

1. PHP Official Documentation - https://www.php.net/manual/en/
2. MySQLi Documentation - https://www.php.net/manual/en/book.mysqli.php
3. W3Schools PHP MySQL Tutorial - https://www.w3schools.com/php/php_mysql_intro.asp
4. OWASP Security Guidelines - https://owasp.org/www-project-web-security-testing-guide/

---

**Submitted by:** [Your Name]  
**Roll No:** [Your Roll Number]  
**Course:** Web Technology (EXTC under CSE)  
**Experiment No:** 8  
**Date:** [Submission Date]

---

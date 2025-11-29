# PHP-MySQL CRUD System - Quick Start Guide

## 📁 Files Created

### Core CRUD Files
- `config.php` - Database connection configuration
- `crud_index.php` - Main dashboard (READ/SELECT operation)
- `insert.php` - Add new students (CREATE/INSERT operation)
- `update.php` - Edit existing students (UPDATE operation)
- `delete.php` - Remove students (DELETE operation)

### Setup & Styling
- `setup_db.php` - Database and table creation script
- `crud_styles.css` - Complete CSS styling
- `EXPERIMENT_JOURNAL.md` - Detailed documentation for experiment report

### Updated Files
- `index.html` - Added link to CRUD system

---

## 🚀 Quick Setup (3 Steps)

### Step 1: Start XAMPP
```
1. Open XAMPP Control Panel
2. Click START for Apache
3. Click START for MySQL
```

### Step 2: Run Setup Script
Open in browser:
```
http://localhost/Project__/setup_db.php
```
This will:
- Create database `crud_db`
- Create table `students`
- Insert 3 sample records

### Step 3: Access CRUD System
```
http://localhost/Project__/crud_index.php
```

Or click the "🗄️ CRUD System" card on the main website.

---

## 🎯 How to Use

### View All Students (READ)
- Open `crud_index.php`
- See all student records in table format

### Add New Student (CREATE)
1. Click "Add New Student" button
2. Fill in: Name, Email, Password
3. Click "Add Student"
4. Redirects to dashboard with success message

### Edit Student (UPDATE)
1. Click "Edit" button next to any student
2. Form opens prefilled with current data
3. Modify fields as needed
4. Click "Update Student"
5. Record updated in database

### Delete Student (DELETE)
1. Click "Delete" button next to any student
2. Confirm in popup dialog
3. Record removed from database
4. Success message displayed

---

## 🔧 Configuration

### Database Settings (config.php)
```php
DB_HOST = 'localhost'
DB_USER = 'root'
DB_PASS = ''          // Empty for default XAMPP
DB_NAME = 'crud_db'
```

Change these if your XAMPP uses different credentials.

---

## 📊 Database Structure

### Table: students
```sql
id          INT (Primary Key, Auto Increment)
name        VARCHAR(100) NOT NULL
email       VARCHAR(150) NOT NULL UNIQUE
password    VARCHAR(255) NOT NULL
created_at  TIMESTAMP (Default: Current Time)
```

---

## ✅ Testing Checklist

Test each operation to verify everything works:

**Setup**
- [ ] XAMPP Apache and MySQL running
- [ ] setup_db.php executed successfully
- [ ] Database `crud_db` exists in phpMyAdmin

**CREATE (Insert)**
- [ ] Form displays correctly
- [ ] Can add new student with valid data
- [ ] Validation works (empty fields rejected)
- [ ] Email validation works
- [ ] Duplicate email prevention works
- [ ] Success message appears after insert

**READ (Select)**
- [ ] All students display in table
- [ ] Record count is correct
- [ ] Data properly formatted (no HTML tags)
- [ ] Timestamps display correctly

**UPDATE**
- [ ] Edit button opens prefilled form
- [ ] Correct student data loads
- [ ] Can modify and save changes
- [ ] Validation works on update
- [ ] Success message appears

**DELETE**
- [ ] Confirmation dialog appears
- [ ] Record deleted after confirmation
- [ ] Success message displayed
- [ ] Record removed from table

---

## 🔐 Security Features

✓ **Prepared Statements** - All queries use mysqli_prepare()  
✓ **Parameter Binding** - No direct SQL concatenation  
✓ **XSS Prevention** - htmlspecialchars() on all output  
✓ **Input Validation** - Server-side checks for all fields  
✓ **Error Handling** - Safe error messages (no SQL exposure)  
✓ **UNIQUE Constraint** - Prevents duplicate emails  

---

## 📝 SQL Queries Reference

### CREATE (Insert)
```sql
INSERT INTO students (name, email, password) VALUES (?, ?, ?)
```

### READ (Select)
```sql
SELECT id, name, email, password, created_at FROM students ORDER BY id DESC
```

### UPDATE
```sql
-- Fetch for editing
SELECT id, name, email, password FROM students WHERE id = ?

-- Update record
UPDATE students SET name = ?, email = ?, password = ? WHERE id = ?
```

### DELETE
```sql
DELETE FROM students WHERE id = ?
```

---

## 🎨 UI Features

- **Gradient Background** - Modern purple/blue gradient
- **Centered Layout** - White container with shadow
- **Responsive Tables** - Mobile-friendly design
- **Color-Coded Buttons**
  - Blue (Primary) - Submit, Add
  - Green (Success) - Add New
  - Orange (Warning) - Edit
  - Red (Danger) - Delete
  - Gray (Secondary) - Cancel, Back
- **Message Boxes** - Green for success, red for errors
- **Hover Effects** - Interactive button states

---

## 🐛 Troubleshooting

### "Connection failed" error
- Ensure XAMPP MySQL is running
- Check database credentials in config.php
- Run setup_db.php to create database

### "Table doesn't exist" error
- Run setup_db.php to create table
- Check phpMyAdmin to verify table exists

### "Student not found" on edit/delete
- Record may have been deleted
- Clear browser cache
- Refresh crud_index.php

### Form validation not working
- Check browser console for JavaScript errors
- Ensure proper input types in HTML
- Verify server-side validation in PHP

### Duplicate email error
- Each email must be unique
- Try different email address
- Check existing records in database

---

## 📚 For Your Experiment Journal

The `EXPERIMENT_JOURNAL.md` file contains:
- Complete theory and explanations
- File-by-file documentation
- SQL query explanations
- Security features description
- Testing procedures
- Screenshots placeholders

Copy relevant sections to your lab journal/report.

---

## 🔗 URL Structure

```
Main Site:        http://localhost/Project__/index.html
Setup:            http://localhost/Project__/setup_db.php
Dashboard:        http://localhost/Project__/crud_index.php
Add Student:      http://localhost/Project__/insert.php
Edit Student:     http://localhost/Project__/update.php?id=123
Delete Student:   http://localhost/Project__/delete.php?id=123
```

---

## 💡 Tips

1. **Always run setup_db.php first** before using CRUD operations
2. **Test each operation** after setup to ensure everything works
3. **Check phpMyAdmin** to verify database changes
4. **Use prepared statements** for all future database queries
5. **Read comments in code** for detailed explanations
6. **Backup database** before testing delete operations

---

## 📞 Common Operations in phpMyAdmin

Access phpMyAdmin: `http://localhost/phpmyadmin`

**View all records:**
```sql
SELECT * FROM crud_db.students;
```

**Reset table (delete all data):**
```sql
TRUNCATE TABLE crud_db.students;
```

**Drop database (complete removal):**
```sql
DROP DATABASE crud_db;
```

**Count records:**
```sql
SELECT COUNT(*) FROM students;
```

---

## ✨ Summary

You now have a complete PHP-MySQL CRUD system with:
- ✅ All 4 operations (CREATE, READ, UPDATE, DELETE)
- ✅ Clean, modern UI with responsive design
- ✅ Proper security (prepared statements, validation)
- ✅ Error handling and user feedback
- ✅ Complete documentation for lab report
- ✅ Integration with your main website

**Total Files:** 8 new files + 1 updated file  
**Lines of Code:** ~1000+ lines of well-commented PHP, HTML, CSS  
**Ready for:** Experiment submission, demo, and grading  

---

**Need Help?** Check EXPERIMENT_JOURNAL.md for detailed explanations of each file.

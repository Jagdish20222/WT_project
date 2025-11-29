# 🎓 Student Management System

A modern, dark-themed web application for managing student records with CRUD operations, XML data display, and real-time chat functionality.

![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?logo=php)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?logo=mysql)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?logo=css3)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?logo=javascript&logoColor=black)

## ✨ Features

- **🔐 User Management**: Complete CRUD operations (Create, Read, Update, Delete)
- **📊 XML Integration**: Display student data with XML/XSL/DTD validation
- **💬 Chat Room**: Real-time messaging system with file-based storage
- **🎨 Modern UI**: Dark theme with glassmorphism effects and gradient accents
- **🔒 Security**: Password hashing, prepared statements, XSS prevention
- **📱 Responsive Design**: Mobile-friendly interface

## 🚀 Technologies Used

### Backend
- PHP 8.2.12
- MySQL (via XAMPP)
- SimpleXML Parser
- PDO with Prepared Statements

### Frontend
- HTML5
- CSS3 (Glassmorphism, Gradients, Animations)
- Vanilla JavaScript
- Real-time Form Validation

### Data Formats
- XML with XSL Transformation
- DTD Schema Validation
- JSON for chat storage

## 📦 Installation

### Prerequisites
- [XAMPP](https://www.apachefriends.org/) (PHP 8.2+, MySQL, Apache)
- Web Browser (Chrome, Firefox, Edge)

### Setup Steps

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/student-management-system.git
   cd student-management-system
   ```

2. **Move to XAMPP directory**
   ```bash
   # Copy files to XAMPP htdocs
   cp -r * C:\xampp\htdocs\Project__\
   ```

3. **Start XAMPP Services**
   - Open XAMPP Control Panel
   - Start **Apache** and **MySQL**

4. **Initialize Database**
   - Open browser: `http://localhost/Project__/init_db.php`
   - This creates `wt_project_db` database and `users` table

5. **Access Application**
   - Main page: `http://localhost/Project__/index.html`

## 📁 Project Structure

```
Project__/
├── index.html              # Landing page with hero section
├── style.css               # Global dark theme styles
├── registration.js         # Form validation logic
├── db_connect.php         # Database connection handler
├── init_db.php            # Database initialization script
├── create_user.php        # Create new user
├── read_users.php         # Display all users
├── update_user.php        # Update existing user
├── delete_user.php        # Delete user
├── students_xml.php       # XML data display
├── chat.php               # Chat room interface
├── process.php            # Form processing
├── data.xml               # Sample XML data
├── data.xsl               # XSL stylesheet
├── data.dtd               # DTD schema
└── README.md              # Project documentation
```

## 🎯 Usage

### User Registration
1. Click "Register Now" button
2. Fill in name, email, password
3. Submit form (validates in real-time)

### View Users
- Click "View All Users" to see registered students
- Table displays ID, Name, Email, Registration Date

### XML Data
- Click "View XML Data" to see student records
- Displays parsed XML with professional styling

### Chat Room
- Click "Chat Room" button
- Enter your name and message
- Messages stored in `messages.json`

## 🔒 Security Features

- **Password Hashing**: `password_hash()` with bcrypt
- **SQL Injection Prevention**: PDO prepared statements
- **XSS Protection**: `htmlspecialchars()` on all outputs
- **Input Validation**: Client and server-side
- **Character Limits**: User inputs sanitized with `mb_substr()`

## 🎨 Design Features

- **Dark Theme**: #0f0f0f background with #ffd93d accents
- **Glassmorphism**: Semi-transparent containers with backdrop blur
- **Gradient Text**: Smooth color transitions on headings
- **Hover Effects**: Interactive buttons and cards
- **Responsive Grid**: Adapts to mobile/tablet/desktop
- **Smooth Animations**: CSS transitions and transforms

## 🗄️ Database Schema

### `users` Table
```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email (email)
);
```

## 📝 API Endpoints

| Endpoint | Method | Description |
|----------|--------|-------------|
| `/create_user.php` | GET/POST | Register new user |
| `/read_users.php` | GET | Display all users |
| `/update_user.php` | GET/POST | Update user details |
| `/delete_user.php` | GET/POST | Delete user by ID |
| `/students_xml.php` | GET | Parse and display XML data |
| `/chat.php` | GET/POST | Chat room interface |

## 🐛 Troubleshooting

### Apache "Forbidden" Error
- Ensure `.htaccess` file exists with proper directives
- Check file permissions (755 for folders, 644 for files)

### Database Connection Failed
- Verify MySQL service is running in XAMPP
- Check credentials in `db_connect.php`
- Run `init_db.php` to create database

### Chat Messages Not Saving
- Ensure `messages.json` file is writable
- Check PHP error logs in `C:\xampp\php\logs\`

### XML Not Displaying
- Verify `data.xml` exists and is valid
- Check `SimpleXML` extension is enabled in PHP

## 🌐 Deployment

**Note**: This is a PHP/MySQL application designed for traditional hosting.

### Recommended Hosting Providers:
- **InfinityFree** (Free PHP + MySQL)
- **Hostinger** (Affordable, $2-4/month)
- **000webhost** (Free tier available)
- **Railway.app** (Modern deployment)

### Deployment Steps:
1. Export database: `mysqldump -u root wt_project_db > backup.sql`
2. Upload files via FTP/cPanel File Manager
3. Import SQL file via phpMyAdmin
4. Update `db_connect.php` with production credentials
5. Test all features

## 🤝 Contributing

Contributions are welcome! Please follow these steps:
1. Fork the repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

## 📄 License

This project is open source and available under the [MIT License](LICENSE).

## 👨‍💻 Author

**Your Name**
- GitHub: [@yourusername](https://github.com/yourusername)
- Email: your.email@example.com

## 🙏 Acknowledgments

- Dark UI design inspired by modern web trends
- XAMPP for local development environment
- PHP community for security best practices

---

⭐ **Star this repository if you find it helpful!**

<?php
/**
 * students_xml.php
 * XML Data Display Page
 * 
 * Purpose: Displays student records from XML file
 * Technology: XML, PHP, HTML5, CSS3
 */

// Load and parse XML file
$xmlFile = 'data.xml';
$students = [];

if (file_exists($xmlFile)) {
    $xml = simplexml_load_file($xmlFile);
    if ($xml !== false) {
        foreach ($xml->student as $student) {
            $students[] = [
                'name' => (string)$student->name,
                'roll' => (string)$student->roll,
                'email' => (string)$student->email
            ];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Records - XML Display</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #0f0f0f;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Inter', sans-serif;
            color: #ffffff;
            min-height: 100vh;
        }

        /* Navigation */
        header {
            background: rgba(15, 15, 15, 0.8);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1rem 2rem;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        header nav {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header nav a {
            color: #a0a0a0;
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            transition: color 0.3s;
        }

        header nav a:hover {
            color: #ffd93d;
        }

        .back-btn {
            background: rgba(255, 255, 255, 0.05);
            padding: 0.5rem 1rem;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 3rem 2rem;
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #ffffff 0%, #a0a0a0 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .subtitle {
            color: #888888;
            font-size: 1.1rem;
            margin-bottom: 3rem;
        }
        
        .xml-info {
            background: rgba(59, 130, 246, 0.1);
            border-left: 4px solid #3b82f6;
            padding: 1.5rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            border: 1px solid rgba(59, 130, 246, 0.2);
        }
        
        .xml-info h3 {
            color: #60a5fa;
            margin-bottom: 1rem;
            font-size: 1.2rem;
        }
        
        .xml-info ul {
            margin: 0.5rem 0;
            padding-left: 1.5rem;
            color: #94a3b8;
            line-height: 1.8;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            overflow: hidden;
            margin: 2rem 0;
        }

        thead {
            background: rgba(255, 217, 61, 0.1);
            border-bottom: 2px solid rgba(255, 217, 61, 0.3);
        }

        th {
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: #ffd93d;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        td {
            padding: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            color: #e2e8f0;
        }

        tbody tr:hover {
            background: rgba(255, 255, 255, 0.05);
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            margin-top: 2rem;
            justify-content: center;
        }

        .btn {
            padding: 0.7rem 1.5rem;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            display: inline-block;
            transition: all 0.3s;
        }

        .btn-primary {
            background: #ffd93d;
            color: #0f0f0f;
        }

        .btn-primary:hover {
            background: #ffed4e;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.05);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .tech-stack {
            background: rgba(251, 191, 36, 0.1);
            border-left: 4px solid #fbbf24;
            padding: 1.5rem;
            border-radius: 12px;
            margin-top: 2rem;
            border: 1px solid rgba(251, 191, 36, 0.2);
        }

        .tech-stack h3 {
            color: #fcd34d;
            margin-bottom: 1rem;
        }

        .tech-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.05);
            padding: 0.4rem 0.8rem;
            margin: 0.25rem;
            border-radius: 6px;
            font-weight: 500;
            font-size: 0.85rem;
            color: #a0a0a0;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #666666;
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 2rem;
            }

            table {
                font-size: 0.9rem;
            }

            th, td {
                padding: 0.7rem;
            }
        }
    </style>
</head>
<body>
    <!-- Header Navigation -->
    <header>
        <nav>
            <a href="index.html" style="font-size:1.5rem; color:#ffd93d;">📚</a>
            <a href="index.html" class="back-btn">← Back to Home</a>
        </nav>
    </header>

    <!-- Main Content -->
    <div class="container">
        <h1>📄 Student Records - XML Data</h1>
        <p class="subtitle">Structured student information loaded from XML database</p>
        
        <!-- Information Box -->
        <div class="xml-info">
            <h3>📌 About This Module</h3>
            <p style="color: #cbd5e1; margin-bottom: 0.5rem;">
                This page demonstrates <strong>XML data handling with PHP</strong>. 
                Student records are stored in XML format and parsed server-side.
            </p>
            <ul>
                <li>XML file contains structured student data (name, roll, email)</li>
                <li>PHP SimpleXML parser reads and processes the data</li>
                <li>Data displayed in a modern, responsive table format</li>
                <li>Demonstrates server-side XML integration</li>
            </ul>
        </div>

        <!-- Student Data Table -->
        <?php if (count($students) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th style="width: 60px;">#</th>
                        <th>Name</th>
                        <th>Roll Number</th>
                        <th>Email Address</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $index => $student): ?>
                        <tr>
                            <td style="text-align: center; font-weight: 600;"><?php echo $index + 1; ?></td>
                            <td><?php echo htmlspecialchars($student['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($student['roll'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($student['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <p style="text-align: center; color: #666666; margin-top: 1rem;">
                Total Students: <strong style="color: #ffd93d;"><?php echo count($students); ?></strong>
            </p>
        <?php else: ?>
            <div class="empty-state">
                <p style="font-size: 3rem; margin-bottom: 1rem;">📭</p>
                <h3>No Student Records Found</h3>
                <p>The XML file is empty or couldn't be loaded.</p>
            </div>
        <?php endif; ?>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="data.xml" class="btn btn-primary" target="_blank">
                🔍 View Raw XML
            </a>
            <a href="data.xml" class="btn btn-secondary" download>
                ⬇️ Download XML
            </a>
            <a href="index.html" class="btn btn-secondary">
                ← Back to Home
            </a>
        </div>

        <!-- Technical Stack Information -->
        <div class="tech-stack">
            <h3>🔧 Technical Implementation</h3>
            <p style="color: #cbd5e1; margin-bottom: 1rem;"><strong>Files in this module:</strong></p>
            <ul style="color: #94a3b8; line-height: 1.8;">
                <li><code>data.xml</code> - Student records in XML format</li>
                <li><code>data.dtd</code> - Document Type Definition for validation</li>
                <li><code>data.xsl</code> - XSLT stylesheet for transformation</li>
                <li><code>students_xml.php</code> - PHP parser and display page</li>
            </ul>
            
            <p style="color: #cbd5e1; margin: 1rem 0;"><strong>Technologies Used:</strong></p>
            <div>
                <span class="tech-badge">XML 1.0</span>
                <span class="tech-badge">PHP 8.2</span>
                <span class="tech-badge">SimpleXML</span>
                <span class="tech-badge">DTD</span>
                <span class="tech-badge">HTML5</span>
                <span class="tech-badge">CSS3</span>
            </div>
        </div>
    </div>
</body>
</html>
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin: 2rem 0;
        }
        
        iframe {
            width: 100%;
            min-height: 600px;
            border: none;
            display: block;
        }
        
        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
            margin-top: 2rem;
        }
        
        .tech-stack {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 1.5rem;
            border-radius: 8px;
            margin-top: 2rem;
        }
        
        .tech-stack h3 {
            color: #92400e;
            margin-top: 0;
        }
        
        .tech-badge {
            display: inline-block;
            background: #ffffff;
            padding: 0.4rem 0.8rem;
            margin: 0.25rem;
            border-radius: 6px;
            font-weight: 500;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <!-- Header Navigation -->
    <header>
        <h1>📚 College Notes & PYQ Hub</h1>
        <nav aria-label=\"Main Navigation\">
            <ul>
                <li><a href=\"index.html\">Home</a></li>
                <li><a href=\"read_users.php\">Users</a></li>
                <li><a href=\"crud_index.php\">CRUD</a></li>
                <li><a href=\"students_xml.php\" aria-current=\"page\">Student XML</a></li>
                <li><a href=\"chat.php\">Chat</a></li>
            </ul>
        </nav>
    </header>

    <!-- Main Content -->
    <div class=\"container\">
        <div class=\"xml-container\">
            <h1 style=\"text-align:center; color:#667eea; margin-bottom:1rem;\">
                📄 Student Records - XML Display
            </h1>
            
            <!-- Information Box -->
            <div class=\"xml-info\">
                <h3>📌 About This Module</h3>
                <p>
                    This page demonstrates <strong>XML data transformation using XSLT</strong>. 
                    Student records are stored in XML format and transformed into HTML using XSL stylesheet.
                </p>
                <p><strong>Key Features:</strong></p>
                <ul>
                    <li>XML file contains structured student data (name, roll, email)</li>
                    <li>DTD validation ensures data integrity and structure</li>
                    <li>XSLT stylesheet transforms XML into styled HTML table</li>
                    <li>Browser performs client-side transformation automatically</li>
                </ul>
            </div>

            <!-- XML Display Frame -->
            <div class=\"xml-display-frame\">
                <iframe src=\"data.xml\" title=\"Student Records XML Display\" loading=\"lazy\"></iframe>
            </div>

            <!-- Action Buttons -->
            <div class=\"action-buttons\">
                <a href=\"data.xml\" class=\"btn btn-primary\" target=\"_blank\">
                    🔍 View Raw XML
                </a>
                <a href=\"data.xml\" class=\"btn btn-success\" download>
                    ⬇️ Download XML
                </a>
                <a href=\"data.xsl\" class=\"btn btn-warning\" target=\"_blank\">
                    📝 View XSL Stylesheet
                </a>
                <a href=\"index.html\" class=\"btn btn-secondary\">
                    ← Back to Home
                </a>
            </div>

            <!-- Technical Stack Information -->
            <div class=\"tech-stack\">
                <h3>🔧 Technical Implementation</h3>
                <p><strong>Files in this module:</strong></p>
                <ul style=\"margin: 1rem 0;\">
                    <li><code>data.xml</code> - Student records in XML format with DTD and XSL references</li>
                    <li><code>data.dtd</code> - Document Type Definition for XML structure validation</li>
                    <li><code>data.xsl</code> - XSLT stylesheet for HTML transformation</li>
                    <li><code>students_xml.php</code> - Integration page (this page)</li>
                </ul>
                
                <p><strong>Technologies Used:</strong></p>
                <div>
                    <span class=\"tech-badge\">XML 1.0</span>
                    <span class=\"tech-badge\">XSLT 1.0</span>
                    <span class=\"tech-badge\">DTD</span>
                    <span class=\"tech-badge\">HTML5</span>
                    <span class=\"tech-badge\">CSS3</span>
                    <span class=\"tech-badge\">PHP</span>
                </div>
                
                <p style=\"margin-top: 1rem;\">
                    <strong>How it works:</strong> When you open <code>data.xml</code>, the browser reads 
                    the XSL stylesheet reference, applies the transformation rules, and renders the data 
                    as a formatted HTML table with styling.
                </p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>© 2025 College Notes Hub | Web Technology Project</p>
    </footer>
</body>
</html>

<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">



<xsl:template match="/">
<html>
<head>
    <title>Student Records</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 2rem;
            margin: 0;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 1.5rem;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }
        th {
            background: #667eea;
            color: white;
            padding: 12px;
            text-align: left;
            font-weight: 600;
        }
        td {
            padding: 10px 12px;
            border-bottom: 1px solid #e2e8f0;
        }
        tr:hover {
            background-color: #f7fafc;
        }
        tr:last-child td {
            border-bottom: none;
        }
        .footer {
            text-align: center;
            margin-top: 1.5rem;
            color: #64748b;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📚 Student Records</h1>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Roll</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <xsl:for-each select="students/student">
                <tr>
                    <td><xsl:value-of select="name"/></td>
                    <td><xsl:value-of select="roll"/></td>
                    <td><xsl:value-of select="email"/></td>
                </tr>
                </xsl:for-each>
            </tbody>
        </table>
        <div class="footer">
            <p>Total Students: <strong><xsl:value-of select="count(students/student)"/></strong></p>
            <p>Generated using XML + XSLT</p>
        </div>
    </div>
</body>
</html>
</xsl:template>

</xsl:stylesheet>

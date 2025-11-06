<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Branch Directory System</title>
<style>
    body {
        font-family: 'Segoe UI', Arial, sans-serif;
        background-color: #121212;
        color: #f0f0f0;
        margin: 0;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }

    h1 {
        font-size: 2.5em;
        color: #00adb5;
        margin-bottom: 40px;
        text-align: center;
        text-shadow: 0 0 10px rgba(0, 173, 181, 0.5);
    }

    nav {
        background-color: #1f1f1f;
        border-radius: 12px;
        padding: 30px 40px;
        box-shadow: 0 0 15px rgba(0, 173, 181, 0.3);
        text-align: center;
    }

    a {
        display: inline-block;
        margin: 10px 15px;
        padding: 12px 20px;
        color: #fff;
        background-color: #00adb5;
        border-radius: 8px;
        font-weight: bold;
        text-decoration: none;
        transition: 0.3s ease;
    }

    a:hover {
        background-color: #019aa1;
        transform: scale(1.05);
        box-shadow: 0 0 10px rgba(0, 173, 181, 0.4);
    }

    footer {
        position: fixed;
        bottom: 10px;
        width: 100%;
        text-align: center;
        font-size: 0.9em;
        color: #666;
    }
</style>
</head>
<body>

    <h1>Student Branch Directory System</h1>

    <nav>
        <a href="create.php">➕ Add Student</a>
        <a href="read.php">📋 View Students</a>
        <a href="read.php">✏️ Update Student</a>
        <a href="read.php">🗑️ Delete Student</a>
    </nav>

    <footer>
        &copy; <?= date('Y'); ?> Student Branch Directory System. All rights reserved.
    </footer>

</body>
</html>

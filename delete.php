<?php
include 'db.php';


if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("<p style='color:red; text-align:center;'>❌ Error: Student ID not provided.<br><a href='read.php'>Back</a></p>");
}

$id = $_GET['id'];


try {
    $stmt = $pdo->prepare("SELECT fullname FROM students WHERE id = ?");
    $stmt->execute([$id]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$student) {
        die("<p style='color:red; text-align:center;'>❌ Student not found.<br><a href='read.php'>Back</a></p>");
    }
} catch (PDOException $e) {
    die("Error fetching record: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['confirm'])) {
    try {
        $del = $pdo->prepare("DELETE FROM students WHERE id = ?");
        $del->execute([$id]);

        echo "<script>alert('✅ Student record deleted successfully!'); window.location='read.php';</script>";
        exit;
    } catch (PDOException $e) {
        die("Error deleting record: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Delete Student</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #121212;
        color: #f0f0f0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }
    .container {
        background-color: #1f1f1f;
        padding: 30px;
        border-radius: 10px;
        text-align: center;
        width: 380px;
        box-shadow: 0 0 10px rgba(255, 0, 0, 0.3);
    }
    h2 {
        color: #ff4444;
        margin-bottom: 15px;
    }
    p.warning {
        background-color: #332222;
        color: #ffcc00;
        padding: 10px;
        border-radius: 5px;
        margin: 15px 0;
    }
    .student-name {
        color: #00adb5;
        font-weight: bold;
    }
    form {
        margin-top: 20px;
    }
    button {
        padding: 10px 20px;
        font-weight: bold;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        margin: 5px;
        transition: 0.2s;
    }
    .confirm {
        background-color: #f44336;
        color: #fff;
    }
    .confirm:hover {
        background-color: #c62828;
    }
    .cancel {
        background-color: #555;
        color: #fff;
    }
    .cancel:hover {
        background-color: #777;
    }
    a {
        color: #00adb5;
        text-decoration: none;
        display: inline-block;
        margin-top: 15px;
    }
    a:hover {
        text-decoration: underline;
    }
</style>
</head>
<body>

<div class="container">
    <h2>⚠️ Confirm Delete</h2>
    <p>Are you sure you want to permanently delete the record of:</p>
    <p class="student-name"><?= htmlspecialchars($student['fullname']); ?></p>
    <p class="warning">This action <strong>cannot be undone</strong>.</p>

    <form method="POST">
        <button type="submit" name="confirm" class="confirm">Yes, Delete</button>
        <a href="read.php" class="cancel">Cancel</a>
    </form>
</div>

</body>
</html>

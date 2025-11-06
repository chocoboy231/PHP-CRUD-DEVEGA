<?php
include 'db.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("<p style='color:red; text-align:center;'>❌ Error: Student ID not provided.<br><a href='read.php'>Back</a></p>");
}

$id = $_GET['id'];
$message = "";

try {
    $stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
    $stmt->execute([$id]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$student) {
        die("<p style='color:red; text-align:center;'>❌ Error: Student not found.<br><a href='read.php'>Back</a></p>");
    }
} catch (PDOException $e) {
    die("Error fetching record: " . $e->getMessage());
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $student_no = $_POST['student_no'];
    $fullname = $_POST['fullname'];
    $branch = $_POST['branch'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];

    try {
        $sql = "UPDATE students 
                SET student_no = ?, fullname = ?, branch = ?, email = ?, contact = ?
                WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$student_no, $fullname, $branch, $email, $contact, $id]);

        echo "<script>alert('✅ Student record updated successfully!'); window.location='read.php';</script>";
        exit;
    } catch (PDOException $e) {
        $message = "<p style='color:red;'>❌ Update failed: " . $e->getMessage() . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Student</title>
<style>
    body { font-family: Arial, sans-serif; background-color: #121212; color: #eee; display:flex; justify-content:center; align-items:center; height:100vh; }
    form { background:#1f1f1f; padding:25px; border-radius:10px; width:350px; }
    h2 { text-align:center; color:#00adb5; margin-bottom:15px; }
    label { font-weight:bold; margin-top:10px; display:block; }
    input, select { width:100%; padding:10px; border:none; border-radius:6px; margin-top:6px; background:#2c2c2c; color:white; }
    input[type="submit"] { background-color:#00adb5; color:#000; font-weight:bold; cursor:pointer; margin-top:15px; }
    input[type="submit"]:hover { background-color:#019aa1; }
    a { display:block; text-align:center; color:#00adb5; margin-top:15px; text-decoration:none; }
    a:hover { text-decoration:underline; }
</style>
</head>
<body>

<div>
    <h2>Edit Student</h2>
    <?= $message ?>

    <form method="POST">
        <label>Student No</label>
        <input type="text" name="student_no" value="<?= htmlspecialchars($student['student_no']); ?>" required>

        <label>Full Name</label>
        <input type="text" name="fullname" value="<?= htmlspecialchars($student['fullname']); ?>" required>

        <label>Branch</label>
        <select name="branch" required>
            <?php
            $branches = ['BSIT', 'BSCS', 'BSCE', 'BSECE'];
            foreach ($branches as $b) {
                $sel = ($student['branch'] === $b) ? 'selected' : '';
                echo "<option value='$b' $sel>$b</option>";
            }
            ?>
        </select>

        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($student['email']); ?>" required>

        <label>Contact</label>
        <input type="text" name="contact" value="<?= htmlspecialchars($student['contact']); ?>" required>

        <input type="submit" value="Update Record">
    </form>

    <a href="read.php">← Back to Student List</a>
</div>

</body>
</html>

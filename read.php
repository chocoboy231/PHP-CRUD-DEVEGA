<?php

include 'db.php';


try {
    $stmt = $pdo->query("SELECT * FROM students ORDER BY id DESC");
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching data: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>View Students</title>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #121212;
        color: #f0f0f0;
        margin: 0;
        padding: 40px;
    }
    h2 {
        text-align: center;
        color: #00adb5;
        margin-bottom: 20px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        background-color: #1f1f1f;
        border-radius: 10px;
        overflow: hidden;
    }
    th, td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #333;
    }
    th {
        background-color: #00adb5;
        color: #000;
    }
    tr:hover {
        background-color: #2c2c2c;
    }
    a.btn {
        padding: 6px 12px;
        color: white;
        border-radius: 5px;
        text-decoration: none;
        font-weight: bold;
    }
    a.edit {
        background-color: #4caf50;
    }
    a.delete {
        background-color: #f44336;
    }
    a.edit:hover {
        background-color: #3e8e41;
    }
    a.delete:hover {
        background-color: #c62828;
    }
    .back-link {
        display: block;
        text-align: center;
        margin-top: 20px;
        color: #00adb5;
        text-decoration: none;
    }
    .back-link:hover {
        text-decoration: underline;
    }
</style>
</head>

<body>
    <h2>Student Records</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Student No</th>
            <th>Full Name</th>
            <th>Branch</th>
            <th>Email</th>
            <th>Contact</th>
            <th>Date Added</th>
            <th>Actions</th>
        </tr>

        <?php if (count($students) > 0): ?>
            <?php foreach ($students as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']); ?></td>
                    <td><?= htmlspecialchars($row['student_no']); ?></td>
                    <td><?= htmlspecialchars($row['fullname']); ?></td>
                    <td><?= htmlspecialchars($row['branch']); ?></td>
                    <td><?= htmlspecialchars($row['email']); ?></td>
                    <td><?= htmlspecialchars($row['contact']); ?></td>
                    <td><?= htmlspecialchars($row['date_added']); ?></td>
                    <td>
                        <a href="update.php?id=<?= $row['id']; ?>" class="btn edit">Edit</a>
                        <a href="delete.php?id=<?= $row['id']; ?>" class="btn delete" onclick="return confirm('Are you sure you want to delete this record?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="8" style="text-align:center;">No student records found.</td>
            </tr>
        <?php endif; ?>
    </table>

    <a href="create.php" class="back-link">← Back to Homepage</a>
</body>
</html>

<?php

include 'db.php';

$message = "";
$errors = [];

$values = [
    'student_no' => '',
    'fullname'   => '',
    'branch'     => '',
    'email'      => '',
    'contact'    => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $values['student_no'] = trim(filter_input(INPUT_POST, 'student_no', FILTER_SANITIZE_STRING) ?? '');
    $values['fullname']   = trim(filter_input(INPUT_POST, 'fullname', FILTER_SANITIZE_STRING) ?? '');
    $values['branch']     = trim(filter_input(INPUT_POST, 'branch', FILTER_SANITIZE_STRING) ?? '');
    $values['email']      = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL) ?? '');
    $values['contact']    = trim(filter_input(INPUT_POST, 'contact', FILTER_SANITIZE_STRING) ?? '');

   
    if ($values['student_no'] === '') {
        $errors[] = "Student Number is required.";
    }
    if ($values['fullname'] === '') {
        $errors[] = "Full Name is required.";
    }
    if ($values['branch'] === '') {
        $errors[] = "Branch is required.";
    }
    if ($values['email'] === '' || !filter_var($values['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "A valid Email is required.";
    }
    if ($values['contact'] === '') {
        $errors[] = "Contact is required.";
    }

    if (empty($errors)) {
        try {
            $sql = "INSERT INTO students (student_no, fullname, branch, email, contact, date_added)
                    VALUES (:student_no, :fullname, :branch, :email, :contact, NOW())";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':student_no' => $values['student_no'],
                ':fullname'   => $values['fullname'],
                ':branch'     => $values['branch'],
                ':email'      => $values['email'],
                ':contact'    => $values['contact']
            ]);

            $message = "<p class='success'>✅ Student record added successfully.</p>";
            
            $values = array_map(fn($v) => '', $values);
        } catch (PDOException $e) {
       
            if ($e->getCode() == 23000) {
                $errors[] = "A record with that Student Number or Email already exists.";
            } else {
                $errors[] = "Database error: " . $e->getMessage();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Add Student</title>
<style>
    body { 
        font-family: Arial, sans-serif; 
        background: #121212; 
        color:  #eaeaea;
        margin: 0;
        min-height: 100vh;
        display: flex; 
        align-items:    center; 
        justify-content:    center; 
    }


    .card { 
        background: #1e1e1e; 
        padding:    24px; 
        border-radius:  10px; 
        width:  360px; 
        box-shadow: 0 6px 18px rgba(0,0,0,0.6); 
    }

    h2 { 
        color:  #00adb5;
        margin: 0 0 12px; 
        text-align: center; 
    }
        
    label { 
        display:    block; 
        margin-top: 10px; 
        font-weight:    600; 
        font-size:  14px; 
    }
    input, select { 
        width:  100%; 
        padding:    10px; 
        margin-top: 6px; 
        border-radius:  6px; 
        border: none; 
        background: #2c2c2c; 
        color:  #fff; 
        box-sizing: border-box; 
    }
    input[type="submit"] { 
        margin-top: 16px; 
        background: #00adb5; 
        color:  #051017; 
        font-weight:    700; 
        cursor: pointer; 
        border: none; 
        padding: 10px; 
    }
    .errors { 
        background: #331010; 
        border: 1px solid #5c1c1c; 
        color:  #ffb3b3; 
        padding:    8px 10px; 
        border-radius:  6px; 
        margin-bottom:  10px; 
    }
    .success { 
        background: #0f2f19; 
        border: 1px solid #235c32; 
        color:  #b7f0c8; 
        padding:    8px 10px; 
        border-radius:  6px; 
        margin-bottom:  10px; 
        text-align: center;}
    a { 
        display:    lock; 
        margin-top: 12px; 
        color:  #00adb5; 
        text-decoration:    none; 
        text-align: center; 
        }
</style>
</head>
<body>
  <div class="card">
    <h2>Add Student Record</h2>

    <?php
      if (!empty($errors)) {
          echo '<div class="errors"><ul style="margin:0 0 0 18px;padding:6px 0">';
          foreach ($errors as $err) echo "<li>" . htmlspecialchars($err) . "</li>";
          echo '</ul></div>';
      }
      echo $message;
    ?>

    <form method="post" action="">
        <label for="student_no">Student Number</label>
        <input id="student_no" name="student_no" type="text"
               value="<?php echo htmlspecialchars($values['student_no']); ?>" required>

        <label for="fullname">Full Name</label>
        <input id="fullname" name="fullname" type="text"
               value="<?php echo htmlspecialchars($values['fullname']); ?>" required>

        <label for="branch">Branch</label>
        <select id="branch" name="branch" required>
            <option value="">Select Branch</option>
            <?php
                $branches = ['BSIT','BSCS','BSCE','BSECE'];
                foreach ($branches as $b) {
                    $sel = ($values['branch'] === $b) ? 'selected' : '';
                    echo "<option value=\"" . htmlspecialchars($b) . "\" $sel>" . htmlspecialchars($b) . "</option>";
                }
            ?>
        </select>

        <label for="email">Email</label>
        <input id="email" name="email" type="email"
               value="<?php echo htmlspecialchars($values['email']); ?>" required>

        <label for="contact">Contact</label>
        <input id="contact" name="contact" type="text"
               value="<?php echo htmlspecialchars($values['contact']); ?>" required>

        <input type="submit" value="Save Student">
    </form>

    <a href="index.php">← Back to Homepage</a>
  </div>
</body>
</html>

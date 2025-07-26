<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'ucaa_library');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'];
    $staff_id = $_POST['staff_id'];
    $department = $_POST['department'];
    $contact = $_POST['contact'];
    $email = trim($_POST['email']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } else {
        $check = $conn->prepare("SELECT id FROM borrowers WHERE staff_id = ? OR email = ?");
        $check->bind_param("ss", $staff_id, $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $error = "Borrower with this Staff ID or Email already exists.";
        } else {
            $stmt = $conn->prepare("INSERT INTO borrowers (full_name, staff_id, department, contact, email) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $full_name, $staff_id, $department, $contact, $email);
            if ($stmt->execute()) {
                $success = "Borrower registered successfully!";
            } else {
                $error = "Failed to register borrower.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register Borrower</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f4f8;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .form-container {
            background-color: #fff;
            padding: 35px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0,0,0,0.1);
            width: 400px;
        }

        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 25px;
        }

        input[type="text"], input[type="email"] {
            width: 100%;
            padding: 12px 14px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
        }

        button {
            width: 100%;
            background-color: #2980b9;
            color: white;
            padding: 12px;
            margin-top: 10px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #1c5980;
        }

        .message {
            text-align: center;
            margin-bottom: 15px;
        }

        .message.success {
            color: green;
        }

        .message.error {
            color: red;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 15px;
            text-decoration: none;
            color: #2980b9;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="form-container">
    <h2>Register Borrower</h2>

    <?php if ($success): ?>
        <div class="message success"><?= htmlspecialchars($success) ?></div>
    <?php elseif ($error): ?>
        <div class="message error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" action="">
        <input type="text" name="full_name" placeholder="Full Name" required>
        <input type="text" name="staff_id" placeholder="Staff ID or National ID" required>
        <input type="text" name="department" placeholder="Department (optional)">
        <input type="text" name="contact" placeholder="Phone (optional)">
        <input type="email" name="email" placeholder="Email Address" required>
        <button type="submit">Register Borrower</button>
    </form>

    <a href="dashboard.php">← Back to Dashboard</a>
</div>
</body>
</html>

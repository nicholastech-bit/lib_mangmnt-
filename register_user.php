<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
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
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Check if username already exists
    $check = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $check->bind_param("s", $username);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $error = "Username already taken.";
    } else {
        $hashed_password = hash('sha256', $password);
        $stmt = $conn->prepare("INSERT INTO users (full_name, username, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $full_name, $username, $hashed_password, $role);
        if ($stmt->execute()) {
            $success = "User registered successfully!";
        } else {
            $error = "Failed to register user.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Register Attendant/Admin</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #4a90e2, #50e3c2);
            margin: 0;
            padding: 40px 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #333;
        }

        form {
            background-color: #ffffff;
            padding: 40px 50px;
            border-radius: 16px;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 420px;
            box-sizing: border-box;
            transition: transform 0.3s ease;
        }

        form:hover {
            transform: translateY(-8px);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #1e3a8a;
            font-weight: 700;
            letter-spacing: 1px;
        }

        input, select, button {
            width: 100%;
            padding: 14px 18px;
            margin: 14px 0;
            border-radius: 8px;
            border: 1.5px solid #ddd;
            font-size: 16px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            box-sizing: border-box;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #1e3a8a;
            box-shadow: 0 0 8px rgba(30, 58, 138, 0.6);
        }

        button {
            background-color: #1e3a8a;
            color: white;
            font-weight: 700;
            border: none;
            cursor: pointer;
            margin-top: 20px;
            letter-spacing: 0.05em;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #1452a0;
        }

        a {
            display: block;
            margin-top: 20px;
            text-align: center;
            color: #1e3a8a;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        a:hover {
            color: #103d75;
            text-decoration: underline;
        }

        p {
            text-align: center;
            font-weight: 700;
            font-size: 1.1em;
        }

        .success {
            color: #2e7d32;
        }

        .error {
            color: #c62828;
        }
    </style>
</head>
<body>
    <form method="post" action="">
        <h2>Register New User (Attendant/Admin)</h2>

        <?php
        if ($success) echo "<p class='success'>$success</p>";
        if ($error) echo "<p class='error'>$error</p>";
        ?>

        <input type="text" name="full_name" placeholder="Full Name" required />
        <input type="text" name="username" placeholder="Username" required />
        <input type="password" name="password" placeholder="Password" required />
        <select name="role" required>
            <option value="" disabled selected>Select Role</option>
            <option value="attendant">Attendant</option>
            <option value="admin">Admin</option>
        </select>
        <button type="submit">Register User</button>

        <p><a href="dashboard.php">← Back to Dashboard</a></p>
    </form>
</body>
</html>

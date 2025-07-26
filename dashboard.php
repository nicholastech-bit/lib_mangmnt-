<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard - UCAA Library</title>
    <style>
        /* Reset some default styles */
        body, h2, p, ul {
            margin: 0; padding: 0;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f7f9;
            color: #333;
            padding: 40px 20px;
            text-align: center;
        }
        .logo {
            height: 80px;
            margin-bottom: 20px;
        }
        h2 {
            color: #2c3e50;
            margin-bottom: 10px;
        }
        p {
            font-size: 18px;
            margin-bottom: 30px;
        }
        strong {
            color: #2980b9;
        }
        ul {
            list-style: none;
            max-width: 400px;
            margin: 0 auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            padding: 20px;
        }
        ul li {
            margin-bottom: 15px;
        }
        ul li:last-child {
            margin-bottom: 0;
        }
        ul li a {
            display: block;
            padding: 12px 18px;
            background-color: #2980b9;
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }
        ul li a:hover {
            background-color: #1f6391;
        }
        /* Responsive tweaks */
        @media (max-width: 480px) {
            body {
                padding: 20px 10px;
            }
            ul {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>

    <!-- UCAA Logo -->
    <img src="/lib_management_system/images/uganda-civil-aviation-authority-caa-seeklogo.png" alt="UCAA Logo" class="logo" />

    <h2>Welcome to UCAA Library System</h2>
    <p>Hello, <strong><?= htmlspecialchars($username) ?></strong> (<?= htmlspecialchars($role) ?>)</p>

    <ul>
        <?php if ($role == 'admin'): ?>
            <li><a href="register_user.php">Register Attendant</a></li>
        <?php endif; ?>

        <li><a href="register_borrower.php">Register Borrower</a></li>
        <li><a href="manage_books.php">Manage Books</a></li>
        <li><a href="issue_book.php">Issue Books</a></li>
        <li><a href="return_books.php">Return Books</a></li>
        <li><a href="view_issued_books.php">View Borrowed Books</a></li>
        <li><a href="search_all.php">Search books and borrowers</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>

</body>
</html>


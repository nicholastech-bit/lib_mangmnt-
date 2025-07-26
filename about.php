<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>About - UCAA Library System</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f9ff;
            color: #1e293b;
        }

        header {
            background-color: #1e3a8a;
            padding: 20px;
            color: white;
            text-align: center;
        }

        nav {
            display: flex;
            justify-content: center;
            background-color: #3b82f6;
            padding: 10px 0;
        }

        nav a {
            color: white;
            margin: 0 20px;
            text-decoration: none;
            font-weight: bold;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .about-section {
            max-width: 900px;
            margin: 40px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        .about-section h2 {
            color: #1e3a8a;
            margin-bottom: 15px;
        }

        .about-section p {
            line-height: 1.8;
            margin-bottom: 20px;
        }

        footer {
            background-color: #1e3a8a;
            color: white;
            text-align: center;
            padding: 10px;
        }
    </style>
</head>
<body>

    <header>
        <h1>About UCAA Library System</h1>
    </header>

    <nav>
        <a href="index.php">Home</a>
        <a href="login.php">Login</a>
        <a href="about.php">About</a>
        <a href="contact.php">Contact</a>
    </nav>

    <section class="about-section">
        <h2>What is UCAA Library Management System?</h2>
        <p>
            The UCAA Library Management System is a digital platform developed to help the Uganda Civil Aviation Authority manage its library resources efficiently. It allows administrators and attendants to organize books, track borrowing activities, manage users, and maintain an up-to-date catalog.
        </p>

        <h2>Key Features</h2>
        <ul>
            <li>Book and borrower management</li>
            <li>Borrowing and return tracking</li>
            <li>Admin and attendant login</li>
            <li>Search and filter capabilities</li>
            <li>Email notifications (optional)</li>
        </ul>

        <h2>Our Vision</h2>
        <p>
            To provide a modern, accessible, and efficient library system that supports aviation research, learning, and development within UCAA.
        </p>
    </section>

    <footer>
        &copy; <?php echo date("Y"); ?> Uganda Civil Aviation Authority Library. All rights reserved.
    </footer>

</body>
</html>

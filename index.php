<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>UCAA Library System - Home</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #ffffff;
            background-image: url('/lib_management_system/images/uganda-civil-aviation-authority-caa-seeklogo.png');
            background-repeat: no-repeat;
            background-position: center center;
            background-size: 250px; /* adjust size */
            background-attachment: fixed;
            height: 100vh;
            display: flex;
            flex-direction: column;
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

        .hero {
            flex-grow: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 40px;
        }

        .hero-content {
            background-color: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        }

        .hero-content h1 {
            color: #1e3a8a;
            margin-bottom: 20px;
        }

        .hero-content p {
            color: #4b5563;
            margin-bottom: 30px;
        }

        .hero-content a {
            background-color: #1e3a8a;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .hero-content a:hover {
            background-color: #3749b4;
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
        <h1>UCAA Library Management System</h1>
    </header>

    <nav>
        <a href="index.php">Home</a>
        <a href="login.php">Login</a>
        <a href="about.php">About</a>
        <a href="contactus.php">Contact</a>
    </nav>

    <section class="hero">
        <div class="hero-content">
            
            <a href="login.php">Get Started</a>
        </div>
    </section>

    <footer>
        &copy; <?php echo date("Y"); ?> Uganda Civil Aviation Authority Library. All rights reserved.
    </footer>

</body>
</html>

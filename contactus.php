<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact - UCAA Library System</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f3f4f6;
            color: #1e293b;
        }

        header {
            background-color: #1e3a8a;
            padding: 20px;
            text-align: center;
            color: white;
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

        .contact-section {
            max-width: 800px;
            margin: 40px auto;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .contact-section h2 {
            color: #1e3a8a;
            margin-bottom: 20px;
        }

        .contact-section p {
            margin-bottom: 20px;
            line-height: 1.7;
        }

        .contact-info {
            line-height: 1.8;
        }

        footer {
            background-color: #1e3a8a;
            color: white;
            text-align: center;
            padding: 12px;
        }
    </style>
</head>
<body>

    <header>
        <h1>Contact Us</h1>
    </header>

    <nav>
        <a href="index.php">Home</a>
        <a href="login.php">Login</a>
        <a href="about.php">About</a>
        <a href="contactus.php">Contact</a>
    </nav>

    <section class="contact-section">
        <h2>How to Reach Us</h2>
        <p>If you have any questions, suggestions, or need help with the UCAA Library Management System, feel free to get in touch with us using the details below:</p>
        
        <div class="contact-info">
            <strong>Address:</strong>  
            <br>Uganda Civil Aviation Authority Headquarters  
            <br>Entebbe, Uganda  

            <br><br><strong>Email:</strong>  
            <br><a href="mailto:library@ucaa.go.ug">library@ucaa.go.ug</a>  

            <br><br><strong>Phone:</strong>  
            <br>+256 414 321 000  
        </div>
    </section>

    <footer>
        &copy; <?php echo date("Y"); ?> Uganda Civil Aviation Authority Library. All rights reserved.
    </footer>

</body>
</html>

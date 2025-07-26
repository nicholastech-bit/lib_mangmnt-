<?php
session_start();
include('config/db.php');

// Only attendants or admin can access
if (!isset($_SESSION['role']) || ($_SESSION['role'] != 'attendant' && $_SESSION['role'] != 'admin')) {
    header("Location: login.php");
    exit();
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $isbn = mysqli_real_escape_string($conn, $_POST['isbn']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $copies = (int) $_POST['copies'];

    $check = mysqli_query($conn, "SELECT * FROM books WHERE title = '$title' AND author = '$author'");

    if (isset($_POST['add'])) {
        if (mysqli_num_rows($check) > 0) {
            $message = "❌ Book already exists! Use 'Update Existing Book' instead.";
        } else {
            mysqli_query($conn, "INSERT INTO books (title, author, isbn, location, total_copies, available_copies) 
                                 VALUES ('$title', '$author', '$isbn', '$location', $copies, $copies)");
            $message = "✅ New book added successfully!";
        }
    }

    if (isset($_POST['update'])) {
        if (mysqli_num_rows($check) > 0) {
            mysqli_query($conn, "UPDATE books 
                                 SET total_copies = total_copies + $copies, 
                                     available_copies = available_copies + $copies 
                                 WHERE title = '$title' AND author = '$author'");
            $message = "✅ Book record updated successfully!";
        } else {
            $message = "❌ Book not found. Use 'Add New Book' instead.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Books - UCAA Library</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f0f4f8;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            border-radius: 10px;
        }

        h2 {
            text-align: center;
            color: #004080;
        }

        form label {
            font-weight: bold;
            display: block;
            margin-top: 15px;
        }

        form input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .btn-group {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }

        button {
            margin-top: 20px;
            background-color: #004080;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            flex: 1;
            font-weight: bold;
        }

        .message {
            text-align: center;
            font-weight: bold;
            margin-top: 10px;
            color: green;
        }

        .message.error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Manage Books</h2>

        <?php if ($message): ?>
            <p class="message <?php echo (str_starts_with($message, '❌')) ? 'error' : ''; ?>">
                <?php echo $message; ?>
            </p>
        <?php endif; ?>

        <form method="POST">
            <label>Title:</label>
            <input type="text" name="title" required>

            <label>Author:</label>
            <input type="text" name="author" required>

            <label>ISBN:</label>
            <input type="text" name="isbn">

            <label>Location:</label>
            <input type="text" name="location">

            <label>Number of Copies:</label>
            <input type="number" name="copies" min="1" required>

            <div class="btn-group">
                <button type="submit" name="add">Add New Book</button>
                <button type="submit" name="update" style="background-color: #008000;">Update Existing Book</button>
            </div>
        </form>
    </div>
</body>
</html>

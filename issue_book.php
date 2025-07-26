<?php
session_start();
include('config/db.php');

// Only attendants or admin can access
if (!isset($_SESSION['role']) || ($_SESSION['role'] != 'attendant' && $_SESSION['role'] != 'admin')) {
    header("Location: login.php");
    exit();
}

// Fetch borrowers and books
$borrowers = mysqli_query($conn, "SELECT * FROM borrowers");
$books = mysqli_query($conn, "SELECT * FROM books WHERE available_copies > 0");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $book_id = $_POST['book_id'];
    $borrower_id = $_POST['borrower_id'];
    $issue_date = date('Y-m-d');

    // Insert issue record
    $insert = "INSERT INTO issued_books (book_id, borrower_id, issue_date) VALUES ('$book_id', '$borrower_id', '$issue_date')";
    mysqli_query($conn, $insert);

    // Update book available_copies
    mysqli_query($conn, "UPDATE books SET available_copies = available_copies - 1 WHERE id = '$book_id'");

    echo "<script>alert('Book Issued Successfully'); window.location='issue_book.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Issue Book - UCAA Library</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #4a90e2, #50e3c2);
            padding: 40px 20px;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        form {
            background: #fff;
            padding: 35px 40px;
            border-radius: 16px;
            box-shadow: 0 12px 24px rgba(0,0,0,0.15);
            max-width: 480px;
            width: 100%;
            box-sizing: border-box;
            transition: transform 0.3s ease;
        }
        form:hover {
            transform: translateY(-8px);
        }
        h2 {
            color: #1e3a8a;
            margin-bottom: 30px;
            text-align: center;
            font-weight: 700;
            letter-spacing: 1px;
        }
        label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #34495e;
            font-size: 16px;
        }
        select {
            width: 100%;
            padding: 14px 18px;
            border: 1.5px solid #ddd;
            border-radius: 8px;
            margin-bottom: 25px;
            font-size: 16px;
            box-sizing: border-box;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        select:focus {
            border-color: #1e3a8a;
            outline: none;
            box-shadow: 0 0 8px rgba(30, 58, 138, 0.6);
        }
        button {
            background-color: #1e3a8a;
            color: white;
            padding: 14px 0;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: 700;
            cursor: pointer;
            width: 100%;
            letter-spacing: 0.05em;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #1452a0;
        }
        @media (max-width: 600px) {
            body {
                padding: 20px 10px;
            }
            form {
                width: 100%;
            }
        }
    </style>
</head>
<body>

<form method="POST" action="">
    <h2>Issue Book</h2>

    <label for="borrower_id">Borrower:</label>
    <select name="borrower_id" id="borrower_id" required>
        <option value="">-- Select Borrower --</option>
        <?php while($b = mysqli_fetch_assoc($borrowers)) : ?>
            <option value="<?= htmlspecialchars($b['id']) ?>"><?= htmlspecialchars($b['full_name']) ?></option>
        <?php endwhile; ?>
    </select>

    <label for="book_id">Book:</label>
    <select name="book_id" id="book_id" required>
        <option value="">-- Select Book --</option>
        <?php while($bk = mysqli_fetch_assoc($books)) : ?>
            <option value="<?= htmlspecialchars($bk['id']) ?>"><?= htmlspecialchars($bk['title']) ?> by <?= htmlspecialchars($bk['author']) ?></option>
        <?php endwhile; ?>
    </select>

    <button type="submit">Issue Book</button>
</form>

</body>
</html>

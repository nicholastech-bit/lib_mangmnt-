<?php
session_start();
include('config/db.php');

// Only allow admin or attendant
if (!isset($_SESSION['role']) || ($_SESSION['role'] != 'attendant' && $_SESSION['role'] != 'admin')) {
    header("Location: login.php");
    exit();
}

// Handle return action
if (isset($_GET['issue_id'])) {
    $issue_id = intval($_GET['issue_id']);

    // Get the book_id for this issue record
    $result = mysqli_query($conn, "SELECT book_id FROM issued_books WHERE issue_id = $issue_id AND status = 'Issued'");
    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $book_id = $row['book_id'];

        // Update issued_books table: set status to Returned and return_date to today
        $today = date('Y-m-d');
        mysqli_query($conn, "UPDATE issued_books SET status = 'Returned', return_date = '$today' WHERE issue_id = $issue_id");

        // Increase available_copies in books table by 1
        mysqli_query($conn, "UPDATE books SET available_copies = available_copies + 1 WHERE id = $book_id");

        echo "<script>alert('Book returned successfully'); window.location='return_books.php';</script>";
        exit();
    }
}

// Fetch all issued books with status 'Issued'
$query = "
    SELECT ib.issue_id, b.title, br.full_name, ib.issue_date
    FROM issued_books ib
    JOIN books b ON ib.book_id = b.id
    JOIN borrowers br ON ib.borrower_id = br.id
    WHERE ib.status = 'Issued'
    ORDER BY ib.issue_date DESC
";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Return Books - UCAA Library</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f2f5;
            padding: 30px 20px;
            color: #333;
        }
        h2 {
            color: #2c3e50;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 6px 15px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            padding: 14px 18px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }
        th {
            background-color: #28a745;
            color: white;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        tr:hover {
            background-color: #f9f9f9;
        }
        a.return-btn {
            padding: 8px 16px;
            background: #dc3545;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            transition: background-color 0.3s ease;
            display: inline-block;
        }
        a.return-btn:hover {
            background: #b02a37;
        }
        p {
            font-size: 18px;
            color: #555;
        }
        @media (max-width: 600px) {
            body {
                padding: 15px 10px;
            }
            table, th, td {
                font-size: 14px;
            }
            a.return-btn {
                padding: 6px 10px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

<h2>Return Books</h2>

<?php if (mysqli_num_rows($result) > 0): ?>
<table>
    <thead>
    <tr>
        <th>#</th>
        <th>Book Title</th>
        <th>Borrower</th>
        <th>Issue Date</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php $i=1; while($row = mysqli_fetch_assoc($result)): ?>
    <tr>
        <td><?= $i++ ?></td>
        <td><?= htmlspecialchars($row['title']) ?></td>
        <td><?= htmlspecialchars($row['full_name']) ?></td>
        <td><?= $row['issue_date'] ?></td>
        <td><a class="return-btn" href="return_books.php?issue_id=<?= $row['issue_id'] ?>" onclick="return confirm('Mark this book as returned?');">Return</a></td>
    </tr>
    <?php endwhile; ?>
    </tbody>
</table>
<?php else: ?>
<p>No books currently issued.</p>
<?php endif; ?>

</body>
</html>

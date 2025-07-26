<?php
include 'config/db.php'; // Adjust the path if necessary

$query = "
    SELECT 
        ib.issue_id,
        b.title AS book_title,
        br.full_name AS borrower_name,
        ib.issue_date,
        ib.return_date,
        ib.status
    FROM issued_books ib
    JOIN books b ON ib.book_id = b.id
    JOIN borrowers br ON ib.borrower_id = br.id
    ORDER BY ib.issue_date DESC
";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Issued Books List</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f6f8;
            padding: 30px;
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
        }
        .notification-bar {
            margin-bottom: 20px;
            text-align: right;
        }
        .btn {
            padding: 10px 18px;
            font-size: 16px;
            color: white;
            background-color: #28a745;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
        }
        .btn:hover {
            background-color: #218838;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        th, td {
            padding: 14px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: #fff;
        }
        tr:hover {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>

<h2>Issued Books List</h2>

<div class="notification-bar">
    <a href="send_notification.php" class="btn">Send Notifications</a>
</div>

<table>
    <tr>
        <th></th>
        <th>Book Title</th>
        <th>Borrower Name</th>
        <th>Issue Date</th>
        <th>Return Date</th>
        <th>Status</th>
    </tr>

    <?php if (mysqli_num_rows($result) > 0): 
        $i = 1;
        while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= $i++ ?></td>
            <td><?= htmlspecialchars($row['book_title']) ?></td>
            <td><?= htmlspecialchars($row['borrower_name']) ?></td>
            <td><?= $row['issue_date'] ?></td>
            <td><?= $row['return_date'] ?? 'Not Returned' ?></td>
            <td><?= $row['status'] ?></td>
        </tr>
    <?php endwhile; else: ?>
        <tr><td colspan="6">No books issued yet.</td></tr>
    <?php endif; ?>
</table>

</body>
</html>

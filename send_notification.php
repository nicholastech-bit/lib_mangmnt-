<?php
require 'vendor/autoload.php';  // Composer autoload for PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include('config/db.php');

// Select books issued 14+ days ago and still marked as "Issued"
$query = "
SELECT ib.issue_id, ib.issue_date, b.title, br.full_name, br.email
FROM issued_books ib
JOIN books b ON ib.book_id = b.id
JOIN borrowers br ON ib.borrower_id = br.id
WHERE ib.status = 'Issued'
AND DATEDIFF(CURDATE(), ib.issue_date) >= 14
";

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error fetching overdue books: " . mysqli_error($conn));
}

while ($row = mysqli_fetch_assoc($result)) {
    $mail = new PHPMailer(true);

    try {
        // SMTP setup
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'kamusiimen8@gmail.com'; // Replace with your Gmail
        $mail->Password   = 'yqxsqfrldbbdmboz';       // App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Sender & recipient
        $mail->setFrom('kamusiimen8@gmail.com', 'UCAA Library');
        $mail->addAddress($row['email'], $row['full_name']);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'Overdue Book Reminder';
        $mail->Body    = "
            Dear " . htmlspecialchars($row['full_name']) . ",<br><br>
            Our records show that the book <strong>\"" . htmlspecialchars($row['title']) . "\"</strong>, 
            which you borrowed on <strong>" . $row['issue_date'] . "</strong>, is overdue by 14 days or more.<br>
            Kindly return it as soon as possible to avoid penalties.<br><br>
            Regards,<br>
            <strong>UCAA Library</strong>
        ";

        $mail->send();
        echo "✅ Overdue notice sent to " . htmlspecialchars($row['email']) . "<br>";
    } catch (Exception $e) {
        echo "❌ Failed to send to " . htmlspecialchars($row['email']) . ". Error: {$mail->ErrorInfo}<br>";
    }
}

echo "<br><strong>✅ All 14-day overdue notifications processed.</strong>";
?>

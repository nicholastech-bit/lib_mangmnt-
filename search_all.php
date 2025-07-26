<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "ucaa_library");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$search = isset($_GET['query']) ? trim($_GET['query']) : "";
$filter = isset($_GET['filter']) ? $_GET['filter'] : "all";
$books = [];
$borrowers = [];

if ($search !== "") {
    $like = "%" . $search . "%";

    // Search books
    if ($filter === "all" || $filter === "books") {
        $stmt = $conn->prepare("SELECT * FROM books WHERE title LIKE ? OR author LIKE ?");
        $stmt->bind_param("ss", $like, $like);
        $stmt->execute();
        $books = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Search borrowers
    if ($filter === "all" || $filter === "borrowers") {
        $stmt = $conn->prepare("SELECT * FROM borrowers WHERE full_name LIKE ? OR staff_id LIKE ?");
        $stmt->bind_param("ss", $like, $like);
        $stmt->execute();
        $borrowers = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Search Books and Borrowers</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <style>
        /* Reset and base styles */
        * {
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #4a90e2, #50e3c2);
            color: #333;
            margin: 0;
            padding: 40px 20px;
            display: flex;
            justify-content: center;
            min-height: 100vh;
        }
        .container {
            background-color: #fff;
            max-width: 750px;
            width: 100%;
            padding: 30px 40px;
            border-radius: 16px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.12);
        }
        h2 {
            text-align: center;
            color: #1e3a8a;
            margin-bottom: 30px;
            font-weight: 700;
            letter-spacing: 1px;
        }
        form {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
            margin-bottom: 30px;
        }
        input[type="text"], select {
            padding: 14px 18px;
            font-size: 16px;
            border-radius: 8px;
            border: 1.5px solid #ddd;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            font-family: inherit;
        }
        input[type="text"] {
            flex: 1 1 60%;
            min-width: 200px;
        }
        select {
            flex: 0 0 150px;
            min-width: 120px;
        }
        input[type="text"]:focus, select:focus {
            border-color: #1e3a8a;
            box-shadow: 0 0 10px rgba(30, 58, 138, 0.6);
            outline: none;
        }
        button {
            background-color: #1e3a8a;
            color: white;
            font-weight: 700;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            padding: 14px 30px;
            font-size: 16px;
            flex: 0 0 auto;
            transition: background-color 0.3s ease;
            align-self: center;
        }
        button:hover {
            background-color: #1452a0;
        }
        h3 {
            color: #1e3a8a;
            margin-top: 20px;
            margin-bottom: 15px;
            font-weight: 700;
        }
        h4 {
            margin-bottom: 10px;
            color: #2980b9;
            font-weight: 600;
        }
        ul {
            list-style: none;
            padding-left: 0;
            margin-bottom: 20px;
        }
        ul li {
            background-color: #ecf0f1;
            margin-bottom: 10px;
            padding: 12px 18px;
            border-radius: 8px;
            box-shadow: 1px 1px 8px rgba(0,0,0,0.05);
            font-size: 16px;
        }
        .no-result {
            color: #c0392b;
            font-weight: 700;
            font-size: 18px;
            text-align: center;
            margin-top: 30px;
        }

        /* Responsive adjustments */
        @media (max-width: 600px) {
            .container {
                padding: 20px;
            }
            form {
                flex-direction: column;
                gap: 15px;
            }
            input[type="text"], select, button {
                flex: 1 1 100%;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Search Books or Borrowers</h2>
    <form method="get" action="">
        <input
            type="text"
            name="query"
            placeholder="Enter title, author, name or ID"
            value="<?= htmlspecialchars($search) ?>"
            required
        />
        <select name="filter">
            <option value="all" <?= $filter === "all" ? "selected" : "" ?>>All</option>
            <option value="books" <?= $filter === "books" ? "selected" : "" ?>>Books Only</option>
            <option value="borrowers" <?= $filter === "borrowers" ? "selected" : "" ?>>Borrowers Only</option>
        </select>
        <button type="submit">Search</button>
    </form>

    <?php if ($search !== ""): ?>
        <h3>Results for "<?= htmlspecialchars($search) ?>"</h3>

        <?php if (!empty($books)): ?>
            <h4>Books:</h4>
            <ul>
                <?php foreach ($books as $book): ?>
                    <li>
                        <strong><?= htmlspecialchars($book['title']) ?></strong> by <?= htmlspecialchars($book['author']) ?> |
                        Available: <?= (int)$book['available_copies'] ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <?php if (!empty($borrowers)): ?>
            <h4>Borrowers:</h4>
            <ul>
                <?php foreach ($borrowers as $b): ?>
                    <li>
                        <?= htmlspecialchars($b['full_name']) ?> (Staff ID: <?= htmlspecialchars($b['staff_id']) ?>)
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <?php if (empty($books) && empty($borrowers)): ?>
            <p class="no-result">No matches found.</p>
        <?php endif; ?>
    <?php endif; ?>
</div>
</body>
</html>

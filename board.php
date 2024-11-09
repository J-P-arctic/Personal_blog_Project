<?php
session_start();
$servername = "localhost";
$username = "myappuser";
$password = "mypassword123";
$dbname = "myapp";

$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8mb4");

// 페이징 처리
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 10;
$start = ($page - 1) * $per_page;
?>

<!DOCTYPE html>
<html>
<head>
    <title>게시판</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f0f0f0;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
        }
        .write-btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 20px;
        }
        .pagination {
            margin-top: 20px;
            text-align: center;
        }
        .pagination a {
            padding: 5px 10px;
            margin: 0 5px;
            border: 1px solid #ddd;
            text-decoration: none;
            color: #333;
        }
        .pagination a.active {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>게시판</h1>
        
        <?php if (isset($_SESSION['username'])): ?>
            <a href="write.php" class="write-btn">글쓰기</a>
        <?php endif; ?>

        <table>
            <tr>
                <th>번호</th>
                <th>제목</th>
                <th>작성자</th>
                <th>작성일</th>
            </tr>
            <?php
            $result = $conn->query("SELECT posts.*, users.username 
                                  FROM posts 
                                  JOIN users ON posts.user_id = users.id 
                                  ORDER BY created_at DESC 
                                  LIMIT $start, $per_page");

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td><a href='view.php?id=" . $row['id'] . "'>" . 
                     htmlspecialchars($row['title']) . "</a></td>";
                echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                echo "<td>" . date('Y-m-d', strtotime($row['created_at'])) . "</td>";
                echo "</tr>";
            }
            ?>
        </table>

        <?php
        // 페이징 처리
        $total_result = $conn->query("SELECT COUNT(*) as count FROM posts");
        $total_row = $total_result->fetch_assoc();
        $total_pages = ceil($total_row['count'] / $per_page);

        echo "<div class='pagination'>";
        for ($i = 1; $i <= $total_pages; $i++) {
            if ($i == $page) {
                echo "<a href='?page=$i' class='active'>$i</a>";
            } else {
                echo "<a href='?page=$i'>$i</a>";
            }
        }
        echo "</div>";
        ?>
    </div>
</body>
</html>


<?php
session_start();
$servername = "localhost";
$username = "myappuser";
$password = "mypassword123";
$dbname = "myapp";

$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8mb4");
?>

<!DOCTYPE html>
<html>
<head>
    <title>My First Website</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }
        .header {
            background-color: white;
            padding: 10px 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .nav {
            text-align: right;
            padding: 10px;
            <a href="board.php">게시판</a>
        }
        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .guestbook {
            margin-top: 20px;
        }
        .message {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }
        form {
            margin-top: 20px;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .logout {
            color: #666;
            text-decoration: none;
            margin-left: 10px;
        }
        .logout:hover {
            color: #333;
        }
    </style>
</head>
<body>
    <div class="header">
       <div class="nav">
    <?php if (isset($_SESSION['username'])): ?>
        안녕하세요, <?php echo htmlspecialchars($_SESSION['username']); ?>님! 
        <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
            <a href="admin.php">관리자 페이지</a> |
        <?php endif; ?>
        <a href="board.php">게시판</a> |     <!-- 이 줄 추가 -->
        <a href="logout.php">로그아웃</a>
    <?php else: ?>
        <a href="login.php">로그인</a> | 
        <a href="register.php">회원가입</a>
    <?php endif; ?>
</div>
    </div>

    <div class="container">
        <h1>환영합니다!</h1>
        
        <?php if (isset($_SESSION['username'])): ?>
            <div class="guestbook">
                <h2>방명록 작성</h2>
                <form method="post">
                    <textarea name="message" rows="4" required placeholder="메시지를 입력하세요..."></textarea>
                    <input type="submit" value="등록">
                </form>
            </div>
        <?php else: ?>
            <p>방명록을 작성하시려면 로그인해주세요.</p>
        <?php endif; ?>

        <div class="guestbook">
            <h2>방명록 목록</h2>
            <?php
            $sql = "SELECT guestbook.*, users.username 
                   FROM guestbook 
                   JOIN users ON guestbook.user_id = users.id 
                   ORDER BY created_at DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<div class='message'>";
                    echo "<h3>" . htmlspecialchars($row['username']) . "</h3>";
                    echo "<p>" . htmlspecialchars($row['message']) . "</p>";
                    echo "<small>작성시간: " . $row['created_at'] . "</small>";
                    echo "</div>";
                }
            } else {
                echo "<p>아직 작성된 메시지가 없습니다.</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>

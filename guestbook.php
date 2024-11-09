<!DOCTYPE html>
<html>
<head>
    <title>방명록</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f0f0f0;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            max-width: 800px;
            margin: 0 auto;
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
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>방명록</h1>
        
        <!-- 입력 폼 -->
        <form method="post">
            <div>
                <label for="name">이름:</label>
                <input type="text" name="name" required>
            </div>
            <div>
                <label for="message">메시지:</label>
                <textarea name="message" rows="4" required></textarea>
            </div>
            <input type="submit" value="등록">
        </form>

        <h2>메시지 목록</h2>
        <?php
        $servername = "localhost";
        $username = "myappuser";
        $password = "mypassword123";
        $dbname = "myapp";

        // 데이터베이스 연결
        $conn = new mysqli($servername, $username, $password, $dbname);
        $conn->set_charset("utf8mb4");

        // POST 데이터 처리
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $conn->real_escape_string($_POST['name']);
            $message = $conn->real_escape_string($_POST['message']);
            
            $sql = "INSERT INTO guestbook (name, message) VALUES ('$name', '$message')";
            $conn->query($sql);
        }

        // 메시지 목록 표시
        $sql = "SELECT * FROM guestbook ORDER BY created_at DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='message'>";
                echo "<h3>" . htmlspecialchars($row['name']) . "</h3>";
                echo "<p>" . htmlspecialchars($row['message']) . "</p>";
                echo "<small>작성시간: " . $row['created_at'] . "</small>";
                echo "</div>";
            }
        } else {
            echo "<p>아직 작성된 메시지가 없습니다.</p>";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>

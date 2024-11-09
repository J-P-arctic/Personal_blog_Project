<?php
session_start();
$servername = "localhost";
$username = "myappuser";
$password = "mypassword123";
$dbname = "myapp";

$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8mb4");

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];
    
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);
    
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['is_admin'] = $user['is_admin'];
            
            // 로그인 성공 후 메인 페이지로 이동
            header("Location: index.php");
            exit();
        } else {
            $error = "비밀번호가 일치하지 않습니다.";
        }
    } else {
        $error = "존재하지 않는 사용자입니다.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>로그인</title>
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
            max-width: 400px;
            margin: 0 auto;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 8px;
            margin: 5px 0 20px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        .error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>로그인</h2>
        <?php if ($error): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="post">
            <div>
                <label for="username">사용자명:</label>
                <input type="text" name="username" required>
            </div>
            <div>
                <label for="password">비밀번호:</label>
                <input type="password" name="password" required>
            </div>
            <input type="submit" value="로그인">
        </form>
        <p>계정이 없으신가요? <a href="register.php">회원가입</a></p>
    </div>
</body>
</html>

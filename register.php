<?php
session_start();
$servername = "localhost";
$username = "myappuser";
$password = "mypassword123";
$dbname = "myapp";

$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8mb4");

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    // 중복 체크
    $check = $conn->query("SELECT * FROM users WHERE username='$username' OR email='$email'");
    if ($check->num_rows > 0) {
        $error = "이미 존재하는 사용자명 또는 이메일입니다.";
    } else {
        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
        if ($conn->query($sql)) {
            $success = "회원가입이 완료되었습니다!";
        } else {
            $error = "오류가 발생했습니다: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>회원가입</title>
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
        input[type="text"], input[type="email"], input[type="password"] {
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
        .success {
            color: green;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>회원가입</h2>
        <?php if ($error): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <?php if ($success): ?>
            <p class="success"><?php echo $success; ?></p>
        <?php endif; ?>
        <form method="post">
            <div>
                <label for="username">사용자명:</label>
                <input type="text" name="username" required>
            </div>
            <div>
                <label for="email">이메일:</label>
                <input type="email" name="email" required>
            </div>
            <div>
                <label for="password">비밀번호:</label>
                <input type="password" name="password" required>
            </div>
            <input type="submit" value="회원가입">
        </form>
        <p>이미 계정이 있으신가요? <a href="login.php">로그인</a></p>
    </div>
</body>
</html>

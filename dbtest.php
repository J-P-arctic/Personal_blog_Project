<?php
$servername = "localhost";
$username = "myappuser";
$password = "mypassword123";
$dbname = "myapp";

// 데이터베이스 연결 테스트
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "데이터베이스 연결 성공!";
?>

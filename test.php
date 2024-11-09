<!DOCTYPE html>
<html>
<head>
    <title>PHP Test</title>
</head>
<body>
    <h1>PHP 테스트 페이지</h1>

    <?php
    // 현재 날짜와 시간 표시
    echo "<p>현재 서버 시간: " . date("Y-m-d H:i:s") . "</p>";
    
    // 간단한 계산
    $a = 10;
    $b = 20;
    echo "<p>{$a} + {$b} = " . ($a + $b) . "</p>";
    
    // 서버 정보 표시
    echo "<p>서버 OS: " . PHP_OS . "</p>";
    ?>
</body>
</html>

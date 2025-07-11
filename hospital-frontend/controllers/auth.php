<?php

function showLoginForm() {
    $error = $_GET['error'] ?? '';
    require 'views/login.php';
}

function handleLogin() {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $url = "http://localhost:8080/api/users/login";
    $data = json_encode([
        'username' => $username,
        'password' => $password
    ]);

    $options = [
        'http' => [
            'header'  => "Content-Type: application/json\r\n",
            'method'  => 'POST',
            'content' => $data
        ]
    ];

    $context = stream_context_create($options);
    $result = @file_get_contents($url, false, $context);

    if ($result === FALSE) {
        header('Location: index.php?url=login&error=Không thể kết nối API');
        exit;
    }

    $response = json_decode($result, true);
    if (isset($response['token'])) {
        $_SESSION['jwt_token'] = $response['token'];
        $_SESSION['user_info'] = $response['user'] ?? []; // nếu API trả về
        header('Location: index.php?url=dashboard');
    } else {
        header('Location: index.php?url=login&error=Thông tin đăng nhập không đúng');
    }
}

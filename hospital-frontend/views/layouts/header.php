<?php
$token = $_SESSION['jwt_token'] ?? '';
$payload = getPayloadFromToken($token);

$roleLabel = [
    'admin' => 'Quản trị viên',
    'staff' => 'Nhân viên',
    'doctor' => 'Bác sĩ'
];

$roleText = $roleLabel[$payload['role']] ?? 'Khách';
?>

<div style="background-color: #f2f2f2; padding: 10px;">

        <strong>Người dùng:</strong>
        <?= htmlspecialchars($payload['sub'] ?? 'Chưa đăng nhập') ?> |
        <strong>Vai trò:</strong>
        <?= $roleText ?>
        <span> | </span>
        <a href="index.php?url=logout" style="text-decoration: none; color: red;">Đăng xuất</a>

</div>
<hr>

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

<div class="app-header">
    <span class="app-name">hệ thống quản lý bệnh viện</span>
    <div class="user-info">
        <span><b><?= $roleText ?></b>: <?= htmlspecialchars($payload['full_name'] ?? 'Chưa đăng nhập') ?></span>
        <a href="index.php?url=logout">Đăng xuất</a>
    </div>
</div>

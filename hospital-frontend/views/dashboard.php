<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <?php include 'views/layouts/header.php'; ?>
    <h2>Dashboard - <?= ucfirst($role) ?></h2>

    <ul>
        <?php if ($role === 'admin'): ?>
            <li><a href="index.php?url=admin-statistics">Xem báo cáo thống kê</a></li>
        <?php endif; ?>

        <?php if ($role === 'staff'): ?>
            <li><a href="index.php?url=patient-add">Thêm bệnh nhân</a></li>
            <li><a href="index.php?url=appointment-add">Đặt lịch khám</a></li>
            <li><a href="index.php?url=appointment-list">Quản lý lịch khám</a></li>
            <li><a href="index.php?url=prescription-list">Quản lý đơn thuốc</a></li>
        <?php endif; ?>

        <?php if ($role === 'doctor'): ?>
            <li><a href="index.php?url=my-appointments">Xem lịch khám của tôi</a></li>
            <li><a href="index.php?url=my-prescriptions">Quản lý đơn thuốc đã kê</a></li>
        <?php endif; ?>

        <li><a href="index.php?url=patient-search">Tra cứu bệnh nhân</a></li>
    </ul>

    <!-- <p><a href="index.php?url=logout">Đăng xuất</a></p> -->
</body>
</html>

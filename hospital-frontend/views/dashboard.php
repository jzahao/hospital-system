<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="assets/style.css?v=<?= time() ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php include 'views/layouts/header.php'; ?>
    <div class="dashboard">
        <h2>Dashboard</h2>
        <ul>
            <?php if ($role === 'admin'): ?>
                <li><a href="index.php?url=admin-statistics"><span>Xem thống kê</span><i class="fa-solid fa-chart-simple"></i></a></li>
            <?php endif; ?>
                
            <?php if ($role === 'staff'): ?>
                <li><a href="index.php?url=patient-add"><span>Thêm bệnh nhân mới</span><i class="fa-solid fa-plus"></i></a></li>
                <li><a href="index.php?url=appointment-add"><span>Đặt lịch khám bệnh</span><i class="fa-regular fa-calendar"></i></a></li>
                <li><a href="index.php?url=appointment-list"><span>Quản lý lịch khám</span><i class="fa-solid fa-list-check"></i></a></li>
                <li><a href="index.php?url=prescription-list"><span>Quản lý đơn thuốc</span><i class="fa-solid fa-capsules"></i></a></li>
            <?php endif; ?>
            
            <?php if ($role === 'doctor'): ?>
                <li><a href="index.php?url=my-appointments"><span>Lịch khám của tôi</span><i class="fa-solid fa-list-check"></i></a></li>
                <li><a href="index.php?url=my-prescriptions"><span>Đơn thuốc đã kê</span><i class="fa-solid fa-capsules"></i></a></li>
            <?php endif; ?>
                
            <li><a href="index.php?url=patient-search"><span>Tra cứu bệnh nhân</span><i class="fa-solid fa-magnifying-glass"></i></a></li>
        </ul>
            
    </div>
</body>
</html>

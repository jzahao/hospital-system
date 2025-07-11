<!DOCTYPE html>
<html>
<head>
    <title>Quản lý lịch khám</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
        <?php include 'views/layouts/header.php'; ?>

    <h2>Quản lý lịch khám</h2>

    <?php if (empty($appointments)): ?>
        <p>Không có lịch khám nào.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Mã lịch</th>
                    <th>Bệnh nhân</th>
                    <th>Bác sĩ</th>
                    <th>Thời gian</th>
                    <th>Trạng thái</th>
                    <th>Chức năng</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($appointments as $a): ?>
                    <tr>
                        <td><?= $a['id'] ?></td>
                        <td><?= htmlspecialchars($a['patient_name']) ?></td>
                        <td><?= htmlspecialchars($a['doctor_name']) ?></td>
                        <td><?= $a['appointmentTime'] ?></td>
                        <td><?= $a['status'] ?></td>
                        <td>
                            <?php if ($a['status'] === 'Đang chờ'): ?>
                                <a href="index.php?url=appointment-edit&id=<?= $a['id'] ?>&patientName=<?= urlencode($a['patient_name']) ?>">Sửa</a> |
                                <a href="index.php?url=appointment-cancel&id=<?= $a['id'] ?>" onclick="return confirm('Bạn chắc chắn muốn hủy?')">Hủy</a>
                            <?php elseif ($a['status'] === 'Hủy'): ?>
                                <span>Đã hủy</span>
                            <?php else: ?>
                                <span>Chỉ xem</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <p><a href="index.php?url=dashboard">Quay về Dashboard</a></p>
</body>
</html>

<h2>Lịch khám của tôi</h2>

<!DOCTYPE html>
<html>
<head>
    <title>Lịch khám của tôi</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div>
        <?php include 'views/layouts/header.php'; ?>
        <table border="1" cellpadding="5" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Bệnh nhân</th>
                    <th>Nhân viên lập</th>
                    <th>Thời gian</th>
                    <th>Ghi chú</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($appointments as $a): ?>
                    <tr>
                        <td><?= $a['id'] ?></td>
                        <td><?= $patientMap[$a['patientId']] ?? 'Không rõ' ?></td>
                        <td><?= $staffMap[$a['createdBy']] ?? 'Không rõ' ?></td>
                        <td><?= $a['appointmentTime'] ?></td>
                        <td><?= htmlspecialchars($a['note']) ?></td>
                        <td><?= $a['status'] ?></td>
                        <td>
                            <?php if ($a['status'] === 'Đang chờ'): ?>
                                <a href="index.php?url=appointment-confirm&id=<?= $a['id'] ?>"
                                onclick="return confirm('Xác nhận lịch khám này?')">✅ Xác nhận</a>
                                |
                                <a href="index.php?url=appointment-cancel&id=<?= $a['id'] ?>"
                                onclick="return confirm('Hủy lịch khám này?')">❌ Hủy</a>
                            <?php elseif ($a['status'] === 'Đã xác nhận'): ?>
                                <a href="index.php?url=prescription-add&appointmentId=<?= $a['id'] ?>&patientId=<?= $a['patientId'] ?>">💊 Lập đơn thuốc</a>
                                |
                                <a href="index.php?url=appointment-cancel&id=<?= $a['id'] ?>"
                                onclick="return confirm('Hủy lịch khám này?')">❌ Hủy</a>
                            <?php elseif ($a['status'] === 'Hủy'): ?>
                                Đã hủy
                            <?php else: ?>
                                Đã khám
                            <?php endif ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>

        <p><a href="index.php?url=dashboard">Quay về Dashboard</a></p>
    </div>
</body>
</html>
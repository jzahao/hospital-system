<!DOCTYPE html>
<html>
<head>
    <title>Quản lý lịch khám</title>
    <link rel="stylesheet" href="assets/style.css?v=<?= time() ?>">
</head>
<body>
    <?php include 'views/layouts/header.php'; ?>

    <div class="appointment-list-container">
        <h2>Quản lý lịch khám</h2>

        <?php if (empty($appointments)): ?>
            <p>Không có lịch khám nào.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Mã</th>
                        <th>Bệnh nhân</th>
                        <th>Bác sĩ khám</th>
                        <th>Thời gian khám</th>
                        <th>Ghi chú</th>
                        <th>Trạng thái</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($appointments as $a): ?>
                        <tr>
                            <td style="text-align: center; width: 80px;">MKBS<?= $a['id'] ?></td>
                            <td><?= htmlspecialchars($a['patient_name']) ?></td>
                            <td><?= htmlspecialchars($a['doctor_name']) ?></td>
                            <td style="text-align: center;"><?= $a['appointmentTime'] ?></td>
                            <td style="width: 200px;"><?= $a['note'] ?></td>
                            <td style="text-align: center;"><?= $a['status'] ?></td>
                            <td style="text-align: center;">
                                <?php if ($a['status'] === 'Đang chờ'): ?>
                                    <a class="button-in-table" href="index.php?url=appointment-edit&id=<?= $a['id'] ?>&patientName=<?= urlencode($a['patient_name']) ?>">Sửa</a>
                                    <a class="button-in-table" href="index.php?url=appointment-cancel&id=<?= $a['id'] ?>" onclick="return confirm('Bạn chắc chắn muốn hủy?')">Hủy</a>
                                <?php elseif ($a['status'] === 'Hủy'): ?>
                                    <span></span>
                                <?php else: ?>
                                    <span></span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
        <div class="button-area">
            <a style="margin-top: 32px;" href="index.php?url=dashboard">Dashboard</a></p>
        </div>
    </div>
</body>
</html>

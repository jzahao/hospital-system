<h2>Lịch khám của tôi</h2>

<!DOCTYPE html>
<html>
<head>
    <title>Lịch khám của tôi</title>
    <link rel="stylesheet" href="assets/style.css?v=<?= time() ?>">
</head>
<body>
    <?php include 'views/layouts/header.php'; ?>

    <div class="doctor-appointments-container">
        <h2>Danh sách lịch khám của Bác sĩ <?= htmlspecialchars($payload['full_name'])?></h2>
        <table border="1" cellpadding="5" cellspacing="0">
            <thead>
                <tr>
                    <th>Mã</th>
                    <th>Bệnh nhân</th>
                    <th>Nhân viên lập lịch</th>
                    <th>Thời gian khám</th>
                    <th>Ghi chú</th>
                    <th>Trạng thái</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($appointments as $a): ?>
                    <tr>
                        <td style="text-align: center;">MKBS<?= $a['id'] ?></td>
                        <td style="text-align: center;"><?= $patientMap[$a['patientId']] ?? 'Không rõ' ?></td>
                        <td style="text-align: center;"><?= $staffMap[$a['createdBy']] ?? 'Không rõ' ?></td>
                        <td style="text-align: center;"><?= $a['appointmentTime'] ?></td>
                        <td><?= htmlspecialchars($a['note']) ?></td>
                        <td style="text-align: center;"><?= $a['status'] ?></td>
                        <td style="text-align: center;">
                            <?php if ($a['status'] === 'Đang chờ'): ?>
                                <a class="button-in-table" href="index.php?url=appointment-confirm&id=<?= $a['id'] ?>"
                                onclick="return confirm('Xác nhận lịch khám này?')">Xác nhận</a>
                                <a class="button-in-table" href="index.php?url=appointment-cancel&id=<?= $a['id'] ?>"
                                onclick="return confirm('Hủy lịch khám này?')">Hủy</a>
                            <?php elseif ($a['status'] === 'Đã xác nhận'): ?>
                                <a class="button-in-table" href="index.php?url=prescription-add&appointmentId=<?= $a['id'] ?>&patientId=<?= $a['patientId'] ?>">Lập đơn thuốc</a>
                                <a class="button-in-table" href="index.php?url=appointment-cancel&id=<?= $a['id'] ?>"
                                onclick="return confirm('Hủy lịch khám này?')">Hủy</a>
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
        <div class="button-area">
            <a style="margin-top: 32px;" href="index.php?url=dashboard">Dashboard</a>
        </div>
    </div>
</body>
</html>
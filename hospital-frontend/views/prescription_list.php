<!DOCTYPE html>
<html>
<head>
    <title>Quản lý đơn thuốc</title>
    <link rel="stylesheet" href="assets/style.css?v=<?= time() ?>">

</head>
<body>
    <?php include 'views/layouts/header.php'; ?>
    <div class="prescription-list-container">
        <h2>Danh sách đơn thuốc</h2>

        <table border="1" cellpadding="5" cellspacing="0">
            <thead>
                <tr>
                    <th>Mã</th>
                    <th>Bệnh nhân</th>
                    <th>Bác sĩ kê đơn</th>
                    <th>Trạng thái</th>
                    <th>Tổng tiền</th>
                    <th>Ghi chú</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($prescriptions as $p): ?>
                    <tr style="text-align:center">
                        <td><?= $p['id'] ?></td>
                        <td><?= htmlspecialchars($patientMap[$p['patientId']] ?? 'Không rõ') ?></td>
                        <td><?= htmlspecialchars($doctorMap[$p['prescribedBy']] ?? 'Không rõ') ?></td>
                        <td><?= $p['status'] ?></td>
                        <td><?= number_format($p['totalPrice']) ?></td>
                        <td><?= htmlspecialchars($p['notes']) ?></td>
                        <td>
                            <?php if ($p['status'] === 'Chưa lấy'): ?>
                                <a class="button-in-table" href="index.php?url=prescription-confirm&id=<?= $p['id'] ?>"
                                onclick="return confirm('Xác nhận bệnh nhân đã lấy đơn này?')">
                                    Xác nhận đã lấy
                                </a>
                            <?php else: ?>
                                Đã lấy
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <div class="button-area">
            <a href="index.php?url=dashboard">Quay về Dashboard</a>
        </div>
    </div>
</body>
</html>

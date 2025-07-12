<!DOCTYPE html>
<html>
<head>
    <title>Quản lý lịch khám</title>
    <link rel="stylesheet" href="assets/style.css?v=<?= time() ?>">

</head>
<body>
    <?php include 'views/layouts/header.php'; ?>
    <div class="doctor-prescriptions-container">
        <h2>Đơn thuốc đã kê</h2>
        <table border="1" cellpadding="5" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Bệnh nhân</th>
                    <th>Thuốc</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Ghi chú</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($prescriptions as $p): ?>
                    <tr style="text-align:center">
                        <td><?= $p['id'] ?></td>
                        <td><?= $patientMap[$p['patientId']] ?? 'Không rõ' ?></td>
                        <td><?= nl2br(htmlspecialchars($p['medicineList'])) ?></td>
                        <td><?= number_format($p['totalPrice']) ?></td>
                        <td><?= $p['status'] ?></td>
                        <td><?= htmlspecialchars($p['notes']) ?></td>
                        <td>
                            <?php if ($p['status'] === 'Chưa lấy'): ?>
                                <a class="button-in-table" href="index.php?url=prescription-edit&id=<?= $p['id'] ?>">Sửa</a>
                            <?php else: ?>
                                Đã lấy
                            <?php endif ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <div class="button-area">
            <a style="margin-top: 32px;" href="index.php?url=dashboard">Quay về Dashboard</a>
        </div>
    </div>
</body>
</html>

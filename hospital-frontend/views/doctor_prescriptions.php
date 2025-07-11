<!DOCTYPE html>
<html>
<head>
    <title>Quản lý lịch khám</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div>
        <?php include 'views/layouts/header.php'; ?>
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
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($prescriptions as $p): ?>
                    <tr>
                        <td><?= $p['id'] ?></td>
                        <td><?= $patientMap[$p['patientId']] ?? 'Không rõ' ?></td>
                        <td><?= nl2br(htmlspecialchars($p['medicineList'])) ?></td>
                        <td><?= number_format($p['totalPrice']) ?></td>
                        <td><?= $p['status'] ?></td>
                        <td><?= htmlspecialchars($p['notes']) ?></td>
                        <td>
                            <?php if ($p['status'] === 'Chưa lấy'): ?>
                                <a href="index.php?url=prescription-edit&id=<?= $p['id'] ?>">✏️ Sửa</a>
                            <?php else: ?>
                                Đã lấy
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

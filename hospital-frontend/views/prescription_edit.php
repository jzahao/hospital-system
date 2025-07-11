<!DOCTYPE html>
<html>
<head>
    <title>Quản lý lịch khám</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div>
        <?php include 'views/layouts/header.php'; ?>
<h2>Sửa đơn thuốc #<?= $prescription['id'] ?></h2>

<form method="POST" action="index.php?url=prescription-update">
    <input type="hidden" name="id" value="<?= $prescription['id'] ?>">
    <input type="hidden" name="patient_id" value="<?= $prescription['patientId'] ?>">
    <input type="hidden" name="appointment_id" value="<?= $prescription['appointmentId'] ?>">
    <input type="hidden" name="prescribed_by" value="<?= $prescription['prescribedBy'] ?>">
    <input type="hidden" name="status" value="<?= $prescription['status'] ?>">

    <label>Danh sách thuốc:</label><br>
    <textarea name="medicine_list" rows="5" cols="50" required><?= htmlspecialchars($prescription['medicineList']) ?></textarea><br><br>

    <label>Tổng tiền (VND):</label><br>
    <input type="number" name="total_price" value="<?= $prescription['totalPrice'] ?>" required><br><br>

    <label>Ghi chú:</label><br>
    <textarea name="notes" rows="3" cols="50"><?= htmlspecialchars($prescription['notes']) ?></textarea><br><br>

    <button type="submit">💾 Cập nhật</button>
</form>
<p><a href="index.php?url=dashboard">Quay về Dashboard</a></p>
</div>
</body>
</html>

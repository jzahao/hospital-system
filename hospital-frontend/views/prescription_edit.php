<!DOCTYPE html>
<html>
<head>
    <title>Quản lý lịch khám</title>
    <link rel="stylesheet" href="assets/style.css?v=<?= time() ?>">
</head>
<body>
    <div class="prescription-edit-container">
        <?php include 'views/layouts/header.php'; ?>
        <div class="form-boundary">
            <h2>Sửa đơn thuốc #<?= $prescription['id'] ?></h2>

            <form method="POST" action="index.php?url=prescription-update">
                <input type="hidden" name="id" value="<?= $prescription['id'] ?>">
                <input type="hidden" name="patient_id" value="<?= $prescription['patientId'] ?>">
                <input type="hidden" name="appointment_id" value="<?= $prescription['appointmentId'] ?>">
                <input type="hidden" name="prescribed_by" value="<?= $prescription['prescribedBy'] ?>">
                <input type="hidden" name="status" value="<?= $prescription['status'] ?>">

                <label>Danh sách thuốc:</label>
                <textarea name="medicine_list" rows="5" required><?= htmlspecialchars($prescription['medicineList']) ?></textarea><br>

                <label>Tổng tiền (VND):</label>
                <input type="number" name="total_price" value="<?= $prescription['totalPrice'] ?>" required><br>

                <label>Ghi chú:</label>
                <textarea name="notes" rows="3"><?= htmlspecialchars($prescription['notes']) ?></textarea><br>

                <div class="button-area">
                    <button type="submit">Lưu</button>
                    <a href="index.php?url=my-prescriptions">Danh sách</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

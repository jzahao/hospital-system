<!DOCTYPE html>
<html>
<head>
    <title>Lập đơn thuốc</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div>
        <?php include 'views/layouts/header.php'; ?>
        <h2>Lập đơn thuốc</h2>
        <form method="POST" action="index.php?url=prescription-save">
            <input type="hidden" name="appointment_id" value=<?= $_GET['appointmentId'] ?>>
            <input type="hidden" name="patient_id" value=<?= $_GET['patientId'] ?>>

            <p>Mã bệnh nhân: <?= $_GET['patientId'] ?></p>

            <label>Danh sách thuốc:</label><br>
            <textarea name="medicine_list" rows="5" cols="50" required></textarea><br><br>

            <label>Tổng tiền (VND):</label><br>
            <input type="number" name="total_price" required><br><br>

            <label>Ghi chú:</label><br>
            <textarea name="notes" rows="3" cols="50"></textarea><br><br>

            <button type="submit">💾 Lưu đơn thuốc</button>
        </form>
    </div>
</body>
</html>
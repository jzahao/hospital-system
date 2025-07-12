<!DOCTYPE html>
<html>
<head>
    <title>Lập đơn thuốc</title>
    <link rel="stylesheet" href="assets/style.css?v=<?= time() ?>">
</head>
<body>
    <?php include 'views/layouts/header.php'; ?>

    <div class="prescription-add-container">
        <div class="form-boundary">
            <h2>Lập đơn thuốc</h2>
            <form method="POST" action="index.php?url=prescription-save">
                <input type="hidden" name="appointment_id" value=<?= $_GET['appointmentId'] ?>>
                <input type="hidden" name="patient_id" value=<?= $_GET['patientId'] ?>>

                <label class="patient-info">Mã bệnh nhân: <?= $_GET['patientId'] ?></label><br>

                <label>Danh sách thuốc:</label>
                <textarea name="medicine_list" rows="5" required></textarea><br>

                <label>Tổng tiền (VND):</label>
                <input type="number" name="total_price" required><br>

                <label>Ghi chú:</label>
                <textarea name="notes" rows="3"></textarea><br>
                
                <div class="button-area">
                    <button type="submit">Xác nhận</button>
                    <a href="index.php?url=my-appointments">Danh sách</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
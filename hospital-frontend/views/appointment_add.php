<!DOCTYPE html>
<html>
<head>
    <title>Đặt lịch khám</title>
    <link rel="stylesheet" href="assets/style.css?v=<?= time() ?>">
</head>
<body>
    <?php include 'views/layouts/header.php'; ?>
    
    <div class="appointment-add-container">
        <div class="form-boundary">
            <h2>Đặt lịch khám</h2>
            <?php if (!empty($error)): ?>
                <p style="color:red"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
            <?php if (!empty($success)): ?>
                <p style="color:green"><?= htmlspecialchars($success) ?></p>
            <?php endif; ?>

            <form method="POST" action="index.php?url=appointment-submit">
                <label>Chọn bệnh nhân:</label>
                <select name="patient_id" required>
                    <option value="" selected hidden>Chọn bệnh nhân</option>
                    <?php foreach ($patients as $patient): ?>
                        <option value="<?= $patient['id'] ?>">
                            <?= htmlspecialchars($patient['fullName']) ?>
                        </option>
                    <?php endforeach; ?>
                </select><br>

                <label>Chọn bác sĩ:</label>
                    <select name="doctor_id" required>
                        <option value="" selected hidden>Chọn bác sĩ</option>
                        <?php foreach ($doctors as $doctor): ?>
                            <option value="<?= $doctor['id'] ?>">
                                <?= htmlspecialchars($doctor['fullName']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select><br>

                <label>Thời gian khám:</label>
                <input type="datetime-local" name="appointment_time" required><br>

                <label>Ghi chú (nếu có):</label>
                <textarea rows="3" name="note"></textarea><br>

                <div class="button-area">
                    <button type="submit">Đặt lịch</button>
                    <a href="index.php?url=dashboard">Quay lại</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

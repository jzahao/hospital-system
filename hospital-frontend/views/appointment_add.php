<!DOCTYPE html>
<html>
<head>
    <title>Đặt lịch khám</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <?php include 'views/layouts/header.php'; ?>
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
            <?php foreach ($patients as $patient): ?>
                <option value="<?= $patient['id'] ?>">
                    <?= htmlspecialchars($patient['fullName']) ?>
                </option>
            <?php endforeach; ?>
        </select><br>

        <label>Chọn bác sĩ:</label>
            <select name="doctor_id" required>
                <?php foreach ($doctors as $doctor): ?>
                    <option value="<?= $doctor['id'] ?>">
                        <?= htmlspecialchars($doctor['fullName']) ?>
                    </option>
                <?php endforeach; ?>
            </select><br>

        <label>Thời gian khám:</label>
        <input type="datetime-local" name="appointment_time" required><br>

        <label>Ghi chú (nếu có):</label>
        <textarea name="note"></textarea><br>

        <button type="submit">Đặt lịch</button>
    </form>

    <p><a href="index.php?url=dashboard">Quay về Dashboard</a></p>
</body>
</html>

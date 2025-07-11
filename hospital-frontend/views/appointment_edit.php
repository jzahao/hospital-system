<!DOCTYPE html>
<html>
<head>
    <title>Sửa lịch khám</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <?php include 'views/layouts/header.php'; ?>
    <h2>Sửa lịch khám</h2>

    <?php if (!empty($error)): ?>
        <p style="color:red"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST" action="index.php?url=appointment-update">
        <input type="hidden" name="id" value="<?= $appointment['id'] ?>">
        <input type="hidden" name="patientId" value="<?= $appointment['patientId'] ?>">
        <input type="hidden" name="createdBy" value="<?= $appointment['createdBy'] ?>">

        <label>Bệnh nhân:</label>
        <input type="text" value="<?= htmlspecialchars($patientName) ?>" disabled><br>

        <label>Bác sĩ:</label>
        <select name="doctorId" required>
            <?php foreach ($doctors as $d): ?>
                <option value="<?= $d['id'] ?>" <?= $d['id'] == $appointment['doctorId'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($d['fullName']) ?>
                </option>
            <?php endforeach; ?>
        </select><br>

        <label>Thời gian khám:</label>
        <input type="datetime-local" name="appointmentTime"
            value="<?= date('Y-m-d\TH:i', strtotime($appointment['appointmentTime'])) ?>" required><br>

        <label>Ghi chú:</label>
        <textarea name="note"><?= htmlspecialchars($appointment['note']) ?></textarea><br>

        <button type="submit">Cập nhật</button>
    </form>

    <p><a href="index.php?url=appointment-list">Quay lại danh sách</a></p>
</body>
</html>

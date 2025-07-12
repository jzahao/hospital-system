<!DOCTYPE html>
<html>
<head>
    <title>Sửa lịch khám</title>
    <link rel="stylesheet" href="assets/style.css?v=<?= time() ?>">
</head>
<body>
    <?php include 'views/layouts/header.php'; ?>
    <div class="appointment-edit-container">
        <div class="form-boundary">
            <h2>Sửa đổi lịch khám</h2>

            <?php if (!empty($error)): ?>
                <p style="color:red"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>

            <form method="POST" action="index.php?url=appointment-update">
                <input type="hidden" name="id" value="<?= $appointment['id'] ?>">
                <input type="hidden" name="patientId" value="<?= $appointment['patientId'] ?>">
                <input type="hidden" name="createdBy" value="<?= $appointment['createdBy'] ?>">

                <label>Bệnh nhân:</label>
                <input type="text" value="<?= htmlspecialchars($patientName) ?>" disabled><br>

                <label>Bác sĩ khám:</label>
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
                
                <div class="button-area">
                    <button type="submit">Cập nhật</button>
                    <a href="index.php?url=appointment-list">Danh sách</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

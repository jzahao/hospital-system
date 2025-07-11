<!DOCTYPE html>
<html>
<head>
    <title>Thêm bệnh nhân</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <?php include 'views/layouts/header.php'; ?>
    <h2>Thêm bệnh nhân</h2>

    <?php if (!empty($error)): ?>
        <p style="color:red"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <?php if (!empty($success)): ?>
        <p style="color:green"><?= htmlspecialchars($success) ?></p>
    <?php endif; ?>

    <form method="POST" action="index.php?url=patient-add-submit">
        <label>Họ tên:</label>
        <input type="text" name="full_name" required><br>

        <label>Ngày sinh:</label>
        <input type="date" name="date_of_birth" required><br>

        <label>Giới tính:</label>
        <select name="gender" required>
            <option value="Nam">Nam</option>
            <option value="Nữ">Nữ</option>
            <option value="Khác">Khác</option>
        </select><br>

        <label>Số điện thoại:</label>
        <input type="text" name="phone_number"><br>

        <label>Email:</label>
        <input type="email" name="email"><br>

        <button type="submit">Thêm</button>
    </form>

    <p><a href="index.php?url=dashboard">Quay về Dashboard</a></p>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <title>Thêm bệnh nhân</title>
    <link rel="stylesheet" href="assets/style.css?v=<?= time() ?>">
</head>
<body>
    <?php include 'views/layouts/header.php'; ?>

    <div class="patient-add-container">
        <div class="form-boundary">
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
                   
                <div class="button-area">
                    <button type="submit">Thêm</button>
                    <a href="index.php?url=dashboard">Quay lại</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

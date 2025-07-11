<!DOCTYPE html>
<html>
<head>
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <h2>Đăng nhập</h2>
    <?php if (!empty($error)): ?>
        <p style="color:red"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="POST" action="index.php?url=login-submit">
        <label>Tên đăng nhập:</label>
        <input type="text" name="username" required><br>
        <label>Mật khẩu:</label>
        <input type="password" name="password" required><br>
        <button type="submit">Đăng nhập</button>
    </form>
</body>
</html>

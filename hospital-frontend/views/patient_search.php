<!DOCTYPE html>
<html>
<head>
    <title>Quản lý lịch khám</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div>
        <?php include 'views/layouts/header.php'; ?>
    <h2>Tra cứu bệnh nhân</h2>

<form method="GET" action="index.php">
    <input type="hidden" name="url" value="patient-search">
    <input type="text" name="keyword" placeholder="Nhập tên bệnh nhân" value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
    <button type="submit">🔍 Tìm kiếm</button>
</form>

<br>

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Họ tên</th>
            <th>Ngày sinh</th>
            <th>Giới tính</th>
            <th>SĐT</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($patients as $p): ?>
            <tr>
                <td><?= $p['id'] ?></td>
                <td><?= htmlspecialchars($p['fullName']) ?></td>
                <td><?= $p['dateOfBirth'] ?></td>
                <td><?= $p['gender'] ?></td>
                <td><?= $p['phoneNumber'] ?></td>
                <td><?= $p['email'] ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>
        <p><a href="index.php?url=dashboard">Quay về Dashboard</a></p>
    </div>
</body>
</html>
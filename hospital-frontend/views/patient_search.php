<!DOCTYPE html>
<html>
<head>
    <title>Quản lý lịch khám</title>
    <link rel="stylesheet" href="assets/style.css?v=<?= time() ?>">
</head>
<body>
    <?php include 'views/layouts/header.php'; ?>

    <div class="patient-search-container">
        <h2>Tra cứu bệnh nhân</h2>

        <form class="search-form" method="GET" action="index.php">
            <input type="hidden" name="url" value="patient-search">
            <input type="text" name="keyword" placeholder="Nhập tên bệnh nhân" value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
            <button type="submit">Tìm kiếm</button>
        </form><br>

        <table border="1" cellpadding="5" cellspacing="0">
            <thead>
                <tr>
                    <th>Mã</th>
                    <th>Họ tên</th>
                    <th>Ngày sinh</th>
                    <th>Giới tính</th>
                    <th>SĐT</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($patients as $p): ?>
                    <tr style="text-align:center">
                        <td>BN<?= $p['id'] ?></td>
                        <td><?= htmlspecialchars($p['fullName']) ?></td>
                        <td><?= $p['dateOfBirth'] ?></td>
                        <td><?= $p['gender'] ?></td>
                        <td><?= $p['phoneNumber'] ?></td>
                        <td style="text-align:left"><?= $p['email'] ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <div class="button-area">
            <a style="margin-top: 32px;" href="index.php?url=dashboard">Dashboard</p>
        </div>
    </div>
</body>
</html>
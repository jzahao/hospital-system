<!DOCTYPE html>
<html>
<head>
    <title>Quản lý lịch khám</title>
    <link rel="stylesheet" href="assets/style.css?v=<?= time() ?>">

</head>
<body>
    <?php include 'views/layouts/header.php'; ?>
    <div class="admin-statistics-container">
        <div class="stat-title">
            <h2>Thống kê năm <?= htmlspecialchars($year) ?></h2>

            <form class="search-form" method="GET" action="index.php">
                <input type="hidden" name="url" value="admin-statistics">
                <input type="number" name="year" value="<?= htmlspecialchars($year) ?>">
                <button type="submit">Xem</button>
            </form>
        </div>

        <div class="stat-tables">
            <div class="table-element">
                <h3>1. Tổng bệnh nhân theo tháng</h3>
                <table border="1">
                    <tr><th>Tháng</th><th>Số lượng</th></tr>
                    <?php foreach ($patientMonthly as $item): ?>
                        <tr><td><?= $item['label'] ?></td><td><?= $item['value'] ?></td></tr>
                    <?php endforeach ?>
                </table>
            </div>
            
            <div class="table-element">
                <h3>2. Tổng đơn thuốc theo tháng</h3>
                <table border="1">
                    <tr><th>Tháng</th><th>Số lượng</th></tr>
                    <?php foreach ($prescriptionMonthly as $item): ?>
                        <tr><td><?= $item['label'] ?></td><td><?= $item['value'] ?></td></tr>
                    <?php endforeach ?>
                </table>
            </div>

            <div class="table-element">
                <h3>3. Tổng tiền thuốc theo tháng</h3>
                <table border="1">
                    <tr><th>Tháng</th><th>Tổng tiền (VND)</th></tr>
                    <?php foreach ($totalMonthly as $item): ?>
                        <tr><td><?= $item['label'] ?></td><td><?= number_format($item['value']) ?></td></tr>
                    <?php endforeach ?>
                </table>
            </div>

            <div class="table-element">
                <h3>4. Tổng tiền thuốc theo quý</h3>
                <table border="1">
                    <tr><th>Quý</th><th>Tổng tiền (VND)</th></tr>
                    <?php foreach ($totalQuarter as $item): ?>
                        <tr><td><?= $item['label'] ?></td><td><?= number_format($item['value']) ?></td></tr>
                    <?php endforeach ?>
                </table>            
            </div>

            <div class="table-element">
                <h3>5. Tổng tiền thuốc theo năm</h3>
                <table border="1">
                    <tr><th>Năm</th><th>Tổng tiền (VND)</th></tr>
                    <?php foreach ($totalYear as $item): ?>
                        <tr><td><?= $item['label'] ?></td><td><?= number_format($item['value']) ?></td></tr>
                    <?php endforeach ?>
                </table>
            </div>
        </div>
        <div class="button-area">
            <a style="margin-top: 32px;" href="index.php?url=dashboard">Dashboard</p>
        </div>
    </div>
</body>
</html>
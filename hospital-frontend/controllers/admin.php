<?php
require_once 'helpers/jwt_helper.php';

function showStatistics() {
    $token = $_SESSION['jwt_token'] ?? '';
    $payload = getPayloadFromToken($token);

    if ($payload['role'] !== 'admin') {
        echo "Bạn không có quyền truy cập.";
        return;
    }

    $year = $_GET['year'] ?? date('Y');

    function fetchStat($url, $token) {
        $res = @file_get_contents($url, false, stream_context_create([
            'http' => ['method' => 'GET', 'header' => "Authorization: Bearer $token\r\n"]
        ]));
        return json_decode($res, true) ?? [];
    }

    $patientMonthly = fetchStat("http://localhost:8080/api/patients/stats/count-by-month?year=$year", $token);
    $prescriptionMonthly = fetchStat("http://localhost:8080/api/prescriptions/stats/count-by-month?year=$year", $token);
    $totalMonthly = fetchStat("http://localhost:8080/api/prescriptions/stats/total-by-month?year=$year", $token);
    $totalQuarter = fetchStat("http://localhost:8080/api/prescriptions/stats/total-by-quarter?year=$year", $token);
    $totalYear = fetchStat("http://localhost:8080/api/prescriptions/stats/total-by-year", $token);

    require 'views/admin_statistics.php';
}

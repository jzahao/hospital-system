<?php
require_once 'helpers/jwt_helper.php';

function showPrescriptionList() {
    $token = $_SESSION['jwt_token'] ?? '';
    $payload = getPayloadFromToken($token);
    if ($payload['role'] !== 'staff') {
        echo "Bạn không có quyền truy cập.";
        return;
    }

    // Lấy danh sách đơn thuốc
    $res = @file_get_contents("http://localhost:8080/api/prescriptions", false, stream_context_create([
        'http' => [
            'method' => 'GET',
            'header' => "Authorization: Bearer $token\r\n"
        ]
    ]));
    $prescriptions = json_decode($res, true) ?? [];

    // Lấy danh sách bệnh nhân
    $res2 = @file_get_contents("http://localhost:8080/api/patients", false, stream_context_create([
        'http' => [
            'method' => 'GET',
            'header' => "Authorization: Bearer $token\r\n"
        ]
    ]));
    $patients = json_decode($res2, true) ?? [];
    $patientMap = [];
    foreach ($patients as $p) $patientMap[$p['id']] = $p['fullName'];

    // Lấy danh sách bác sĩ
    $res3 = @file_get_contents("http://localhost:8080/api/users/doctors", false, stream_context_create([
        'http' => [
            'method' => 'GET',
            'header' => "Authorization: Bearer $token\r\n"
        ]
    ]));
    $doctors = json_decode($res3, true) ?? [];
    $doctorMap = [];
    foreach ($doctors as $d) $doctorMap[$d['id']] = $d['fullName'];

    usort($prescriptions, function ($a, $b) {
        // Sắp theo updated_at DESC
        $timeA = strtotime($a['updatedAt'] ?? $a['appointmentTime']);
        $timeB = strtotime($b['updatedAt'] ?? $b['appointmentTime']);
        return $timeB <=> $timeA;
    });
    require 'views/prescription_list.php';
}

function confirmPrescription() {
    $token = $_SESSION['jwt_token'] ?? '';
    $payload = getPayloadFromToken($token);
    if ($payload['role'] !== 'staff') {
        echo "Bạn không có quyền xác nhận đơn.";
        return;
    }

    if (!isset($_GET['id'])) {
        echo "Thiếu ID đơn thuốc.";
        return;
    }

    $id = intval($_GET['id']);
    $url = "http://localhost:8080/api/prescriptions/$id/status";
    $data = ['status' => 'Đã lấy'];

    $options = [
        'http' => [
            'method' => 'PUT',
            'header' => "Content-Type: application/json\r\nAuthorization: Bearer $token\r\n",
            'content' => json_encode($data)
        ]
    ];
    @file_get_contents($url, false, stream_context_create($options));

    header("Location: index.php?url=prescription-list");
}

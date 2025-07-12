<?php
require_once 'helpers/jwt_helper.php';

function showMyAppointments() {
    $token = $_SESSION['jwt_token'] ?? '';
    $payload = getPayloadFromToken($token);

    if ($payload['role'] !== 'doctor') {
        echo "Bạn không có quyền truy cập.";
        return;
    }

    $doctorId = $payload['user_id'];

    $res = @file_get_contents("http://localhost:8080/api/appointments/doctor/$doctorId", false, stream_context_create([
        'http' => ['method' => 'GET', 'header' => "Authorization: Bearer $token\r\n"]
    ]));
    $appointments = json_decode($res, true) ?? [];

    // Lấy bệnh nhân
    $patients = json_decode(@file_get_contents("http://localhost:8080/api/patients", false, stream_context_create([
        'http' => ['method' => 'GET', 'header' => "Authorization: Bearer $token\r\n"]
    ])), true) ?? [];
    $patientMap = [];
    foreach ($patients as $p) $patientMap[$p['id']] = $p['fullName'];

    // Lấy user (staff)
    $res2 = @file_get_contents("http://localhost:8080/api/users/staffs", false, stream_context_create([
        'http' => ['method' => 'GET', 'header' => "Authorization: Bearer $token\r\n"]
    ]));
    $staffs = json_decode($res2, true) ?? [];
    $staffMap = [];
    foreach ($staffs as $s) $staffMap[$s['id']] = $s['fullName'];

    usort($appointments, function ($a, $b) {
        // Sắp theo updated_at DESC
        $timeA = strtotime($a['updatedAt'] ?? $a['appointmentTime']);
        $timeB = strtotime($b['updatedAt'] ?? $b['appointmentTime']);
    return $timeB <=> $timeA;
    });

    require 'views/doctor_appointments.php';
}

function confirmAppointment() {
    $token = $_SESSION['jwt_token'] ?? '';
    $id = intval($_GET['id']);
    $url = "http://localhost:8080/api/appointments/$id/confirm";

    $res = @file_get_contents($url, false, stream_context_create([
        'http' => ['method' => 'PUT', 'header' => "Authorization: Bearer $token\r\n"]
    ]));

    header("Location: index.php?url=my-appointments");
}

function completeAppointment() {
    $token = $_SESSION['jwt_token'] ?? '';
    $id = intval($_GET['id']);
    $url = "http://localhost:8080/api/appointments/$id/complete";

    @file_get_contents($url, false, stream_context_create([
        'http' => ['method' => 'POST', 'header' => "Authorization: Bearer $token\r\n"]
    ]));

    header("Location: index.php?url=my-appointments");
}

function showCreatePrescriptionForm() {
    $id = intval($_GET['appointmentId']);
    require 'views/prescription_add.php';
}

function savePrescription() {
    $token = $_SESSION['jwt_token'] ?? '';
    $payload = getPayloadFromToken($token);
    $data = [
        'appointmentId' => $_POST['appointment_id'],
        'patientId' => $_POST['patient_id'],
        'prescribedBy' => $payload['id'],
        'medicineList' => $_POST['medicine_list'],
        'totalPrice' => $_POST['total_price'],
        'notes' => $_POST['notes']
    ];

    $options = [
        'http' => [
            'method' => 'POST',
            'header' => "Content-Type: application/json\r\nAuthorization: Bearer $token\r\n",
            'content' => json_encode($data)
        ]
    ];
    @file_get_contents("http://localhost:8080/api/prescriptions", false, stream_context_create($options));

    // Gọi complete
    $appointmentId = intval($_POST['appointment_id']);
    @file_get_contents("http://localhost:8080/api/appointments/$appointmentId/complete", false, stream_context_create([
        'http' => ['method' => 'PUT', 'header' => "Authorization: Bearer $token\r\n"]
    ]));

    header("Location: index.php?url=my-appointments");
}

function showMyPrescriptions() {
    $token = $_SESSION['jwt_token'] ?? '';
    $payload = getPayloadFromToken($token);
    if ($payload['role'] !== 'doctor') {
        echo "Không có quyền truy cập.";
        return;
    }

    $doctorId = $payload['user_id'];

    $res = @file_get_contents("http://localhost:8080/api/prescriptions/doctor/$doctorId", false, stream_context_create([
        'http' => ['method' => 'GET', 'header' => "Authorization: Bearer $token\r\n"]
    ]));
    $prescriptions = json_decode($res, true) ?? [];

    // Lấy thông tin bệnh nhân
    $patients = json_decode(@file_get_contents("http://localhost:8080/api/patients", false, stream_context_create([
        'http' => ['method' => 'GET', 'header' => "Authorization: Bearer $token\r\n"]
    ])), true) ?? [];
    $patientMap = [];
    foreach ($patients as $p) $patientMap[$p['id']] = $p['fullName'];

    require 'views/doctor_prescriptions.php';
}

function showEditPrescriptionForm() {
    $token = $_SESSION['jwt_token'] ?? '';
    $id = intval($_GET['id']);

    $res = @file_get_contents("http://localhost:8080/api/prescriptions/$id", false, stream_context_create([
        'http' => ['method' => 'GET', 'header' => "Authorization: Bearer $token\r\n"]
    ]));
    $prescription = json_decode($res, true);

    if (!$prescription || $prescription['status'] === 'Đã lấy') {
        echo "Không thể sửa đơn thuốc đã lấy.";
        return;
    }

    require 'views/prescription_edit.php';
}

function updatePrescription() {
    $token = $_SESSION['jwt_token'] ?? '';
    $id = intval($_POST['id']);
    $data = [
        'id' => $id,
        'patientId' => intval($_POST['patient_id']),
        'appointmentId' => intval($_POST['appointment_id']),
        'prescribedBy' => intval($_POST['prescribed_by']),
        'status' => $_POST['status'],
        'medicineList' => $_POST['medicine_list'],
        'totalPrice' => intval($_POST['total_price']),
        'notes' => $_POST['notes']
    ];

    $options = [
        'http' => [
            'method' => 'PUT',
            'header' => "Content-Type: application/json\r\nAuthorization: Bearer $token\r\n",
            'content' => json_encode($data)
        ]
    ];
    @file_get_contents("http://localhost:8080/api/prescriptions/$id", false, stream_context_create($options));

    header("Location: index.php?url=my-prescriptions");
}

<?php
require_once 'helpers/jwt_helper.php';

function showAddPatientForm() {
    $token = $_SESSION['jwt_token'] ?? '';
    $payload = getPayloadFromToken($token);
    if ($payload['role'] !== 'staff') {
        echo "Bạn không có quyền truy cập chức năng này.";
        return;
    }

    $error = $_GET['error'] ?? '';
    $success = $_GET['success'] ?? '';
    require 'views/patient_add.php';
}

function submitAddPatient() {
    $token = $_SESSION['jwt_token'] ?? '';
    $payload = getPayloadFromToken($token);
    if ($payload['role'] !== 'staff') {
        echo "Bạn không có quyền thực hiện chức năng này.";
        return;
    }

    $data = [
        'fullName' => $_POST['full_name'] ?? '',
        'dateOfBirth' => $_POST['date_of_birth'] ?? '',
        'gender' => $_POST['gender'] ?? '',
        'phoneNumber' => $_POST['phone_number'] ?? '',
        'email' => $_POST['email'] ?? ''
    ];

    $url = 'http://localhost:8080/api/patients';

    $options = [
        'http' => [
            'method'  => 'POST',
            'header'  => "Content-Type: application/json\r\n" .
                         "Authorization: Bearer $token\r\n",
            'content' => json_encode($data)
        ]
    ];

    $context = stream_context_create($options);
    $result = @file_get_contents($url, false, $context);

    if ($result === false) {
        header('Location: index.php?url=patient-add&error=Không thể kết nối API');
        exit;
    }

    $response = json_decode($result, true);

    if (!empty($response['id'])) {
        header('Location: index.php?url=patient-add&success=Thêm bệnh nhân thành công');
    } else {
        $msg = $response['message'] ?? 'Thêm thất bại';
        header('Location: index.php?url=patient-add&error=' . urlencode($msg));
    }
}

function searchPatients() {
    $token = $_SESSION['jwt_token'] ?? '';
    $keyword = $_GET['keyword'] ?? '';

    // Gọi API tìm kiếm nếu có keyword
    $patients = [];
    if ($keyword !== '') {
        $res = @file_get_contents("http://localhost:8080/api/patients/search?keyword=" . urlencode($keyword), false, stream_context_create([
            'http' => ['method' => 'GET', 'header' => "Authorization: Bearer $token\r\n"]
        ]));
        $patients = json_decode($res, true) ?? [];
    } else {
        // Lấy toàn bộ bệnh nhân nếu chưa nhập gì
        $res = @file_get_contents("http://localhost:8080/api/patients", false, stream_context_create([
            'http' => ['method' => 'GET', 'header' => "Authorization: Bearer $token\r\n"]
        ]));
        $patients = json_decode($res, true) ?? [];
    }

    require 'views/patient_search.php';
}

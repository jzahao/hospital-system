<?php
require_once 'helpers/jwt_helper.php';

function showAppointmentForm() {
    $token = $_SESSION['jwt_token'] ?? '';
    $payload = getPayloadFromToken($token);
    if ($payload['role'] !== 'staff') {
        echo "Bạn không có quyền truy cập chức năng này.";
        return;
    }

    // Lấy danh sách bệnh nhân
    $patients = [];
    $res1 = @file_get_contents('http://localhost:8080/api/patients', false, stream_context_create([
        'http' => [
            'method' => 'GET',
            'header' => "Authorization: Bearer $token\r\n"
        ]
    ]));
    if ($res1 !== false) $patients = json_decode($res1, true) ?? [];

    // Lấy danh sách bác sĩ
    $doctors = [];
    $res2 = @file_get_contents('http://localhost:8080/api/users/doctors', false, stream_context_create([
        'http' => [
            'method' => 'GET',
            'header' => "Authorization: Bearer $token\r\n"
        ]
    ]));

    if ($res2 !== false) $doctors = json_decode($res2, true) ?? [];

    $error = $_GET['error'] ?? '';
    $success = $_GET['success'] ?? '';
    require 'views/appointment_add.php';
}

function submitAppointmentForm() {
    $token = $_SESSION['jwt_token'] ?? '';
    $payload = getPayloadFromToken($token);
    if ($payload['role'] !== 'staff') {
        echo "Bạn không có quyền thực hiện chức năng này.";
        return;
    }

    $data = [
        'patientId' => $_POST['patient_id'],
        'doctorId' => $_POST['doctor_id'],
        'appointmentTime' => $_POST['appointment_time'],
        'note' => $_POST['note'] ?? '',
        'createdBy' => $payload['id'] // người lập lịch là nhân viên
    ];

    $url = 'http://localhost:8080/api/appointments';
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
    $response = json_decode($result, true);

    if (!empty($response['id'])) {
        header('Location: index.php?url=appointment-add&success=Đặt lịch thành công');
    } else {
        $msg = $response['message'] ?? 'Đặt lịch thất bại';
        header('Location: index.php?url=appointment-add&error=' . urlencode($msg));
    }
}

function listAppointments() {
    $token = $_SESSION['jwt_token'] ?? '';
    $payload = getPayloadFromToken($token);
    if ($payload['role'] !== 'staff') {
        echo "Bạn không có quyền truy cập chức năng này.";
        return;
    }

    // 1. Gọi API lấy danh sách lịch khám
    $url = 'http://localhost:8080/api/appointments';
    $opts = [
        'http' => [
            'method' => 'GET',
            'header' => "Authorization: Bearer $token\r\n"
        ]
    ];

    $context = stream_context_create($opts);
    $res = @file_get_contents($url, false, $context);
    $appointments = json_decode($res, true) ?? [];

    // 2. Gọi danh sách bệnh nhân (patient_service)
    $res2 = @file_get_contents('http://localhost:8080/api/patients', false, stream_context_create($opts));
    $patients = json_decode($res2, true) ?? [];

    // 3. Gọi danh sách bác sĩ (user_service)
    $res3 = @file_get_contents('http://localhost:8080/api/users/doctors', false, stream_context_create($opts));
    $doctors = json_decode($res3, true) ?? [];

    // 4. Tạo map để tra nhanh
    $patientMap = [];
    foreach ($patients as $p) $patientMap[$p['id']] = $p['fullName'];

    $doctorMap = [];
    foreach ($doctors as $d) $doctorMap[$d['id']] = $d['fullName'];

    // 5. Ghép dữ liệu tên vào từng appointment
    foreach ($appointments as $i => $a) {
    $appointments[$i]['patient_name'] = isset($patientMap[$a['patientId']])
        ? $patientMap[$a['patientId']]
        : '[Không rõ]';

    $appointments[$i]['doctor_name'] = isset($doctorMap[$a['doctorId']])
        ? $doctorMap[$a['doctorId']]
        : '[Không rõ]';
    }

    usort($appointments, function ($a, $b) {
        // Sắp theo updated_at DESC
        $timeA = strtotime($a['updatedAt'] ?? $a['appointmentTime']);
        $timeB = strtotime($b['updatedAt'] ?? $b['appointmentTime']);
    return $timeB <=> $timeA;
    });
    require 'views/appointment_list.php';
}

function cancelAppointment() {
    $token = $_SESSION['jwt_token'] ?? '';
    $payload = getPayloadFromToken($token);
    if ($payload['role'] !== 'staff' && $payload['role'] !== 'doctor') {
        echo "Bạn không có quyền hủy lịch.";
        return;
    }

    if (!isset($_GET['id'])) {
        echo "Thiếu ID lịch khám.";
        return;
    }

    $id = intval($_GET['id']);
    $url = "http://localhost:8080/api/appointments/$id/cancel";

    $options = [
        'http' => [
            'method'  => 'PUT',
            'header'  => "Authorization: Bearer $token\r\n",
        ]
    ];
    $context = stream_context_create($options);
    $result = @file_get_contents($url, false, $context);
    $response = json_decode($result, true);

    if (!empty($response['success']) || strpos($http_response_header[0], '200') !== false) {
        if ($payload['role']=='staff') header("Location: index.php?url=appointment-list");
        else header("Location: index.php?url=my-appointments");
    } else {
        $msg = $response['message'] ?? 'Hủy lịch thất bại.';
        echo "<p style='color:red'>Lỗi: $msg</p>";
        echo "<p><a href='index.php?url=appointment-list'>Quay lại</a></p>";
    }
}

function editAppointmentForm() {
    $token = $_SESSION['jwt_token'] ?? '';
    $payload = getPayloadFromToken($token);
    if ($payload['role'] !== 'staff') {
        echo "Bạn không có quyền.";
        return;
    }

    if (!isset($_GET['id'])) {
        echo "Thiếu ID.";
        return;
    }

    $id = intval($_GET['id']);
    $patientName = isset($_GET['patientName']) ? urldecode($_GET['patientName']) : 'Không rõ';

    // Lấy chi tiết lịch khám
    $res = @file_get_contents("http://localhost:8080/api/appointments/$id", false, stream_context_create([
        'http' => [
            'method' => 'GET',
            'header' => "Authorization: Bearer $token\r\n"
        ]
    ]));

    $appointment = json_decode($res, true);

    if (!$appointment || $appointment['status'] !== 'Đang chờ') {
        echo "Không thể sửa lịch này (chỉ sửa khi đang chờ).";
        return;
    }

    // Lấy danh sách bác sĩ
    $res3 = @file_get_contents("http://localhost:8080/api/users/doctors", false, stream_context_create([
        'http' => [
            'method' => 'GET',
            'header' => "Authorization: Bearer $token\r\n"
        ]
    ]));
    $doctors = json_decode($res3, true) ?? [];

    require 'views/appointment_edit.php';
}


function updateAppointment() {
    $token = $_SESSION['jwt_token'] ?? '';
    $payload = getPayloadFromToken($token);
    if ($payload['role'] !== 'staff') {
        echo "Bạn không có quyền cập nhật.";
        return;
    }

    $id = intval($_POST['id']);
    $data = [
        'patientId' => $_POST['patientId'],
        'doctorId' => $_POST['doctorId'],
        'appointmentTime' => $_POST['appointmentTime'],
        'note' => $_POST['note'] ?? '',
        'createdBy' => $_POST['createdBy']
    ];

    $url = "http://localhost:8080/api/appointments/$id";
    $options = [
        'http' => [
            'method' => 'PUT',
            'header' => "Content-Type: application/json\r\nAuthorization: Bearer $token\r\n",
            'content' => json_encode($data)
        ]
    ];
    $context = stream_context_create($options);
    $res = @file_get_contents($url, false, $context);
    $response = json_decode($res, true);

    if (!empty($response['success']) || strpos($http_response_header[0], '200') !== false) {
        header("Location: index.php?url=appointment-list");
    } else {
        $msg = $response['message'] ?? 'Cập nhật thất bại';
        echo "<p style='color:red'>Lỗi: $msg</p>";
        echo "<p><a href='index.php?url=appointment-edit&id=$id'>Thử lại</a></p>";
    }
}

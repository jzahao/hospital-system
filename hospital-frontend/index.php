<?php
session_start();

$url = $_GET['url'] ?? 'home';

switch ($url) {
    case 'home':
        require 'views/home.php';
        break;

    case 'login':
        require 'controllers/auth.php';
        showLoginForm();
        break;

    case 'login-submit':
        require 'controllers/auth.php';
        handleLogin();
        break;

    case 'dashboard':
    if (!isset($_SESSION['jwt_token'])) {
        header('Location: index.php?url=home');
        exit;
    }

        require 'helpers/jwt_helper.php';
        $token = $_SESSION['jwt_token'];
        $payload = getPayloadFromToken($token);
        $role = $payload['role'] ?? '';

        require 'views/dashboard.php';
        break;

    case 'logout':
        session_destroy();
        header('Location: index.php?url=login');
        break;

    case 'patient-add':
        require 'controllers/patient.php';
        showAddPatientForm();
        break;

    case 'patient-add-submit':
        require 'controllers/patient.php';
        submitAddPatient();
        break;

    case 'appointment-add':
        require 'controllers/appointment.php';
        showAppointmentForm();
        break;

    case 'appointment-submit':
        require 'controllers/appointment.php';
        submitAppointmentForm();
        break;

    case 'appointment-list':
        require 'controllers/appointment.php';
        listAppointments();
        break;
        
    case 'appointment-cancel':
        require 'controllers/appointment.php';
        cancelAppointment();
        break;

    case 'appointment-edit':
        require 'controllers/appointment.php';
        editAppointmentForm();
        break;

    case 'appointment-update':
        require 'controllers/appointment.php';
        updateAppointment();
        break;

    case 'prescription-list':
        require 'controllers/prescription.php';
        showPrescriptionList();
        break;

    case 'prescription-confirm':
        require 'controllers/prescription.php';
        confirmPrescription();
        break;
        
    case 'my-appointments':
        require 'controllers/doctor.php';
        showMyAppointments();
        break;

    case 'appointment-confirm':
        require 'controllers/doctor.php';
        confirmAppointment();
        break;

    case 'appointment-complete':
        require 'controllers/doctor.php';
        completeAppointment();
        break;

    case 'prescription-add':
        require 'controllers/doctor.php';
        showCreatePrescriptionForm();
        break;

    case 'prescription-save':
        require 'controllers/doctor.php';
        savePrescription();
        break;

    case 'my-prescriptions':
        require 'controllers/doctor.php';
        showMyPrescriptions();
        break;

    case 'prescription-edit':
        require 'controllers/doctor.php';
        showEditPrescriptionForm();
        break;

    case 'prescription-update':
        require 'controllers/doctor.php';
        updatePrescription();
        break;

    case 'patient-search':
        require 'controllers/patient.php';
        searchPatients();
        break;

    case 'admin-statistics':
        require 'controllers/admin.php';
        showStatistics();
        break;        

    default:
        echo "404 - Trang không tồn tại";
        break;
}

package com.example.appointmentservice.service;

import com.example.appointmentservice.dto.AppointmentRequestDTO;
import com.example.appointmentservice.dto.AppointmentResponseDTO;

import java.util.List;

public interface AppointmentService {

    AppointmentResponseDTO createAppointment(AppointmentRequestDTO dto,  int createdBy);

    AppointmentResponseDTO updateAppointment(int id, AppointmentRequestDTO dto);

    AppointmentResponseDTO confirmAppointment(int id);

    AppointmentResponseDTO completeAppointment(int id);
    
    AppointmentResponseDTO cancelAppointment(int id);

    AppointmentResponseDTO getAppointmentById(int id);

    List<AppointmentResponseDTO> getAllAppointments();

    List<AppointmentResponseDTO> getAppointmentsByDoctorId(int doctorId);

	List<AppointmentResponseDTO> getAppointmentsByPatientId(int patientId);
}

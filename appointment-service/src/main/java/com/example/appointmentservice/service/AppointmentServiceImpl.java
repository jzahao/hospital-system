package com.example.appointmentservice.service;

import com.example.appointmentservice.dto.AppointmentRequestDTO;
import com.example.appointmentservice.dto.AppointmentResponseDTO;
import com.example.appointmentservice.dto.NotificationMessage;
import com.example.appointmentservice.model.Appointment;
import com.example.appointmentservice.repository.AppointmentRepository;
import com.example.appointmentservice.service.AppointmentService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.time.LocalDateTime;
import java.util.ArrayList;
import java.util.List;
import java.util.Optional;

@Service
public class AppointmentServiceImpl implements AppointmentService {

    @Autowired
    private AppointmentRepository appointmentRepository;
    
    @Autowired
    private NotificationSender notificationSender;

    @Override
    public AppointmentResponseDTO createAppointment(AppointmentRequestDTO dto,  int createdBy) {
        Appointment appointment = new Appointment();
        appointment.setPatientId(dto.getPatientId());
        appointment.setDoctorId(dto.getDoctorId());
        appointment.setCreatedBy(createdBy);
        appointment.setAppointmentTime(dto.getAppointmentTime());
        appointment.setNote(dto.getNote());
        appointment.setStatus("Đang chờ");
        appointment.setCreatedAt(LocalDateTime.now());
        appointment.setUpdatedAt(LocalDateTime.now());

        Appointment saved = appointmentRepository.save(appointment);

        return mapToResponse(saved);
    }

    @Override
    public AppointmentResponseDTO updateAppointment(int id, AppointmentRequestDTO dto) {
        Optional<Appointment> optional = appointmentRepository.findById(id);
        if (optional.isEmpty()) throw new RuntimeException("Không tìm thấy lịch khám!");

        Appointment appointment = optional.get();
        //appointment.setPatientId(dto.getPatientId());
        appointment.setDoctorId(dto.getDoctorId());
        appointment.setCreatedBy(dto.getCreatedBy());
        appointment.setAppointmentTime(dto.getAppointmentTime());
        appointment.setNote(dto.getNote());
        appointment.setUpdatedAt(LocalDateTime.now());

        return mapToResponse(appointmentRepository.save(appointment));
    }
    
    @Override
    public AppointmentResponseDTO confirmAppointment(int id) {
        Optional<Appointment> optional = appointmentRepository.findById(id);
        if (optional.isEmpty()) throw new RuntimeException("Không tìm thấy lịch khám!");

        Appointment appointment = optional.get();
        appointment.setStatus("Đã xác nhận");
        appointment.setUpdatedAt(LocalDateTime.now());

        Appointment saved = appointmentRepository.save(appointment);

        // Gửi thông báo nhắc lịch
        NotificationMessage message = new NotificationMessage();
        message.setPatientId(saved.getPatientId());
        message.setType("reminder");
        message.setContent("Lịch khám của bạn đã được xác nhận vào lúc " + saved.getAppointmentTime());
        message.setAppointmentTime(saved.getAppointmentTime());

        notificationSender.sendNotification(message);

        return mapToResponse(saved);
    }

    @Override
    public AppointmentResponseDTO completeAppointment(int id) {
        Optional<Appointment> optional = appointmentRepository.findById(id);
        if (optional.isEmpty()) throw new RuntimeException("Không tìm thấy lịch khám!");

        Appointment appointment = optional.get();
        appointment.setStatus("Đã khám");
        appointment.setUpdatedAt(LocalDateTime.now());

        return mapToResponse(appointmentRepository.save(appointment));
    }
    
    @Override
    public AppointmentResponseDTO cancelAppointment(int id) {
        Optional<Appointment> optional = appointmentRepository.findById(id);
        if (optional.isEmpty()) throw new RuntimeException("Không tìm thấy lịch khám!");

        Appointment appointment = optional.get();
        appointment.setStatus("Hủy");
        appointment.setUpdatedAt(LocalDateTime.now());
        
        return mapToResponse(appointmentRepository.save(appointment));
    }

    @Override
    public AppointmentResponseDTO getAppointmentById(int id) {
        Optional<Appointment> optional = appointmentRepository.findById(id);
        if (optional.isEmpty()) throw new RuntimeException("Không tìm thấy lịch khám!");
        return mapToResponse(optional.get());
    }
    
    @Override
    public List<AppointmentResponseDTO> getAllAppointments() {
        List<Appointment> list = appointmentRepository.findAll();
        List<AppointmentResponseDTO> result = new ArrayList<>();
        for (Appointment a : list) {
            result.add(mapToResponse(a));
        }
        return result;
    }
    
    @Override
    public List<AppointmentResponseDTO> getAppointmentsByPatientId(int patientId) {
        List<Appointment> list = appointmentRepository.findByPatientId(patientId);
        List<AppointmentResponseDTO> result = new ArrayList<>();
        for (Appointment a : list) {
            result.add(mapToResponse(a));
        }
        return result;
    }

    @Override
    public List<AppointmentResponseDTO> getAppointmentsByDoctorId(int doctorId) {
        List<Appointment> list = appointmentRepository.findByDoctorId(doctorId);
        List<AppointmentResponseDTO> result = new ArrayList<>();
        for (Appointment a : list) {
            result.add(mapToResponse(a));
        }
        return result;
    }

    private AppointmentResponseDTO mapToResponse(Appointment a) {
        return new AppointmentResponseDTO(
            a.getId(),
            a.getPatientId(),
            a.getDoctorId(),
            a.getCreatedBy(),
            a.getAppointmentTime(),
            a.getStatus(),
            a.getNote(),
            a.getCreatedAt(),
            a.getUpdatedAt()
        );
    }
}

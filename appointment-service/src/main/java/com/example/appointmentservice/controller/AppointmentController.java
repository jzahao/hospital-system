package com.example.appointmentservice.controller;

import com.example.appointmentservice.dto.AppointmentRequestDTO;
import com.example.appointmentservice.dto.AppointmentResponseDTO;
import com.example.appointmentservice.service.AppointmentService;
import com.example.appointmentservice.util.JwtUtil;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping("/api/appointments")
public class AppointmentController {

	@Autowired
    private AppointmentService appointmentService;

    @Autowired
    private JwtUtil jwtUtil;

    @PostMapping
    public AppointmentResponseDTO createAppointment(@RequestBody AppointmentRequestDTO dto,
                                                    @RequestHeader("Authorization") String token) {
        String role = jwtUtil.extractRole(token);
        int userId = jwtUtil.extractUserId(token);
        if (!role.equals("staff")) {
            throw new RuntimeException("Chỉ nhân viên mới được tạo lịch khám");
        }
        return appointmentService.createAppointment(dto, userId);
    }

    // Nhan vien cap nhat lich kham
    @PutMapping("/{id}")
    public AppointmentResponseDTO updateAppointment(@PathVariable int id,
                                                    @RequestBody AppointmentRequestDTO dto,
                                                    @RequestHeader("Authorization") String token) {
        String role = jwtUtil.extractRole(token);
        if (!role.equals("staff")) {
            throw new RuntimeException("Chỉ nhân viên mới được cập nhật lịch khám");
        }
        return appointmentService.updateAppointment(id, dto);
    }

    // Huy lich kham
    @PutMapping("/{id}/cancel")
    public AppointmentResponseDTO cancelAppointment(@PathVariable int id,
                                  					@RequestHeader("Authorization") String token) {
        String role = jwtUtil.extractRole(token);
        if (!role.equals("staff") && !role.equals("doctor")) {
            throw new RuntimeException("Chỉ nhân viên hoặc bác sĩ mới được huỷ lịch");
        }
        return appointmentService.cancelAppointment(id);
    }

    // Bac si xac nhan lich kham
    @PutMapping("/{id}/confirm")
    public AppointmentResponseDTO confirmAppointment(@PathVariable int id,
                                                     @RequestHeader("Authorization") String token) {
        String role = jwtUtil.extractRole(token);
        if (!role.equals("doctor")) {
            throw new RuntimeException("Chỉ bác sĩ mới được xác nhận lịch");
        }
        return appointmentService.confirmAppointment(id);
    }

    // Bac si xac nhan da kham xong
    @PutMapping("/{id}/complete")
    public AppointmentResponseDTO completeAppointment(@PathVariable int id,
                                                      @RequestHeader("Authorization") String token) {
        String role = jwtUtil.extractRole(token);
        if (!role.equals("doctor")) {
            throw new RuntimeException("Chỉ bác sĩ mới được hoàn tất lịch khám");
        }
        return appointmentService.completeAppointment(id);
    }

    @GetMapping("/{id}")
    public AppointmentResponseDTO getAppointmentById(@PathVariable int id) {
        return appointmentService.getAppointmentById(id);
    }

    @GetMapping
    public List<AppointmentResponseDTO> getAllAppointments() {
        return appointmentService.getAllAppointments();
    }
    
    @GetMapping("/patient/{patientId}")
    public List<AppointmentResponseDTO> getAppointmentsByPatientId(@PathVariable int patientId) {
        return appointmentService.getAppointmentsByPatientId(patientId);
    }

    @GetMapping("/doctor/{doctorId}")
    public List<AppointmentResponseDTO> getAppointmentsByDoctorId(@PathVariable int doctorId) {
        return appointmentService.getAppointmentsByDoctorId(doctorId);
    }
}

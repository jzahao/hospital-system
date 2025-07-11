package com.example.prescriptionservice.controller;

import com.example.prescriptionservice.dto.PrescriptionRequestDTO;
import com.example.prescriptionservice.dto.PrescriptionResponseDTO;
import com.example.prescriptionservice.dto.PrescriptionStatusUpdateDTO;
import com.example.prescriptionservice.dto.PrescriptionUpdateRequestDTO;
import com.example.prescriptionservice.dto.StatisticResponseDTO;
import com.example.prescriptionservice.service.PrescriptionService;
import com.example.prescriptionservice.util.JwtUtil;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.web.bind.annotation.*;
import org.springframework.web.server.ResponseStatusException;

@RestController
@RequestMapping("/api/prescriptions")
public class PrescriptionController {

    @Autowired
    private PrescriptionService prescriptionService;
    
    @Autowired
    private JwtUtil jwtUtil;

    @PostMapping
    public PrescriptionResponseDTO createPrescription(@RequestBody PrescriptionRequestDTO request,
                                                      @RequestHeader("Authorization") String token) {
        String role = jwtUtil.extractRole(token);
        int userId = jwtUtil.extractUserId(token);

        if (!"doctor".equalsIgnoreCase(role)) {
            throw new RuntimeException("Bạn không có quyền tạo đơn thuốc!");
        }

        request.setPrescribedBy(userId);
        return prescriptionService.createPrescription(request);
    }
    
    @PutMapping("/{id}")
    public PrescriptionResponseDTO updatePrescription(
            @PathVariable int id,
            @RequestBody PrescriptionUpdateRequestDTO request,
            @RequestHeader("Authorization") String token) {

        String role = jwtUtil.extractRole(token);
        if (!"doctor".equalsIgnoreCase(role)) {
            throw new RuntimeException("Bạn không có quyền cập nhật đơn thuốc!");
        }

        return prescriptionService.updatePrescription(id, request);
    }
    
    @GetMapping("/{id}")
    public PrescriptionResponseDTO getPrescriptionById(@PathVariable int id) {
        return prescriptionService.getPrescriptionById(id);
    }
    
    @GetMapping("/patient/{patientId}")
    public List<PrescriptionResponseDTO> getPrescriptionsByPatient(@PathVariable int patientId) {
        return prescriptionService.getPrescriptionsByPatientId(patientId);
    }
    
    @GetMapping("/doctor/{doctorId}")
    public List<PrescriptionResponseDTO> getPrescriptionsByDoctor(@PathVariable int doctorId) {
        return prescriptionService.getPrescriptionsByDoctorId(doctorId);
    }
    
    @GetMapping
    public List<PrescriptionResponseDTO> getAllPrescriptions() {
        return prescriptionService.getAllPrescriptions();
    }
    
    @PutMapping("/{id}/status")
    public PrescriptionResponseDTO updateStatus(
            @PathVariable int id,
            @RequestBody PrescriptionStatusUpdateDTO request,
            @RequestHeader("Authorization") String token) {

        String role = jwtUtil.extractRole(token);
        if (!"staff".equalsIgnoreCase(role)) {
            throw new ResponseStatusException(HttpStatus.FORBIDDEN, "Bạn không có quyền cập nhật trạng thái đơn thuốc!");
        }

        return prescriptionService.updateStatus(id, request.getStatus());
    }
    
    @GetMapping("/stats/count-by-month")
    public List<StatisticResponseDTO> countByMonth(
            @RequestParam int year,
            @RequestHeader("Authorization") String token) {

        String role = jwtUtil.extractRole(token);
        if (!"admin".equalsIgnoreCase(role)) {
            throw new ResponseStatusException(HttpStatus.FORBIDDEN, "Bạn không có quyền xem thống kê!");
        }

        return prescriptionService.countByMonth(year);
    }

    @GetMapping("/stats/total-by-month")
    public List<StatisticResponseDTO> totalByMonth(
            @RequestParam int year,
            @RequestHeader("Authorization") String token) {

        String role = jwtUtil.extractRole(token);
        if (!"admin".equalsIgnoreCase(role)) {
            throw new ResponseStatusException(HttpStatus.FORBIDDEN, "Bạn không có quyền xem thống kê!");
        }

        return prescriptionService.totalByMonth(year);
    }

    @GetMapping("/stats/total-by-quarter")
    public List<StatisticResponseDTO> totalByQuarter(
            @RequestParam int year,
            @RequestHeader("Authorization") String token) {

        String role = jwtUtil.extractRole(token);
        if (!"admin".equalsIgnoreCase(role)) {
            throw new ResponseStatusException(HttpStatus.FORBIDDEN, "Bạn không có quyền xem thống kê!");
        }

        return prescriptionService.totalByQuarter(year);
    }

    @GetMapping("/stats/total-by-year")
    public List<StatisticResponseDTO> totalByYear(
            @RequestHeader("Authorization") String token) {

        String role = jwtUtil.extractRole(token);
        if (!"admin".equalsIgnoreCase(role)) {
            throw new ResponseStatusException(HttpStatus.FORBIDDEN, "Bạn không có quyền xem thống kê!");
        }

        return prescriptionService.totalByYear();
    }

}

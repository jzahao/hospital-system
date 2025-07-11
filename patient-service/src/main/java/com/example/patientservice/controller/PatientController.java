package com.example.patientservice.controller;

import com.example.patientservice.dto.StatisticResponseDTO;
import com.example.patientservice.model.Patient;
import com.example.patientservice.security.JWTUtils;
import com.example.patientservice.service.PatientService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;
import org.springframework.web.server.ResponseStatusException;

import java.util.List;

@RestController
@RequestMapping("/api/patients")
public class PatientController {

    @Autowired
    private PatientService patientService;
    
    @Autowired
    private JWTUtils jwtUtils;
    
    private boolean isStaff(String authHeader) {
        if (authHeader == null || !authHeader.startsWith("Bearer ")) return false;
        String role = jwtUtils.extractRole(authHeader);
        return "staff".equalsIgnoreCase(role);
    }

    @GetMapping
    public List<Patient> getAllPatients() {
        return patientService.getAllPatients();
    }

    @GetMapping("/{id}")
    public ResponseEntity<Patient> getPatient(@PathVariable int id) {
        return patientService.getPatientById(id)
                .map(ResponseEntity::ok)
                .orElse(ResponseEntity.notFound().build());
    }
    
    @GetMapping("/search")
    public ResponseEntity<?> searchPatients(
            @RequestParam String keyword,
            @RequestHeader("Authorization") String authHeader) {

        String role = jwtUtils.extractRole(authHeader);
        if (role == null || role.isEmpty()) {
            return ResponseEntity.status(HttpStatus.UNAUTHORIZED).body("Token không hợp lệ!");
        }

        List<Patient> results = patientService.searchPatientsByName(keyword);
        return ResponseEntity.ok(results);
    }

    @PostMapping
    public ResponseEntity<?> createPatient(@RequestBody Patient patient,
                                           @RequestHeader("Authorization") String authHeader) {
        if (!isStaff(authHeader)) {
            return ResponseEntity.status(403).body("Bạn không có quyền thực hiện thao tác này.");
        }
        Patient saved = patientService.createPatient(patient);
        return ResponseEntity.ok(saved);
    }

    @PutMapping("/{id}")
    public ResponseEntity<?> updatePatient(@PathVariable int id,
                                           @RequestBody Patient patient,
                                           @RequestHeader("Authorization") String authHeader) {
        if (!isStaff(authHeader)) {
            return ResponseEntity.status(403).body("Bạn không có quyền thực hiện thao tác này.");
        }
        return patientService.updatePatient(id, patient)
                .map(ResponseEntity::ok)
                .orElse(ResponseEntity.notFound().build());
    }

    @DeleteMapping("/{id}")
    public ResponseEntity<?> deletePatient(@PathVariable int id,
                                           @RequestHeader("Authorization") String authHeader) {
        if (!isStaff(authHeader)) {
            return ResponseEntity.status(403).body("Bạn không có quyền thực hiện thao tác này.");
        }
        boolean deleted = patientService.deletePatient(id);
        return deleted ? ResponseEntity.ok().build() : ResponseEntity.notFound().build();
    }
    
    @GetMapping("/stats/count-by-month")
    public List<StatisticResponseDTO> countPatientsByMonth(
            @RequestParam int year,
            @RequestHeader("Authorization") String token) {

        String role = jwtUtils.extractRole(token);
        if (!"admin".equalsIgnoreCase(role)) {
            throw new ResponseStatusException(HttpStatus.FORBIDDEN, "Bạn không có quyền xem thống kê!");
        }

        return patientService.countPatientsByMonth(year);
    }
}

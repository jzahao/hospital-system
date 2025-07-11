package com.example.patientservice.service;

import com.example.patientservice.dto.StatisticResponseDTO;
import com.example.patientservice.model.Patient;
import com.example.patientservice.repository.PatientRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.time.LocalDateTime;
import java.util.List;
import java.util.Optional;
import java.util.stream.Collectors;

@Service
public class PatientService {

    @Autowired
    private PatientRepository patientRepository;

    public List<Patient> getAllPatients() {
        return patientRepository.findAll();
    }

    public Optional<Patient> getPatientById(int id) {
        return patientRepository.findById(id);
    }
    
    public List<Patient> searchPatientsByName(String keyword) {
        return patientRepository.findByFullNameContaining(keyword);
    }

    public Patient createPatient(Patient patient) {
        patient.setCreatedAt(LocalDateTime.now());
        patient.setUpdatedAt(LocalDateTime.now());
        return patientRepository.save(patient);
    }

    public Optional<Patient> updatePatient(int id, Patient updatedPatient) {
        Optional<Patient> existing = patientRepository.findById(id);
        if (existing.isPresent()) {
            Patient patient = existing.get();
            patient.setFullName(updatedPatient.getFullName());
            patient.setGender(updatedPatient.getGender());
            patient.setDateOfBirth(updatedPatient.getDateOfBirth());
            patient.setPhoneNumber(updatedPatient.getPhoneNumber());
            patient.setEmail(updatedPatient.getEmail());
            patient.setUpdatedAt(LocalDateTime.now());
            return Optional.of(patientRepository.save(patient));
        }
        return Optional.empty();
    }

    public boolean deletePatient(int id) {
        if (patientRepository.existsById(id)) {
            patientRepository.deleteById(id);
            return true;
        }
        return false;
    }
    
    public List<StatisticResponseDTO> countPatientsByMonth(int year) {
        List<Object[]> data = patientRepository.countPatientsByMonth(year);
        return data.stream()
                .map(obj -> new StatisticResponseDTO("Tháng " + obj[0], ((Number) obj[1]).longValue()))
                .collect(Collectors.toList());
    }
}

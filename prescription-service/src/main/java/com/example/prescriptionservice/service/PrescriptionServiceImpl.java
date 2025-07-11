package com.example.prescriptionservice.service;

import com.example.prescriptionservice.dto.NotificationMessage;
import com.example.prescriptionservice.dto.PrescriptionRequestDTO;
import com.example.prescriptionservice.dto.PrescriptionResponseDTO;
import com.example.prescriptionservice.dto.PrescriptionUpdateRequestDTO;
import com.example.prescriptionservice.dto.StatisticResponseDTO;
import com.example.prescriptionservice.model.Prescription;
import com.example.prescriptionservice.repository.PrescriptionRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.time.LocalDateTime;
import java.util.List;
import java.util.Optional;
import java.util.stream.Collectors;

@Service
public class PrescriptionServiceImpl implements PrescriptionService {

    @Autowired
    private PrescriptionRepository prescriptionRepository;
    
    @Autowired
    private NotificationSender notificationSender;
    
    @Override
    public PrescriptionResponseDTO createPrescription(PrescriptionRequestDTO request) {
        Prescription prescription = new Prescription();
        prescription.setPatientId(request.getPatientId());
        prescription.setAppointmentId(request.getAppointmentId());
        prescription.setPrescribedBy(request.getPrescribedBy());
        prescription.setMedicineList(request.getMedicineList());
        prescription.setTotalPrice(request.getTotalPrice());
        prescription.setNotes(request.getNotes());
        prescription.setStatus("Chưa lấy");
        prescription.setCreatedAt(LocalDateTime.now());
        prescription.setUpdatedAt(LocalDateTime.now());

        Prescription saved = prescriptionRepository.save(prescription);

        PrescriptionResponseDTO response = new PrescriptionResponseDTO();
        response.setId(saved.getId());
        response.setPatientId(saved.getPatientId());
        response.setAppointmentId(saved.getAppointmentId());
        response.setPrescribedBy(saved.getPrescribedBy());
        response.setStatus(saved.getStatus());
        response.setMedicineList(saved.getMedicineList());
        response.setTotalPrice(saved.getTotalPrice());
        response.setNotes(saved.getNotes());
        response.setCreatedAt(saved.getCreatedAt());
        response.setUpdatedAt(saved.getUpdatedAt());
        
        NotificationMessage message = new NotificationMessage();
        message.setType("prescription");
        message.setPatientId(saved.getPatientId());
        message.setContent("Đơn thuốc của bạn đã sẵn sàng. Vui lòng đến quầy để nhận thuốc.");
        message.setCreatedAt(LocalDateTime.now());

        notificationSender.sendNotification(message);
        
        return response;
    }
    
    @Override
    public PrescriptionResponseDTO updatePrescription(int id, PrescriptionUpdateRequestDTO request) {
        Optional<Prescription> optional = prescriptionRepository.findById(id);
        if (optional.isEmpty()) {
            throw new RuntimeException("Không tìm thấy đơn thuốc!");
        }

        Prescription prescription = optional.get();
        prescription.setMedicineList(request.getMedicineList());
        prescription.setTotalPrice(request.getTotalPrice());
        prescription.setNotes(request.getNotes());
        prescription.setUpdatedAt(LocalDateTime.now());

        Prescription saved = prescriptionRepository.save(prescription);
        return mapToResponse(saved);
    }
    
    private PrescriptionResponseDTO mapToResponse(Prescription prescription) {
        PrescriptionResponseDTO dto = new PrescriptionResponseDTO();
        dto.setId(prescription.getId());
        dto.setPatientId(prescription.getPatientId());
        dto.setAppointmentId(prescription.getAppointmentId());
        dto.setPrescribedBy(prescription.getPrescribedBy());
        dto.setStatus(prescription.getStatus());
        dto.setMedicineList(prescription.getMedicineList());
        dto.setTotalPrice(prescription.getTotalPrice());
        dto.setNotes(prescription.getNotes());
        dto.setCreatedAt(prescription.getCreatedAt());
        dto.setUpdatedAt(prescription.getUpdatedAt());
        return dto;
    }
    
    @Override
    public PrescriptionResponseDTO getPrescriptionById(int id) {
        Optional<Prescription> optional = prescriptionRepository.findById(id);
        if (optional.isEmpty()) {
            throw new RuntimeException("Không tìm thấy đơn thuốc!");
        }
        return mapToResponse(optional.get());
    }
    
    @Override
    public List<PrescriptionResponseDTO> getPrescriptionsByPatientId(int patientId) {
        List<Prescription> list = prescriptionRepository.findByPatientId(patientId);
        return list.stream()
                .map(this::mapToResponse)
                .collect(Collectors.toList());
    }
    
    @Override
    public List<PrescriptionResponseDTO> getPrescriptionsByDoctorId(int doctorId) {
        List<Prescription> list = prescriptionRepository.findByPrescribedBy(doctorId);
        return list.stream()
                .map(this::mapToResponse)
                .collect(Collectors.toList());
    }
    
    @Override
    public List<PrescriptionResponseDTO> getAllPrescriptions() {
        List<Prescription> list = prescriptionRepository.findAllByOrderByUpdatedAtDesc();
        return list.stream()
                .map(this::mapToResponse)
                .collect(Collectors.toList());
    }
    
    @Override
    public PrescriptionResponseDTO updateStatus(int id, String status) {
        Optional<Prescription> optional = prescriptionRepository.findById(id);
        if (optional.isEmpty()) {
            throw new RuntimeException("Không tìm thấy đơn thuốc!");
        }

        Prescription prescription = optional.get();

        prescription.setStatus(status);
        prescription.setUpdatedAt(LocalDateTime.now());

        Prescription saved = prescriptionRepository.save(prescription);
        return mapToResponse(saved);
    }

    @Override
    public List<StatisticResponseDTO> countByMonth(int year) {
        List<Object[]> data = prescriptionRepository.countPrescriptionsByMonth(year);
        return data.stream()
                .map(obj -> new StatisticResponseDTO("Tháng " + obj[0], ((Number) obj[1]).longValue()))
                .collect(Collectors.toList());
    }

    @Override
    public List<StatisticResponseDTO> totalByMonth(int year) {
        List<Object[]> data = prescriptionRepository.totalPriceByMonth(year);
        return data.stream()
                .map(obj -> new StatisticResponseDTO("Tháng " + obj[0], ((Number) obj[1]).longValue()))
                .collect(Collectors.toList());
    }

    @Override
    public List<StatisticResponseDTO> totalByQuarter(int year) {
        List<Object[]> data = prescriptionRepository.totalPriceByQuarter(year);
        return data.stream()
                .map(obj -> new StatisticResponseDTO("Quý " + obj[0], ((Number) obj[1]).longValue()))
                .collect(Collectors.toList());
    }

    @Override
    public List<StatisticResponseDTO> totalByYear() {
        List<Object[]> data = prescriptionRepository.totalPriceByYear();
        return data.stream()
                .map(obj -> new StatisticResponseDTO("Năm " + obj[0], ((Number) obj[1]).longValue()))
                .collect(Collectors.toList());
    }

}

package com.example.prescriptionservice.service;

import java.util.List;

import com.example.prescriptionservice.dto.PrescriptionRequestDTO;
import com.example.prescriptionservice.dto.PrescriptionResponseDTO;
import com.example.prescriptionservice.dto.PrescriptionUpdateRequestDTO;
import com.example.prescriptionservice.dto.StatisticResponseDTO;

public interface PrescriptionService {
	
    PrescriptionResponseDTO createPrescription(PrescriptionRequestDTO request);
    
    PrescriptionResponseDTO updatePrescription(int id, PrescriptionUpdateRequestDTO request);
    
    PrescriptionResponseDTO getPrescriptionById(int id);
    
    List<PrescriptionResponseDTO> getPrescriptionsByPatientId(int patientId);
    
    List<PrescriptionResponseDTO> getAllPrescriptions();
    
    PrescriptionResponseDTO updateStatus(int id, String status);
    
    List<StatisticResponseDTO> countByMonth(int year);
    List<StatisticResponseDTO> totalByMonth(int year);
    List<StatisticResponseDTO> totalByQuarter(int year);
    List<StatisticResponseDTO> totalByYear();
}

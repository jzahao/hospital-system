package com.example.prescriptionservice.dto;

import java.time.LocalDateTime;

public class PrescriptionResponseDTO {
    private int id;
    private int patientId;
    private int appointmentId;
    private int prescribedBy;
    private String status;
    private String medicineList;
    private int totalPrice;
    private String notes;
    private LocalDateTime createdAt;
    private LocalDateTime updatedAt;
	public int getId() {
		return id;
	}
	public void setId(int id) {
		this.id = id;
	}
	public int getPatientId() {
		return patientId;
	}
	public void setPatientId(int patientId) {
		this.patientId = patientId;
	}
	public int getAppointmentId() {
		return appointmentId;
	}
	public void setAppointmentId(int appointmentId) {
		this.appointmentId = appointmentId;
	}
	public int getPrescribedBy() {
		return prescribedBy;
	}
	public void setPrescribedBy(int prescribedBy) {
		this.prescribedBy = prescribedBy;
	}
	public String getStatus() {
		return status;
	}
	public void setStatus(String status) {
		this.status = status;
	}
	public String getMedicineList() {
		return medicineList;
	}
	public void setMedicineList(String medicineList) {
		this.medicineList = medicineList;
	}
	public int getTotalPrice() {
		return totalPrice;
	}
	public void setTotalPrice(int totalPrice) {
		this.totalPrice = totalPrice;
	}
	public String getNotes() {
		return notes;
	}
	public void setNotes(String notes) {
		this.notes = notes;
	}
	public LocalDateTime getCreatedAt() {
		return createdAt;
	}
	public void setCreatedAt(LocalDateTime createdAt) {
		this.createdAt = createdAt;
	}
	public LocalDateTime getUpdatedAt() {
		return updatedAt;
	}
	public void setUpdatedAt(LocalDateTime updatedAt) {
		this.updatedAt = updatedAt;
	}
}

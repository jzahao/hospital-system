package com.example.prescriptionservice.model;


import jakarta.persistence.*;
import java.time.LocalDateTime;

@Entity
@Table(name = "prescriptions")
public class Prescription {
	
	@Id
	@GeneratedValue(strategy = GenerationType.IDENTITY)
	private int id;
	
	@Column(name = "patient_id", nullable = false)
    private int patientId;
	
	@Column(name = "appointment_id", nullable = false)
    private int appointmentId;
	
	@Column(name = "prescribed_by", nullable = false)
    private int prescribedBy;
	
	@Column
    private String status;
	
	@Column(name = "medicine_list", nullable = false)
    private String medicineList;
	
	@Column(name = "total_price", nullable = false)
    private int totalPrice;
	
	@Column
    private String notes;
	
	@Column(name = "created_at")
    private LocalDateTime createdAt;
	
	@Column(name = "updated_at")
    private LocalDateTime updatedAt;
	
	public Prescription() {
    }
	
	public Prescription(int id, int patientId, int appointmentId, int prescribedBy, String status, String medicineList,
			int totalPrice, String notes, LocalDateTime createdAt, LocalDateTime updatedAt) {
		super();
		this.id = id;
		this.patientId = patientId;
		this.appointmentId = appointmentId;
		this.prescribedBy = prescribedBy;
		this.status = status;
		this.medicineList = medicineList;
		this.totalPrice = totalPrice;
		this.notes = notes;
		this.createdAt = createdAt;
		this.updatedAt = updatedAt;
	}
	
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

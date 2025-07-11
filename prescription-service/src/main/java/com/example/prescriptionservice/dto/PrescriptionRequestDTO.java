package com.example.prescriptionservice.dto;

public class PrescriptionRequestDTO {
    private int patientId;
    private int appointmentId;
    private int prescribedBy;
    private String medicineList;
    private int totalPrice;
    private String notes;
    
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
}

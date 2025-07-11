package com.example.prescriptionservice.dto;

public class PrescriptionUpdateRequestDTO {
    private String medicineList;
    private int totalPrice;
    private String notes;
    
    public PrescriptionUpdateRequestDTO() {}
    
    public PrescriptionUpdateRequestDTO(String medicineList, int totalPrice, String notes) {
		super();
		this.medicineList = medicineList;
		this.totalPrice = totalPrice;
		this.notes = notes;
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

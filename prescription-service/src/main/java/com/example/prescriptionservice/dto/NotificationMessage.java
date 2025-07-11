package com.example.prescriptionservice.dto;

import java.time.LocalDateTime;

public class NotificationMessage {
	private String type;             // "prescription"
    private int patientId;
    private String content;
    private LocalDateTime createdAt;
    
    public NotificationMessage() {}
    
    public NotificationMessage(String type, int patientId, String content, LocalDateTime createdAt) {
		super();
		this.type = type;
		this.patientId = patientId;
		this.content = content;
		this.createdAt = createdAt;
	}
    
	public String getType() {
		return type;
	}
	public void setType(String type) {
		this.type = type;
	}
	public int getPatientId() {
		return patientId;
	}
	public void setPatientId(int patientId) {
		this.patientId = patientId;
	}
	public String getContent() {
		return content;
	}
	public void setContent(String content) {
		this.content = content;
	}
	public LocalDateTime getCreatedAt() {
		return createdAt;
	}
	public void setCreatedAt(LocalDateTime createdAt) {
		this.createdAt = createdAt;
	}
}

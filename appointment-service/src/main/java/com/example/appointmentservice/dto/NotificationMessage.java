package com.example.appointmentservice.dto;

import java.time.LocalDateTime;

public class NotificationMessage {
    private int patientId;
    private String type;
    private String content;
    private LocalDateTime appointmentTime;

    public NotificationMessage() {}

    public NotificationMessage(int patientId, String type, String content, LocalDateTime appointmentTime) {
        this.patientId = patientId;
        this.type = type;
        this.content = content;
        this.appointmentTime = appointmentTime;
    }

    public int getPatientId() {
        return patientId;
    }

    public void setPatientId(int patientId) {
        this.patientId = patientId;
    }

    public String getType() {
        return type;
    }

    public void setType(String type) {
        this.type = type;
    }

    public String getContent() {
        return content;
    }

    public void setContent(String content) {
        this.content = content;
    }

    public LocalDateTime getAppointmentTime() {
        return appointmentTime;
    }

    public void setAppointmentTime(LocalDateTime appointmentTime) {
        this.appointmentTime = appointmentTime;
    }
}

package com.example.notificationservice.dto;

//import java.time.LocalDateTime;

public class NotificationMessage {
    private String type;
    private int patientId;
    private String content;
    //private LocalDateTime appointmentTime;

    public NotificationMessage() {}

    public String getType() { return type; }
    public void setType(String type) { this.type = type; }

    public int getPatientId() { return patientId; }
    public void setPatientId(int patientId) { this.patientId = patientId; }

    public String getContent() { return content; }
    public void setContent(String content) { this.content = content; }

    //public LocalDateTime getAppointmentTime() { return appointmentTime; }
    //public void setAppointmentTime(LocalDateTime appointmentTime) { this.appointmentTime = appointmentTime; }
}

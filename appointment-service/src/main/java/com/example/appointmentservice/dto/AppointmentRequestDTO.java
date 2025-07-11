package com.example.appointmentservice.dto;

import java.time.LocalDateTime;

public class AppointmentRequestDTO {
    private int patientId;
    private int doctorId;
    private int createdBy;
    private LocalDateTime appointmentTime;
    private String note;

    public AppointmentRequestDTO() {}

    public AppointmentRequestDTO(int patientId, int doctorId, int createdBy,
                                 LocalDateTime appointmentTime, String note) {
        this.patientId = patientId;
        this.doctorId = doctorId;
        this.createdBy = createdBy;
        this.appointmentTime = appointmentTime;
        this.note = note;
    }

    public int getPatientId() {
        return patientId;
    }

    public void setPatientId(int patientId) {
        this.patientId = patientId;
    }

    public int getDoctorId() {
        return doctorId;
    }

    public void setDoctorId(int doctorId) {
        this.doctorId = doctorId;
    }

    public int getCreatedBy() {
        return createdBy;
    }

    public void setCreatedBy(int createdBy) {
        this.createdBy = createdBy;
    }

    public LocalDateTime getAppointmentTime() {
        return appointmentTime;
    }

    public void setAppointmentTime(LocalDateTime appointmentTime) {
        this.appointmentTime = appointmentTime;
    }

    public String getNote() {
        return note;
    }

    public void setNote(String note) {
        this.note = note;
    }
}

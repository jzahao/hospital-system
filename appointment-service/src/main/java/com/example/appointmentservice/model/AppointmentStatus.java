package com.example.appointmentservice.model;

public enum AppointmentStatus {
    DANG_CHO("Đang chờ"),
    DA_XAC_NHAN("Đã xác nhận"),
    DA_KHAM("Đã khám"),
    HUY("Hủy");

    private final String value;

    AppointmentStatus(String value) {
        this.value = value;
    }

    public String getValue() {
        return value;
    }

    public static AppointmentStatus fromValue(String value) {
        for (AppointmentStatus status : values()) {
            if (status.getValue().equalsIgnoreCase(value)) {
                return status;
            }
        }
        throw new IllegalArgumentException("Không hợp lệ: " + value);
    }
}
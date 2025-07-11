package com.example.notificationservice.service;

import com.example.notificationservice.dto.NotificationMessage;
import com.example.notificationservice.model.Notification;
import com.example.notificationservice.repository.NotificationRepository;
import com.example.notificationservice.client.PatientClient;
import com.example.notificationservice.config.RabbitMQConfig;

import org.springframework.amqp.rabbit.annotation.RabbitListener;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.time.LocalDateTime;

@Service
public class NotificationListener {

    @Autowired
    private NotificationRepository notificationRepository;

    @Autowired
    private EmailService emailService;

    @Autowired
    private PatientClient patientClient;

    @RabbitListener(queues = RabbitMQConfig.APPOINTMENT_QUEUE)
    public void receiveNotification(NotificationMessage message) {
        System.out.println("Nhận thông báo lịch khám từ RabbitMQ:");
        System.out.println("- Bệnh nhân ID: " + message.getPatientId());
        System.out.println("- Nội dung: " + message.getContent());

        // Lưu vào MongoDB
        Notification notification = new Notification();
        notification.setType(message.getType());
        notification.setPatientId(message.getPatientId());
        notification.setContent(message.getContent());
        notification.setStatus("SENT");
        notification.setCreatedAt(LocalDateTime.now());
        notification.setSentAt(LocalDateTime.now());
        notificationRepository.save(notification);

        // Gửi email
        String email = patientClient.getPatientEmail(message.getPatientId());
        if (email != null) {
            emailService.sendEmail(
                email,
                "Nhắc lịch khám bệnh",
                message.getContent()
            );
        } else {
            System.err.println("Không thể gửi email: Không tìm thấy email bệnh nhân ID " + message.getPatientId());
        }
    }
    
    @RabbitListener(queues = RabbitMQConfig.PRESCRIPTION_QUEUE)
    public void receivePrescriptionNotification(NotificationMessage message) {
        System.out.println("Nhận thông báo đơn thuốc từ RabbitMQ:");
        System.out.println("- Bệnh nhân ID: " + message.getPatientId());
        System.out.println("- Nội dung: " + message.getContent());

        // Lưu vào MongoDB
        Notification notification = new Notification();
        notification.setType(message.getType());
        notification.setPatientId(message.getPatientId());
        notification.setContent(message.getContent());
        notification.setStatus("SENT");
        notification.setCreatedAt(LocalDateTime.now());
        notification.setSentAt(LocalDateTime.now());
        notificationRepository.save(notification);

        // Gửi email
        String email = patientClient.getPatientEmail(message.getPatientId());
        if (email != null) {
            emailService.sendEmail(
                email,
                "Nhắc lịch khám bệnh",
                message.getContent()
            );
        } else {
            System.err.println("Không thể gửi email: Không tìm thấy email bệnh nhân ID " + message.getPatientId());
        }
    }
}

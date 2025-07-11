package com.example.appointmentservice.repository;

import com.example.appointmentservice.model.Appointment;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import java.time.LocalDateTime;
import java.util.List;

@Repository
public interface AppointmentRepository extends JpaRepository<Appointment, Integer> {

	List<Appointment> findByPatientId(int patientId);
	
	List<Appointment> findByDoctorId(int doctorId);

    List<Appointment> findByCreatedBy(int createdBy);

    List<Appointment> findByAppointmentTimeBetween(LocalDateTime start, LocalDateTime end);

    List<Appointment> findByStatus(String status);
}

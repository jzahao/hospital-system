package com.example.patientservice.repository;

import com.example.patientservice.model.Patient;

import java.util.List;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;

public interface PatientRepository extends JpaRepository<Patient, Integer> {
	
	@Query("SELECT MONTH(p.createdAt) AS month, COUNT(p.id) AS count " +
		   "FROM Patient p " +
		   "WHERE YEAR(p.createdAt) = :year " +
		   "GROUP BY MONTH(p.createdAt) " +
		   "ORDER BY month ASC")
	List<Object[]> countPatientsByMonth(@Param("year") int year);
}

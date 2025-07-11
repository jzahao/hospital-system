package com.example.prescriptionservice.repository;

import com.example.prescriptionservice.model.Prescription;

import java.util.List;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;

public interface PrescriptionRepository extends JpaRepository<Prescription, Integer> {
	
	List<Prescription> findByPatientId(int patientId);
	
	List<Prescription> findAllByOrderByUpdatedAtDesc();
	
	// Số lượng đơn thuốc theo từng tháng trong năm cụ thể
	@Query("SELECT MONTH(p.createdAt) AS month, COUNT(p.id) AS count " +
	       "FROM Prescription p " +
	       "WHERE YEAR(p.createdAt) = :year " +
	       "GROUP BY MONTH(p.createdAt) " +
	       "ORDER BY month ASC")
	List<Object[]> countPrescriptionsByMonth(@Param("year") int year);

	// Tổng tiền theo tháng
	@Query("SELECT MONTH(p.createdAt) AS month, SUM(p.totalPrice) AS total " +
	       "FROM Prescription p " +
	       "WHERE YEAR(p.createdAt) = :year " +
	       "GROUP BY MONTH(p.createdAt) " +
	       "ORDER BY month ASC")
	List<Object[]> totalPriceByMonth(@Param("year") int year);

	// Tổng tiền theo quý
	@Query("SELECT CEIL(MONTH(p.createdAt)/3.0) AS quarter, SUM(p.totalPrice) AS total " +
	       "FROM Prescription p " +
	       "WHERE YEAR(p.createdAt) = :year " +
	       "GROUP BY CEIL(MONTH(p.createdAt)/3.0) " +
	       "ORDER BY quarter ASC")
	List<Object[]> totalPriceByQuarter(@Param("year") int year);

	// Tổng tiền theo năm
	@Query("SELECT YEAR(p.createdAt) AS year, SUM(p.totalPrice) AS total " +
	       "FROM Prescription p " +
	       "GROUP BY YEAR(p.createdAt) " +
	       "ORDER BY year ASC")
	List<Object[]> totalPriceByYear();

}

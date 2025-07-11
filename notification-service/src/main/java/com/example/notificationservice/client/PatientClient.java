package com.example.notificationservice.client;

import org.springframework.stereotype.Component;
import org.springframework.web.client.RestTemplate;
import org.springframework.http.ResponseEntity;
import org.json.JSONObject;

@Component
public class PatientClient {

    private final RestTemplate restTemplate = new RestTemplate();

    public String getPatientEmail(int patientId) {
        try {
            String url = "http://localhost:8082/api/patients/" + patientId;
            ResponseEntity<String> response = restTemplate.getForEntity(url, String.class);

            if (response.getStatusCode().is2xxSuccessful()) {
                JSONObject json = new JSONObject(response.getBody());
                return json.getString("email");
            }
        } catch (Exception e) {
            System.err.println("Không thể lấy email bệnh nhân: " + e.getMessage());
        }
        return null;
    }
}

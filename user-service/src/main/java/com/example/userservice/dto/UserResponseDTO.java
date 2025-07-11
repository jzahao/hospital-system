package com.example.userservice.dto;

public class UserResponseDTO {
    private int id;
    private String username;
    private String fullName;
    private String role;
    private String email;

    public UserResponseDTO() {}

    public UserResponseDTO(int id, String username, String fullName, String role, String email) {
        this.id = id;
        this.username = username;
        this.fullName = fullName;
        this.role = role;
        this.email = email;
    }

    public int getId() { return id; }
    public void setId(int id) { this.id = id; }

    public String getUsername() { return username; }
    public void setUsername(String username) { this.username = username; }

    public String getFullName() { return fullName; }
    public void setFullName(String fullName) { this.fullName = fullName; }

    public String getRole() { return role; }
    public void setRole(String role) { this.role = role; }

    public String getEmail() { return email; }
    public void setEmail(String email) { this.email = email; }
}

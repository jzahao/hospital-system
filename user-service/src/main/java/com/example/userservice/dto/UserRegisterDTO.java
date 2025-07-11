package com.example.userservice.dto;

public class UserRegisterDTO {
    private String username;
    private String password;
    private String fullName;
    private String role;
    private String email;

    public UserRegisterDTO() {}

    public UserRegisterDTO(String username, String password, String fullName, String role, String email) {
        this.username = username;
        this.password = password;
        this.fullName = fullName;
        this.role = role;
        this.email = email;
    }

    public String getUsername() { return username; }
    public void setUsername(String username) { this.username = username; }

    public String getPassword() { return password; }
    public void setPassword(String password) { this.password = password; }

    public String getFullName() { return fullName; }
    public void setFullName(String fullName) { this.fullName = fullName; }

    public String getRole() { return role; }
    public void setRole(String role) { this.role = role; }

    public String getEmail() { return email; }
    public void setEmail(String email) { this.email = email; }
}

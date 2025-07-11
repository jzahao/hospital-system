package com.example.userservice.controller;

import com.example.userservice.dto.UserLoginDTO;
import com.example.userservice.dto.UserRegisterDTO;
import com.example.userservice.dto.UserResponseDTO;
import com.example.userservice.service.UserService;

import java.util.List;

import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;
import com.example.userservice.dto.UserLoginResponseDTO;

@RestController
@RequestMapping("/api/users")
public class UserController {

    private final UserService userService;

    public UserController(UserService userService) {
        this.userService = userService;
    }

    @PostMapping("/register")
    public ResponseEntity<UserResponseDTO> registerUser(@RequestBody UserRegisterDTO dto) {
        UserResponseDTO createdUser = userService.register(dto);
        return ResponseEntity.ok(createdUser);
    }

    @PostMapping("/login")
    public ResponseEntity<UserLoginResponseDTO> loginUser(@RequestBody UserLoginDTO dto) {
        UserLoginResponseDTO response = userService.authenticate(dto);
        return ResponseEntity.ok(response);
    }
    
    @GetMapping("/doctors")
    public ResponseEntity<List<UserResponseDTO>> getAllDoctors() {
        return ResponseEntity.ok(userService.getAllDoctors());
    }
    
    @GetMapping("/staffs")
    public ResponseEntity<List<UserResponseDTO>> getAllStaffs() {
        return ResponseEntity.ok(userService.getAllStaffs());
    }
    
    @GetMapping("/{id}")
    public ResponseEntity<UserResponseDTO> getById(@PathVariable int id) {
        return ResponseEntity.ok(userService.getById(id));
    }
}

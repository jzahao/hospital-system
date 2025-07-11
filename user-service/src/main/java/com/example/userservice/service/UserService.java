package com.example.userservice.service;

import com.example.userservice.dto.UserLoginDTO;
import com.example.userservice.dto.UserRegisterDTO;
import com.example.userservice.dto.UserResponseDTO;
import com.example.userservice.model.User;
import com.example.userservice.repository.UserRepository;
import org.springframework.security.crypto.bcrypt.BCryptPasswordEncoder;
import org.springframework.stereotype.Service;
import com.example.userservice.dto.UserLoginResponseDTO;
import com.example.userservice.utils.JWTUtils;

import java.time.LocalDateTime;
import java.util.ArrayList;
import java.util.List;
import java.util.Optional;

@Service
public class UserService {

    private final UserRepository userRepository;
    private final BCryptPasswordEncoder passwordEncoder;
    private final JWTUtils jwtUtils;

    public UserService(UserRepository userRepository, JWTUtils jwtUtils) {
    	this.userRepository = userRepository;
        this.jwtUtils = jwtUtils;
        this.passwordEncoder = new BCryptPasswordEncoder();
    }

    public UserResponseDTO register(UserRegisterDTO dto) {
        if (userRepository.existsByUsername(dto.getUsername())) {
            throw new RuntimeException("Username already exists");
        }

        if (userRepository.existsByEmail(dto.getEmail())) {
            throw new RuntimeException("Email already exists");
        }

        User user = new User();
        user.setUsername(dto.getUsername());
        user.setPasswordHash(passwordEncoder.encode(dto.getPassword()));
        user.setFullName(dto.getFullName());
        user.setRole(dto.getRole());
        user.setEmail(dto.getEmail());
        user.setCreatedAt(LocalDateTime.now());

        User saved = userRepository.save(user);

        return new UserResponseDTO(
                saved.getId(),
                saved.getUsername(),
                saved.getFullName(),
                saved.getRole(),
                saved.getEmail()
        );
    }

    public UserLoginResponseDTO authenticate(UserLoginDTO dto) {
        Optional<User> optionalUser = userRepository.findByUsername(dto.getUsername());

        if (optionalUser.isEmpty()) {
            throw new RuntimeException("Invalid username or password");
        }

        User user = optionalUser.get();

        if (!passwordEncoder.matches(dto.getPassword(), user.getPasswordHash())) {
            throw new RuntimeException("Invalid username or password");
        }

        // Cập nhật last login
        user.setLastLoginAt(LocalDateTime.now());
        userRepository.save(user);

        UserResponseDTO userDTO = new UserResponseDTO(
                user.getId(),
                user.getUsername(),
                user.getFullName(),
                user.getRole(),
                user.getEmail()
        );

        // Tạo JWT
        String token = jwtUtils.generateToken(
        	    user.getId(),
        	    user.getUsername(),
        	    user.getRole()
        );

        return new UserLoginResponseDTO(userDTO, token);
    }
    
    public List<UserResponseDTO> getAllDoctors() {
        List<User> doctors = userRepository.findByRole("doctor");

        List<UserResponseDTO> responseList = new ArrayList<>();
        for (User user : doctors) {
            UserResponseDTO dto = new UserResponseDTO();
            dto.setId(user.getId());
            dto.setUsername(user.getUsername());
            dto.setFullName(user.getFullName());
            dto.setEmail(user.getEmail());
            dto.setRole(user.getRole());
            responseList.add(dto);
        }
        return responseList;
    }
}

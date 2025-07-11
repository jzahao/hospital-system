package com.example.prescriptionservice.util;

import io.jsonwebtoken.Claims;
import io.jsonwebtoken.Jwts;
import org.springframework.stereotype.Component;

@Component
public class JwtUtil {
	    
	private final String SECRET_KEY = "MySuperSecretKey123456789012345678901234567890";

	public String extractRole(String token) {
		Claims claims = extractAllClaims(token);
	    return claims.get("role", String.class);
	}
	
	public Integer extractUserId(String token) {
        Claims claims = extractAllClaims(token);
        return claims.get("user_id", Integer.class);
    }

	private Claims extractAllClaims(String token) {
	    return Jwts.parserBuilder()
	       .setSigningKey(SECRET_KEY.getBytes())
           .build()
           .parseClaimsJws(token.replace("Bearer ", ""))
           .getBody();
	}
}

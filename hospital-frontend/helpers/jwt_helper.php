<?php
function getPayloadFromToken($token) {
    $parts = explode('.', $token);
    if (count($parts) !== 3) return null;
    
    $payload = base64_decode(strtr($parts[1], '-_', '+/'));
    return json_decode($payload, true);
}

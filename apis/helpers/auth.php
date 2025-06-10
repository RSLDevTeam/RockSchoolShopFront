<?php
function rest_custom_check_jwt($headers) {
  if (!isset($headers['authorization'][0])) {
      return new WP_Error('unauthorized', 'Authorization header missing', ['status' => 401]);
  }

  $auth_header = trim($headers['authorization'][0]);
  if (empty($auth_header)) {
      return new WP_Error('unauthorized', 'Authorization header is empty', ['status' => 401]);
  }

  if (stripos($auth_header, 'Bearer ') !== 0) {
      return new WP_Error('unauthorized', 'Invalid Bearer token', ['status' => 401]);
  }

  $jwt = str_ireplace('Bearer ', '', $auth_header);
  $jwt_secret = get_field('jwt_secret', 'option');

  return verify_jwt_token($jwt, $jwt_secret);
}


function base64url_decode($data) {
  $remainder = strlen($data) % 4;
  if ($remainder) {
      $padlen = 4 - $remainder;
      $data .= str_repeat('=', $padlen);
  }
  return base64_decode(strtr($data, '-_', '+/'));
}

function base64url_encode($data) {
  return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}


function verify_jwt_token($jwt, $secret_key) {
  $parts = explode('.', $jwt);
  if (count($parts) !== 3) {
      return new WP_Error('invalid_token', 'Invalid JWT format', ['status' => 401]);
  }

  list($header_b64, $payload_b64, $signature_b64) = $parts;
  $header = json_decode(base64url_decode($header_b64), true);
  $payload = json_decode(base64url_decode($payload_b64), true);
  $signature = base64url_decode($signature_b64);

  $data_to_sign = "$header_b64.$payload_b64";
  $expected_signature = hash_hmac('sha256', $data_to_sign, $secret_key, true);

  if (!hash_equals($expected_signature, $signature)) {
      return new WP_Error('invalid_signature', 'Signature mismatch', ['status' => 401]);
  }

  if (isset($payload['exp']) && time() >= $payload['exp']) {
      return new WP_Error('expired_token', 'Token has expired', ['status' => 401]);
  }

  return $payload;
}



function create_jwt($email, $time) {
  $secret_key = get_field('jwt_secret', 'option');
  $header = ['typ' => 'JWT', 'alg' => 'HS256'];
  $payload = [
      'email' => $email,
      'iat' => time(),
      'exp' => time() + $time
  ];
  
  $header_encoded = base64url_encode(json_encode($header));
  $payload_encoded = base64url_encode(json_encode($payload));
  
  $signature = hash_hmac('sha256', "$header_encoded.$payload_encoded", $secret_key, true);
  $signature_encoded = base64url_encode($signature);

  return "$header_encoded.$payload_encoded.$signature_encoded";
}


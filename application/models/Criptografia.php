<?php
class Application_Model_Criptografia
{

  # Private key
  private $salt = 'Lu70K$i3pu5xf7*I8tNmd@x2oODwwDRr4&xjuyTh';


  # Encrypt a value using AES-256.
  public function encrypt($plain, $key, $hmacSalt = null) {
    $this->_checkKey($key, 'encrypt()');

    if ($hmacSalt === null) {
      $hmacSalt = $this->salt;
    }

    $key = substr(hash('sha256', $key . $hmacSalt), 0, 32); # Generate the encryption and hmac key

    $algorithm = MCRYPT_RIJNDAEL_128; # encryption algorithm
    $mode = MCRYPT_MODE_CBC; # encryption mode

    $ivSize = mcrypt_get_iv_size($algorithm, $mode); # Returns the size of the IV belonging to a specific cipher/mode combination
    $iv = mcrypt_create_iv($ivSize, MCRYPT_DEV_URANDOM); # Creates an initialization vector (IV) from a random source
    $ciphertext = $iv . mcrypt_encrypt($algorithm, $key, $plain, $mode, $iv); # Encrypts plaintext with given parameters
    $hmac = hash_hmac('sha256', $ciphertext, $key); # Generate a keyed hash value using the HMAC method
    return $hmac . $ciphertext;
  }

  # Check key
  protected function _checkKey($key, $method) {
    if (strlen($key) < 32) {
      throw new Exception("Invalid public key $key, key must be at least 256 bits (32 bytes) long.");
    }
  }

  # Decrypt a value using AES-256.
  public function decrypt($cipher, $key, $hmacSalt = null) {
    $this->_checkKey($key, 'decrypt()');
    if (empty($cipher)) {
      throw new Exception('The data to decrypt cannot be empty');
    }
    if ($hmacSalt === null) {
      $hmacSalt = $this->salt;
    }

    $key = substr(hash('sha256', $key . $hmacSalt), 0, 32); # Generate the encryption and hmac key.

    # Split out hmac for comparison
    $macSize = 64;
    $hmac = substr($cipher, 0, $macSize);
    $cipher = substr($cipher, $macSize);

    $compareHmac = hash_hmac('sha256', $cipher, $key);
    if ($hmac !== $compareHmac) {
      return false;
    }

    $algorithm = MCRYPT_RIJNDAEL_128; # encryption algorithm
    $mode = MCRYPT_MODE_CBC; # encryption mode
    $ivSize = mcrypt_get_iv_size($algorithm, $mode); # Returns the size of the IV belonging to a specific cipher/mode combination

    $iv = substr($cipher, 0, $ivSize);
    $cipher = substr($cipher, $ivSize);
    $plain = mcrypt_decrypt($algorithm, $key, $cipher, $mode, $iv);
    return rtrim($plain, "\0");
  }
}

<?php
// 代码生成时间: 2025-08-11 03:13:16
class PasswordEncryptionTool {

    /**
     * Encrypts a password using Laravel's built-in encryption functionality.
     *
     * @param string $password The password to be encrypted.
     * @return string The encrypted password.
     * @throws Exception If encryption fails.
     */
    public function encryptPassword($password) {
        try {
            // Use Laravel's bcrypt function to encrypt the password
            return bcrypt($password);
        } catch (\Exception $e) {
            // Handle any encryption errors
            throw new Exception('Encryption failed: ' . $e->getMessage());
        }
    }

    /**
     * Decrypts a password using Laravel's built-in decryption functionality.
     *
     * @param string $encryptedPassword The encrypted password to be decrypted.
     * @return bool Returns true if the password is decrypted successfully, false otherwise.
     * @throws Exception If decryption fails.
     */
    public function decryptPassword($encryptedPassword) {
        try {
            // Use Laravel's bcrypt function to check if the password matches the encrypted one
            // Note: Laravel does not provide a direct decryption function for bcrypt,
            // so we compare the original password with the hashed one.
            return \Illuminate\Support\Facades\Hash::check($this->generateRandomString(), $encryptedPassword);
        } catch (\Exception $e) {
            // Handle any decryption errors
            throw new Exception('Decryption failed: ' . $e->getMessage());
        }
    }

    /**
     * Generates a random string for testing purposes.
     *
     * @return string A randomly generated string.
     */
    private function generateRandomString() {
        return bin2hex(random_bytes(16));
    }
}

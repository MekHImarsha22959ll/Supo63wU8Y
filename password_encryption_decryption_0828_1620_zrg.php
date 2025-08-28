<?php
// 代码生成时间: 2025-08-28 16:20:47
use Illuminate\Support\Facades\Crypt;

class PasswordEncryptionDecryption
{
    /**
     * Encrypts a password using Laravel's encryption.
     *
     * @param string $password The password to encrypt.
     * @return string Encrypted password.
     * @throws Exception If encryption fails.
     */
    public function encryptPassword($password)
    {
        try {
            $encrypted = Crypt::encryptString($password);
            return $encrypted;
        } catch (Exception $e) {
            // Log the error and rethrow the exception.
            Log::error('Encryption failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Decrypts an encrypted password using Laravel's decryption.
     *
     * @param string $encryptedPassword The encrypted password to decrypt.
     * @return string Decrypted password.
     * @throws Exception If decryption fails.
     */
    public function decryptPassword($encryptedPassword)
    {
        try {
            $decrypted = Crypt::decryptString($encryptedPassword);
            return $decrypted;
        } catch (Exception $e) {
            // Log the error and rethrow the exception.
            Log::error('Decryption failed: ' . $e->getMessage());
            throw $e;
        }
    }
}

// Usage example
// $tool = new PasswordEncryptionDecryption();
// $encrypted = $tool->encryptPassword('mySecretPassword');
// $decrypted = $tool->decryptPassword($encrypted);

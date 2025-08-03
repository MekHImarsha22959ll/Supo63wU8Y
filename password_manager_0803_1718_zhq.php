<?php
// 代码生成时间: 2025-08-03 17:18:04
class PasswordManager
{
    /**
     * Encrypt a password.
     *
     * @param string $password The password to be encrypted.
     * @return string The encrypted password.
     * @throws Exception If encryption fails.
     */
    public function encryptPassword(string $password): string
    {
        try {
            // Laravel's encrypter requires a cipher and a key.
            // For now, we're using 'AES-128-CBC' as the cipher and a hardcoded key.
            // Ideally, the key should be stored securely and not hardcoded.
            $encrypted = Crypt::encryptString($password, config('app.key'));

            return $encrypted;
        } catch (Exception $e) {
            // Handle encryption errors.
            throw new Exception('Encryption failed: ' . $e->getMessage());
        }
    }

    /**
     * Decrypt a password.
     *
     * @param string $encryptedPassword The encrypted password to be decrypted.
     * @return string The decrypted password.
     * @throws Exception If decryption fails.
     */
    public function decryptPassword(string $encryptedPassword): string
    {
        try {
            // Laravel's encrypter requires a cipher and a key.
            // For now, we're using 'AES-128-CBC' as the cipher and a hardcoded key.
            // Ideally, the key should be stored securely and not hardcoded.
            $decrypted = Crypt::decryptString($encryptedPassword, config('app.key'));

            return $decrypted;
        } catch (Exception $e) {
            // Handle decryption errors.
            throw new Exception('Decryption failed: ' . $e->getMessage());
        }
    }
}

// Usage example:
try {
    $passwordManager = new PasswordManager();

    // Encrypt a password.
    $originalPassword = 'my_secret_password';
    $encryptedPassword = $passwordManager->encryptPassword($originalPassword);
    echo "Encrypted password: " . $encryptedPassword . "
";

    // Decrypt the password.
    $decryptedPassword = $passwordManager->decryptPassword($encryptedPassword);
    echo "Decrypted password: " . $decryptedPassword . "
";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "
";
}
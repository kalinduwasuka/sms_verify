<?php

require_once 'SmsOtpSenderInterface.php';

class BasicSmsOtpSender implements SmsOtpSenderInterface {
    /**
     * Simulates sending an OTP by logging it to a file.
     *
     * @param string $phoneNumber The phone number to send the OTP to.
     * @param string $otp The OTP to send.
     * @return bool True if the OTP was "sent" (logged) successfully, false otherwise.
     */
    public function sendOtp(string $phoneNumber, string $otp): bool {
        $logMessage = "[" . date("Y-m-d H:i:s") . "] OTP Sent to " . $phoneNumber . ": " . $otp . PHP_EOL;
        // Log to a file named 'sms_otp.log' in the project root.
        // Note: Ensure the script has write permissions to this file in a real environment.
        if (file_put_contents(__DIR__ . '/../sms_otp.log', $logMessage, FILE_APPEND)) {
            return true;
        }
        // Fallback to standard output if file logging fails
        echo "Fallback: " . $logMessage; 
        return false; 
    }

    /**
     * Generates a numeric OTP.
     *
     * @param int $length The length of the OTP to generate. Defaults to 6.
     * @return string The generated OTP.
     */
    public function generateOtp(int $length = 6): string {
        if ($length <= 0) {
            throw new InvalidArgumentException("OTP length must be a positive integer.");
        }
        $otp = '';
        for ($i = 0; $i < $length; $i++) {
            $otp .= random_int(0, 9);
        }
        return $otp;
    }
}

?>

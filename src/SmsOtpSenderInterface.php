<?php

interface SmsOtpSenderInterface {
    /**
     * Sends an OTP to the given phone number.
     *
     * @param string $phoneNumber The phone number to send the OTP to.
     * @param string $otp The OTP to send.
     * @return bool True if the OTP was sent successfully, false otherwise.
     */
    public function sendOtp(string $phoneNumber, string $otp): bool;

    /**
     * Generates an OTP.
     *
     * @param int $length The length of the OTP to generate. Defaults to 6.
     * @return string The generated OTP.
     */
    public function generateOtp(int $length = 6): string;
}

?>

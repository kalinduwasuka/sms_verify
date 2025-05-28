<?php

// Autoload or require the necessary files
// For a simple example, we'll use require_once.
// In a real project, you would likely use an autoloader (e.g., Composer).
require_once __DIR__ . '/src/SmsOtpSenderInterface.php';
require_once __DIR__ . '/src/BasicSmsOtpSender.php';

echo "Starting OTP Sender Example..." . PHP_EOL;

// Create an instance of the BasicSmsOtpSender
// In a real application, you might use dependency injection to get an instance
// of a class that implements SmsOtpSenderInterface.
$otpSender = new BasicSmsOtpSender();

// Define a phone number
$phoneNumber = "+15551234567"; // Replace with a test phone number if desired

// Generate an OTP
$otp = $otpSender->generateOtp(6); // Generate a 6-digit OTP
echo "Generated OTP for " . $phoneNumber . ": " . $otp . PHP_EOL;

// Send the OTP
echo "Attempting to send OTP..." . PHP_EOL;
if ($otpSender->sendOtp($phoneNumber, $otp)) {
    echo "OTP sent successfully (simulated by logging to sms_otp.log)." . PHP_EOL;
    echo "Please check the sms_otp.log file in the project root." . PHP_EOL;
} else {
    echo "Failed to send OTP." . PHP_EOL;
}

echo PHP_EOL . "Example finished." . PHP_EOL;

?>

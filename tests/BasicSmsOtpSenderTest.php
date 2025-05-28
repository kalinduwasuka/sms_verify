<?php

use PHPUnit\Framework\TestCase;

// Adjust the path based on your project structure if BasicSmsOtpSender.php is not in src relative to the project root
require_once __DIR__ . '/../src/BasicSmsOtpSender.php'; 

class BasicSmsOtpSenderTest extends TestCase {
    private $logFilePath;
    private BasicSmsOtpSender $sender;

    protected function setUp(): void {
        $this->sender = new BasicSmsOtpSender();
        // Define log file path relative to the project root
        $this->logFilePath = __DIR__ . '/../sms_otp.log'; 
        // Ensure no log file exists from previous runs before each test that uses it
        if (file_exists($this->logFilePath)) {
            unlink($this->logFilePath);
        }
    }

    protected function tearDown(): void {
        // Clean up the log file after tests that use it
        if (file_exists($this->logFilePath)) {
            unlink($this->logFilePath);
        }
    }

    public function testGenerateOtpDefaultLength(): void {
        $otp = $this->sender->generateOtp();
        $this->assertEquals(6, strlen($otp));
        $this->assertMatchesRegularExpression('/^[0-9]{6}$/', $otp);
    }

    public function testGenerateOtpCustomLength(): void {
        $otp = $this->sender->generateOtp(8);
        $this->assertEquals(8, strlen($otp));
        $this->assertMatchesRegularExpression('/^[0-9]{8}$/', $otp);
    }

    public function testGenerateOtpMinimumLength(): void {
        $otp = $this->sender->generateOtp(1);
        $this->assertEquals(1, strlen($otp));
        $this->assertMatchesRegularExpression('/^[0-9]{1}$/', $otp);
    }

    public function testGenerateOtpThrowsExceptionForZeroLength(): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("OTP length must be a positive integer.");
        $this->sender->generateOtp(0);
    }

    public function testGenerateOtpThrowsExceptionForNegativeLength(): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("OTP length must be a positive integer.");
        $this->sender->generateOtp(-5);
    }

    public function testSendOtpSuccessfullyLogsMessage(): void {
        $phoneNumber = "+1234567890";
        $otp = "123456";

        $result = $this->sender->sendOtp($phoneNumber, $otp);
        $this->assertTrue($result);
        $this->assertFileExists($this->logFilePath);

        $logContent = file_get_contents($this->logFilePath);
        $this->assertStringContainsString("OTP Sent to " . $phoneNumber . ": " . $otp, $logContent);
    }
    
    public function testSendOtpCreatesLogFileIfNotExists(): void {
        $this->assertFileDoesNotExist($this->logFilePath); // Ensure it's clean before this specific test
        
        $phoneNumber = "+9876543210";
        $otp = "654321";
        
        $this->sender->sendOtp($phoneNumber, $otp);
        
        $this->assertFileExists($this->logFilePath);
    }
}

?>

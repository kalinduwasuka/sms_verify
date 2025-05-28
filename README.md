# PHP SMS OTP Sender Library

This project provides a simple PHP interface and a basic implementation for sending One-Time Passwords (OTPs) via SMS. It's designed to be a foundational component that can be extended or used in various PHP projects requiring OTP functionality.

## Features

*   **`SmsOtpSenderInterface`**: Defines a contract for OTP sender services.
*   **`BasicSmsOtpSender`**: A straightforward implementation of the interface.
    *   Generates numeric OTPs of a specified length.
    *   Simulates sending OTPs by logging them to a file (`sms_otp.log`). This is useful for development and testing without incurring SMS costs or requiring actual SMS gateway credentials.
*   **Example Usage**: Demonstrates how to use the library.
*   **PHPUnit Tests**: Unit tests are provided for the `BasicSmsOtpSender` class.

## Directory Structure

```
.
├── src/                      # Source files
│   ├── SmsOtpSenderInterface.php # The main interface
│   └── BasicSmsOtpSender.php   # Basic implementation
├── tests/                    # Unit tests
│   └── BasicSmsOtpSenderTest.php
├── vendor/                   # Composer dependencies (e.g., PHPUnit) - gitignored
├── example.php               # Example script to demonstrate usage
├── sms_otp.log               # Log file for simulated OTP sending - gitignored
├── composer.json             # Composer project configuration
├── composer.lock             # Composer lock file - gitignored
├── phpunit.xml.dist          # PHPUnit configuration
└── README.md                 # This file
```

## Interface: `SmsOtpSenderInterface.php`

Located in the `src/` directory.

*   `public function sendOtp(string $phoneNumber, string $otp): bool;`
    *   Sends the given OTP string to the specified phone number.
    *   Returns `true` on successful sending, `false` otherwise.
*   `public function generateOtp(int $length = 6): string;`
    *   Generates a random numeric OTP.
    *   Accepts an optional `$length` parameter (defaults to 6).
    *   Returns the generated OTP string.

## Basic Implementation: `BasicSmsOtpSender.php`

Located in the `src/` directory. This class implements `SmsOtpSenderInterface`.

*   **`sendOtp(string $phoneNumber, string $otp): bool`**:
    *   Instead of sending a real SMS, this method logs the phone number and OTP to a file named `sms_otp.log` in the project root.
    *   This simulation is useful for development and testing.
*   **`generateOtp(int $length = 6): string`**:
    *   Generates a random string of numbers of the specified length.

## Usage (`example.php`)

The `example.php` script in the project root demonstrates how to:
1.  Instantiate `BasicSmsOtpSender`.
2.  Generate an OTP.
3.  "Send" the OTP using the `sendOtp` method.

To run the example:
```bash
php example.php
```
Check the `sms_otp.log` file to see the "sent" OTPs.

## Testing

Unit tests for `BasicSmsOtpSender` are located in the `tests/` directory (`BasicSmsOtpSenderTest.php`). PHPUnit is used as the testing framework.

**To run the tests (assuming a correctly configured environment):**
1.  Ensure Composer dependencies are installed: `composer install`
2.  Execute PHPUnit from the project root:
    ```bash
    ./vendor/bin/phpunit
    ```
    or
    ```bash
    php vendor/bin/phpunit
    ```

**Note on Development Environment:**
During the development of this library, persistent environmental issues were encountered with Composer failing to correctly install dependencies into the `vendor` directory. This prevented the direct execution and verification of PHPUnit tests within that specific development session. The tests are provided with the expectation that they will pass in a standard PHP environment where Composer functions correctly.

## Dependencies

*   **PHP 8.0+** (recommended, though might work with slightly older versions with adjustments)
*   **Composer** (for managing development dependencies like PHPUnit)
*   **PHPUnit** (for running unit tests, installed via Composer)

## How to Install and Use

1.  **Clone the repository:**
    ```bash
    git clone <repository_url>
    cd <repository_directory>
    ```
2.  **Install dependencies (for testing):**
    If you want to run the unit tests, you'll need to install PHPUnit via Composer.
    ```bash
    composer install
    ```
    *(This command relies on a functional Composer and PHP environment. If you encounter issues similar to those mentioned in the "Testing" section, the `vendor` directory might not populate correctly.)*

3.  **Integrate into your project:**
    *   You can copy the `src/` directory into your project and use an autoloader (like one provided by Composer or your own) to load `SmsOtpSenderInterface.php` and `BasicSmsOtpSender.php`.
    *   Alternatively, for more complex projects, consider publishing this as a private package or adapting its structure to fit your project's needs.

4.  **Using the `BasicSmsOtpSender`:**
    ```php
    <?php
    // Assuming you have an autoloader or have required the files
    // require_once 'path/to/src/SmsOtpSenderInterface.php';
    // require_once 'path/to/src/BasicSmsOtpSender.php';

    $otpService = new BasicSmsOtpSender();

    $phoneNumber = 'your_target_phone_number';
    $newOtp = $otpService->generateOtp(); // Generates a 6-digit OTP

    if ($otpService->sendOtp($phoneNumber, $newOtp)) {
        echo "OTP sent (logged) successfully!";
    } else {
        echo "Failed to send OTP.";
    }
    ?>
    ```

This library provides a starting point. For a production environment, you would typically replace `BasicSmsOtpSender` with an implementation that integrates with a real SMS gateway service.
```

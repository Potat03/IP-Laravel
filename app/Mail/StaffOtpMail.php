<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class StaffOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $otpCode;

    public function __construct($email, $otpCode)
    {
        $this->email = $email;
        $this->otpCode = $otpCode;
    }

    public function build()
    {
        $verificationUrl = route('admin.showVerifyOtpForm', ['email' => $this->email]);
    
        Log::info('Generated Verification URL: ' . $verificationUrl);

        return $this->view('emails.staff_verification')
            ->subject('Your Admin OTP Code')
            ->with([
                'otpCode' => $this->otpCode,
                'verificationUrl' => $verificationUrl,
            ]);
    }
}

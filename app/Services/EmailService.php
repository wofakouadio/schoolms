<?php

namespace App\Services;

use App\Mail\GeneralMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class EmailService
{
    /**
     * Send email to a single recipient.
     */
    public function sendMail($recipient, $subject, $message)
    {
        $data = [
            'subject' => $subject,
            'message' => $message,
        ];

        try {
            Mail::to($recipient)->send(new GeneralMail($data));
            return "Email sent successfully to {$recipient}";
        } catch (\Exception $e) {
            Log::error("Email sending failed: " . $e->getMessage());
            return "Failed to send email.";
        }
    }

    /**
     * Send bulk emails.
     */
    public function sendBulkMail($recipients, $subject, $message)
    {
        foreach ($recipients as $recipient) {
            $this->sendMail($recipient, $subject, $message);
        }
        return "Bulk emails sent successfully.";
    }
}

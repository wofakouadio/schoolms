<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use InvalidArgumentException;
use Exception;

class SMSService
{
    private string $baseUrl = 'https://api.wittyflow.com/v1/messages/send';

    public function sendSMS($phone, $message)
    {
        try {
            $response = $this->sendWittyFlowSMS($phone, $message);
            return $response->status == 'success' 
                ? $response 
                : $this->sendFrogSMS($phone, $message);
        } catch (Exception $e) {
            throw new Exception("Failed to send SMS: " . $e->getMessage());
        }
    }

    public function sendWittyFlowSMS($phones, $message)
    {
        try {
            $phones = $this->formatPhoneNumbers($phones);
            $data = $this->prepareRequestData($phones, $message);

            try {
                // First attempt with SSL verification
                $response = Http::withHeaders([
                    'Content-Type' => 'application/json'
                ])->post($this->baseUrl, $data);
            } catch (Exception $e) {
                // Second attempt without SSL verification if first attempt fails
                $response = Http::withoutVerifying()
                    ->withHeaders(['Content-Type' => 'application/json'])
                    ->post($this->baseUrl, $data);
            }

            return json_decode($response->body());
        } catch (Exception $e) {
            throw new Exception("Failed to send WittyFlow SMS: " . $e->getMessage());
        }
    }

    private function prepareRequestData($phones, $message): array
    {
        return [
            'app_id' => config('services.wittyflow.app_id'),
            'app_secret' => config('services.wittyflow.app_secret'),
            'from' => config('services.wittyflow.sms_from'),
            'message' => $message,
            'to' => $phones,
            'type' => '1'
        ];
    }

    private function formatPhoneNumbers($phones)
    {
        return is_array($phones) 
            ? array_map([$this, 'formatPhoneNumber'], $phones)
            : $this->formatPhoneNumber($phones);
    }

    private function formatPhoneNumber($phone)
    {
        // Ensure the phone number is a Ghanaian number
        if (!preg_match('/^0[235][0-9]{8}$/', $phone)) {
            throw new InvalidArgumentException("Invalid Ghanaian phone number: $phone");
        }

        return substr($phone, 0, 1) == '0' 
            ? '233' . substr($phone, 1) 
            : $phone;
    }

    // Placeholder for future implementation
    private function sendFrogSMS($phones, $message)
    {
        // Implementation for Frog SMS service
        return (object) [
            'status' => 'success',
            'message' => 'SMS sent successfully'
        ];
    }
}

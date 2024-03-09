<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Http\Request;

use App\Models\User;

class OtpController extends Controller
{
    public function sendOtp(Request $request, Client $client)
    {
        $otpCode = $request->input('verifyCode');
        $phoneNumber = $request->input('phoneNumber');

        try {
            $response = $client->post('https://rest-ww.telesign.com/v1/verify/sms', [
                'headers' => [
                    'accept' => 'application/json',
                    'content-type' => 'application/x-www-form-urlencoded',
                    'Authorization' => 'Basic ' . base64_encode(env('TELESIGN_CUSTOMER_ID') . ':' . env('TELESIGN_API_KEY')),
                ],
                RequestOptions::FORM_PARAMS => [
                    'phone_number' => $phoneNumber,
                    'verify_code' => $otpCode,
                ],
            ]);

            if ($response->getStatusCode() == 200) {
                return response()->json(['message' => 'OTP code sent successfully', 'status' => 200]);
            } else {
                return response()->json(['message' => 'Failed to send OTP code', 'status' => 500], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while sending OTP code: ' . $e->getMessage()], 500);
        }
    }


    public function verifyPhone(Request $request)
    {

        try {
            $AuthUser = $request->input('userId');
            $user = User::where('id', $AuthUser)->first();
            $user->phone_verified_at = now();
            $user->save();
            return response()->json(['message' => 'Phone verification successful', 'status' => 200], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Phone verification failed: ' . $e->getMessage()], 500);
        }
    }
}

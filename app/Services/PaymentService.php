<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    protected $apiKey;
    protected $baseUrl;
    protected $webhookSecret;

    public function __construct()
    {
        $this->apiKey = config('services.stripe.secret_key');
        $this->baseUrl = config('services.stripe.base_url', 'https://api.stripe.com/v1');
        $this->webhookSecret = config('services.stripe.webhook_secret');
    }

    /**
     * Create payment intent
     */
    public function createPaymentIntent(float $amount, string $currency = 'MXN', array $metadata = []): array
    {
        try {
            $response = Http::withBasicAuth($this->apiKey, '')
                ->post($this->baseUrl . '/payment_intents', [
                    'amount' => $amount * 100, // Convert to cents
                    'currency' => $currency,
                    'metadata' => $metadata,
                    'automatic_payment_methods' => [
                        'enabled' => true
                    ]
                ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'client_secret' => $response->json()['client_secret'],
                    'payment_intent_id' => $response->json()['id']
                ];
            }

            return [
                'success' => false,
                'error' => $response->json()['error']['message'] ?? 'Error al crear el pago'
            ];

        } catch (\Exception $e) {
            Log::error('Payment intent creation failed', [
                'amount' => $amount,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'error' => 'Error al procesar el pago'
            ];
        }
    }

    /**
     * Confirm payment
     */
    public function confirmPayment(string $paymentIntentId): array
    {
        try {
            $response = Http::withBasicAuth($this->apiKey, '')
                ->post($this->baseUrl . '/payment_intents/' . $paymentIntentId . '/confirm');

            if ($response->successful()) {
                $data = $response->json();

                return [
                    'success' => true,
                    'status' => $data['status'],
                    'payment_intent_id' => $data['id']
                ];
            }

            return [
                'success' => false,
                'error' => $response->json()['error']['message'] ?? 'Error al confirmar el pago'
            ];

        } catch (\Exception $e) {
            Log::error('Payment confirmation failed', [
                'payment_intent_id' => $paymentIntentId,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'error' => 'Error al confirmar el pago'
            ];
        }
    }

    /**
     * Verify webhook signature
     */
    public function verifyWebhookSignature(string $payload, string $signature): bool
    {
        $expectedSignature = hash_hmac('sha256', $payload, $this->webhookSecret);

        return hash_equals($expectedSignature, $signature);
    }

    /**
     * Process webhook event
     */
    public function processWebhook(array $event): array
    {
        switch ($event['type']) {
            case 'payment_intent.succeeded':
                return $this->handlePaymentSucceeded($event['data']['object']);
            case 'payment_intent.payment_failed':
                return $this->handlePaymentFailed($event['data']['object']);
            default:
                return [
                    'success' => false,
                    'message' => 'Event type not handled'
                ];
        }
    }

    /**
     * Handle successful payment
     */
    protected function handlePaymentSucceeded(array $paymentIntent): array
    {
        // Update your database with successful payment
        Log::info('Payment succeeded', [
            'payment_intent_id' => $paymentIntent['id'],
            'amount' => $paymentIntent['amount']
        ]);

        return [
            'success' => true,
            'message' => 'Payment processed successfully'
        ];
    }

    /**
     * Handle failed payment
     */
    protected function handlePaymentFailed(array $paymentIntent): array
    {
        // Handle failed payment
        Log::warning('Payment failed', [
            'payment_intent_id' => $paymentIntent['id'],
            'amount' => $paymentIntent['amount']
        ]);

        return [
            'success' => true,
            'message' => 'Payment failure handled'
        ];
    }
}

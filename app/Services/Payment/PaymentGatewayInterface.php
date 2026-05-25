<?php

namespace App\Services\Payment;

interface PaymentGatewayInterface
{
    /**
     * Initiate a payment for an order. Returns gateway-specific response data.
     *
     * @param mixed $order  The order model or array with order data
     * @param array $options Optional gateway-specific options
     * @return array
     */
    public function initiatePayment($order, array $options = []): array;

    /**
     * Handle an incoming callback/webhook payload from the gateway.
     *
     * @param array $payload
     * @param string|null $signatureHeader
     * @param string|null $rawBody
     * @return array (normalized status data)
     */
    public function handleCallback(array $payload, ?string $signatureHeader = null, ?string $rawBody = null): array;

    /**
     * Get payment status by gateway reference id
     *
     * @param string $externalId
     * @return array
     */
    public function getStatus(string $externalId): array;

    /**
     * Optional: refund a transaction
     */
    public function refund(string $externalId, array $options = []): array;
}

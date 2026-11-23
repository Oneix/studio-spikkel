<?php
declare(strict_types=1);

namespace App\Store;

final class CheckoutQuote
{
    public const SESSION_KEY = 'Checkout.review';

    /**
     * Validate delivery and gift options, then price the review using the current catalog and shipping rules.
     */
    public static function build(array $posted, array $cart, array $rates): array
    {
        $addressFields = ['shipping_country', 'address_name', 'street', 'postal_code', 'city'];
        $fields = ['delivery_method', ...$addressFields, 'gift_message'];
        $input = [];
        foreach ($fields as $field) {
            $value = $posted[$field] ?? null;
            $input[$field] = is_string($value) ? trim($value) : '';
        }
        $input['gift_wrap'] = $cart['hasPhysical'] && in_array($posted['gift_wrap'] ?? null, [true, 1, '1'], true);
        if (!$input['gift_wrap']) {
            $input['gift_message'] = '';
        }

        $errors = [];
        $method = $cart['hasPhysical'] ? $input['delivery_method'] : 'digital';
        if ($cart['hasPhysical'] && !in_array($method, ['shipping', 'pickup'], true)) {
            $errors['delivery_method'] = ['Kies verzenden of afhalen.'];
        }
        $input['delivery_method'] = $method;
        $fee = 0;
        $label = $method === 'digital' ? 'Digitaal' : $rates['pickup']['label'];
        if ($method === 'shipping') {
            $country = $input['shipping_country'];
            $rate = $country !== 'pickup' ? ($rates[$country] ?? null) : null;
            if ($rate === null) {
                $errors['shipping_country'] = ['Kies een land waar we bezorgen.'];
            } else {
                $fee = $cart['physicalSubtotal'] >= $rate['free_from_cents'] ? 0 : $rate['fee_cents'];
                $label = 'Verzenden naar ' . $rate['label'];
            }
            foreach (['address_name' => 120, 'street' => 160, 'postal_code' => 12, 'city' => 100] as $field => $max) {
                if ($input[$field] === '' || mb_strlen($input[$field]) > $max) {
                    $errors[$field] = [sprintf('Vul dit adresveld in (maximaal %d tekens).', $max)];
                }
            }
        } else {
            foreach ($addressFields as $field) {
                $input[$field] = '';
            }
        }
        if (mb_strlen($input['gift_message']) > 240) {
            $errors['gift_message'] = ['Gebruik maximaal 240 tekens voor je cadeaukaartje.'];
        }

        $items = [];
        foreach ($cart['items'] as $item) {
            $product = $item['product'];
            $items[] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'unit_price_cents' => $product->price_cents,
                'quantity' => $item['quantity'],
                'total_cents' => $item['total'],
                'is_digital' => (bool)$product->is_digital,
            ];
        }

        $order = [
            'delivery_method' => $method,
            'delivery_label' => $label,
            'shipping_country' => $input['shipping_country'] !== '' ? $input['shipping_country'] : null,
            'address_name' => $input['address_name'] !== '' ? $input['address_name'] : null,
            'street' => $input['street'] !== '' ? $input['street'] : null,
            'postal_code' => $input['postal_code'] !== '' ? $input['postal_code'] : null,
            'city' => $input['city'] !== '' ? $input['city'] : null,
            'gift_wrap' => $input['gift_wrap'],
            'gift_message' => $input['gift_message'] !== '' ? $input['gift_message'] : null,
            'subtotal_cents' => $cart['subtotal'],
            'shipping_cents' => $fee,
            'total_cents' => $cart['subtotal'] + $fee,
        ];

        return compact('input', 'errors', 'items', 'order');
    }
}

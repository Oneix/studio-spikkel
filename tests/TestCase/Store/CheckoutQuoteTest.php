<?php
declare(strict_types=1);

namespace App\Test\TestCase\Store;

use App\Store\CheckoutQuote;
use PHPUnit\Framework\TestCase;

class CheckoutQuoteTest extends TestCase
{
    /**
     * A digital amount never counts toward the physical products' free shipping threshold.
     */
    public function testFreeShippingThresholds(): void
    {
        $store = require CONFIG . 'store.php';
        $rates = $store['Store']['shipping'];
        $address = ['delivery_method' => 'shipping', 'address_name' => 'Test', 'street' => 'Straat 1'];
        $address += ['postal_code' => '1234 AB', 'city' => 'Teststad'];
        foreach (['NL' => [4000, 395], 'BE' => [6000, 695], 'DE' => [7000, 795]] as $country => [$limit, $cost]) {
            $cart = ['items' => [], 'hasPhysical' => true, 'physicalSubtotal' => $limit - 1, 'subtotal' => $limit + 2499];
            $quote = CheckoutQuote::build($address + ['shipping_country' => $country], $cart, $rates);
            $this->assertSame([], $quote['errors']);
            $this->assertSame($cost, $quote['order']['shipping_cents']);
            $this->assertSame($cart['subtotal'] + $cost, $quote['order']['total_cents']);
            $cart['physicalSubtotal']++;
            $quote = CheckoutQuote::build($address + ['shipping_country' => $country], $cart, $rates);
            $this->assertSame(0, $quote['order']['shipping_cents']);
        }
    }

    /**
     * Pickup and digital delivery cannot keep an unnecessary address or attachment options.
     */
    public function testPickupAndDigitalDelivery(): void
    {
        $store = require CONFIG . 'store.php';
        $rates = $store['Store']['shipping'];
        $cart = ['items' => [], 'hasPhysical' => true, 'physicalSubtotal' => 1295, 'subtotal' => 1295];
        $data = ['delivery_method' => 'pickup', 'gift_wrap' => '1', 'gift_message' => 'Voor jou', 'street' => 'Straat 1'];
        $pickup = CheckoutQuote::build($data, $cart, $rates);
        $this->assertSame([], $pickup['errors']);
        $this->assertSame(0, $pickup['order']['shipping_cents']);
        $this->assertNull($pickup['order']['street']);
        $this->assertSame('Voor jou', $pickup['order']['gift_message']);
        $cart['hasPhysical'] = false;
        $cart['physicalSubtotal'] = 0;
        $digital = CheckoutQuote::build($data, $cart, $rates);
        $this->assertSame('digital', $digital['order']['delivery_method']);
        $this->assertSame(0, $digital['order']['shipping_cents']);
        $this->assertFalse($digital['order']['gift_wrap']);
        $this->assertNull($digital['order']['gift_message']);
    }
}

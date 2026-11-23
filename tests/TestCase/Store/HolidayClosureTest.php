<?php
declare(strict_types=1);

namespace App\Test\TestCase\Store;

use App\Store\HolidayClosure;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class HolidayClosureTest extends TestCase
{
    /**
     * Both boundary days are closed in the Amsterdam timezone.
     */
    public function testClosureIncludesBothBoundaryDays(): void
    {
        $settings = ['start' => '08-03', 'end' => '08-18', 'preview' => false];
        $this->assertFalse(HolidayClosure::describe($settings, new DateTimeImmutable('2026-08-02T21:59:00Z'))['active']);
        $this->assertTrue(HolidayClosure::describe($settings, new DateTimeImmutable('2026-08-02T22:00:00Z'))['active']);
        $this->assertTrue(HolidayClosure::describe($settings, new DateTimeImmutable('2026-08-18T21:59:00Z'))['active']);
        $this->assertFalse(HolidayClosure::describe($settings, new DateTimeImmutable('2026-08-18T22:00:00Z'))['active']);
        $settings['preview'] = true;
        $preview = HolidayClosure::describe($settings, new DateTimeImmutable('2026-11-01T09:00:00Z'));
        $this->assertTrue($preview['active']);
        $this->assertSame('3 t/m 18 augustus', $preview['label']);
    }
}

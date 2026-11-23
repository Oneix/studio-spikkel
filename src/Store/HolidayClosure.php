<?php
declare(strict_types=1);

namespace App\Store;

use DateTimeImmutable;
use DateTimeZone;
use IntlDateFormatter;

final class HolidayClosure
{
    /**
     * Describe the configured yearly holiday in the shop's timezone.
     *
     * @param array{start: string, end: string, preview: bool} $holiday Start and end in month-day form.
     * @param \DateTimeImmutable|null $now Optional clock value for previewing a specific day.
     * @return array{active: bool, label: string, key: string}
     */
    public static function describe(array $holiday, ?DateTimeImmutable $now = null): array
    {
        $timezone = new DateTimeZone('Europe/Amsterdam');
        $local = $now?->setTimezone($timezone) ?? new DateTimeImmutable('now', $timezone);
        $start = $holiday['start'];
        $end = $holiday['end'];
        $today = $local->format('m-d');
        $inRange = $start <= $end ? $today >= $start && $today <= $end : $today >= $start || $today <= $end;
        $startDate = DateTimeImmutable::createFromFormat('!m-d', $start, $timezone);
        $endDate = DateTimeImmutable::createFromFormat('!m-d', $end, $timezone);
        $formatter = new IntlDateFormatter('nl_NL', IntlDateFormatter::NONE, IntlDateFormatter::NONE, $timezone);
        $formatter->setPattern('d MMMM');
        $firstDay = $startDate->format('m') === $endDate->format('m')
            ? $startDate->format('j')
            : $formatter->format($startDate);

        return [
            'active' => $inRange || $holiday['preview'],
            'label' => $firstDay . ' t/m ' . $formatter->format($endDate),
            'key' => $local->format('Y') . '-' . $start . '-' . $end,
        ];
    }
}

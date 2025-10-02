<?php

namespace App\Services;

use Carbon\Carbon;
use DateTimeImmutable;
use DateTimeInterface;
use IntlDateFormatter;

class JalaliDateService
{
    /**
     * Convert a Gregorian date/time to Jalali (Persian) calendar string.
     *
     * $date can be: Carbon, DateTimeInterface, UNIX timestamp (int), or string parseable by Carbon.
     * $pattern uses ICU patterns (IntlDateFormatter), e.g. 'yyyy/MM/dd', 'yyyy/MM/dd HH:mm'.
     */
    public function toJalali($date, string $pattern = 'yyyy/MM/dd'): string
    {
        $dt = $this->normalizeToImmutable($date);

        if (class_exists(IntlDateFormatter::class)) {
            $formatter = new IntlDateFormatter(
                'fa_IR@calendar=persian',
                IntlDateFormatter::FULL,
                IntlDateFormatter::NONE,
                $dt->getTimezone()->getName(),
                IntlDateFormatter::TRADITIONAL,
                $pattern
            );
            $result = $formatter->format($dt);
            if ($result !== false) {
                return $result;
            }
        }

        // Fallback without intl: use algorithmic conversion
        [$jy, $jm, $jd] = $this->gregorianToJalali((int)$dt->format('Y'), (int)$dt->format('m'), (int)$dt->format('d'));
        $H = $dt->format('H');
        $i = $dt->format('i');
        $s = $dt->format('s');

        // Basic pattern support for common tokens
        $out = $pattern;
        $repls = [
            'yyyy' => sprintf('%04d', $jy),
            'MM'   => sprintf('%02d', $jm),
            'dd'   => sprintf('%02d', $jd),
            'HH'   => $H,
            'mm'   => $i,
            'ss'   => $s,
        ];
        foreach ($repls as $k => $v) {
            $out = str_replace($k, $v, $out);
        }
        return $out;
    }

    /** Shortcut for now() in Jalali */
    public function now(string $pattern = 'yyyy/MM/dd HH:mm'): string
    {
        return $this->toJalali(Carbon::now(), $pattern);
    }

    private function normalizeToImmutable($date): DateTimeImmutable
    {
        if ($date instanceof DateTimeImmutable) {
            return $date;
        }
        if ($date instanceof DateTimeInterface) {
            return DateTimeImmutable::createFromInterface($date);
        }
        if (is_int($date)) {
            return Carbon::createFromTimestamp($date)->toDateTimeImmutable();
        }
        return Carbon::parse((string) $date)->toDateTimeImmutable();
    }

    /**
     * Convert Gregorian (gy,gm,gd) to Jalali (jy,jm,jd)
     * Based on the algorithm used in jdf (Public Domain)
     */
    private function gregorianToJalali(int $gy, int $gm, int $gd): array
    {
        $g_d_m = [0,31,59,90,120,151,181,212,243,273,304,334];
        $gy2 = ($gm > 2) ? ($gy + 1) : $gy;
        $days = 355666 + (365 * $gy) + (int)(($gy2 + 3) / 4) - (int)(($gy2 + 99) / 100) + (int)(($gy2 + 399) / 400) + $gd + $g_d_m[$gm - 1];
        $jy = -1595 + (33 * (int)($days / 12053));
        $days %= 12053;
        $jy += 4 * (int)($days / 1461);
        $days %= 1461;
        if ($days > 365) {
            $jy += (int)(($days - 1) / 365);
            $days = ($days - 1) % 365;
        }
        if ($days < 186) {
            $jm = 1 + (int)($days / 31);
            $jd = 1 + ($days % 31);
        } else {
            $jm = 7 + (int)(($days - 186) / 30);
            $jd = 1 + (($days - 186) % 30);
        }
        return [$jy, $jm, $jd];
    }
}

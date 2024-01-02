<?php

namespace RiftLab\Radiance\Concerns;

trait Formatted
{
    protected static int $precision = 8;

    public static function setPrecision(int $precision)
    {
        static::$precision = $precision;
    }

    abstract public function getDefaultFormat(): string;

    abstract public function getFormatPlaceholders(): array;

    public function toString(string $format = null): string
    {
        $format = $format ?? $this->getDefaultFormat();

        return preg_replace_callback_array($this->getMergedFormatPlaceholders(), $format);
    }

    protected function getMergedFormatPlaceholders(): array
    {
        return [
            '/\{S\}/' => fn () => $this->isNegative() ? '-' : '',
            '/\{SS\}/' => fn () => $this->isNegative() ? '-' : '+',
            '/\{([dms]{1,2})(\.(-?\d+)(f?))?\}/' => fn ($matches) => $this->formatValue($matches),
            ...$this->getFormatPlaceholders(),
        ];
    }

    protected function formatValue(array $matches): string
    {
        $decimalPlaces = isset($matches[3]) ? intval($matches[3]) : null;

        $value = match($matches[1]) {
            'd', 'dd' => $this->getDegrees($decimalPlaces),
            'm', 'mm' => $this->getMinutes($decimalPlaces),
            's', 'ss' => $this->getSeconds($decimalPlaces),
            default => 0.0,
        };

        $leadingZero = strlen($matches[1]) === 2;

        if (! is_null($decimalPlaces) && $decimalPlaces <= 0) {
            // No decimal places
            $output = sprintf('%0*d', $leadingZero ? 2 : 1, $value);
        } else {
            if ($decimalPlaces > 0) {
                // Specified number of decimal places
                $forceDecimalPlaces = ! empty($matches[4]);
            } else {
                // Arbitrary number of decimal places
                $decimalPlaces = static::$precision;
                $forceDecimalPlaces = false;
            }

            $minDigits = $decimalPlaces + ($leadingZero ? 3 : 2);
            $output = sprintf('%0*.*f', $minDigits, $decimalPlaces, $value);

            if (! $forceDecimalPlaces) {
                $output = preg_replace('/\.?0+$/', '', $output);
            }
        }

        return $output;
    }
}

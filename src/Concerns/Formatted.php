<?php

namespace RiftLab\Radiance\Concerns;

trait Formatted
{
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

            '/\{d(\.(-?\d+))?\}/' => fn ($match) => static::formatValue($this->getDegrees($dp = $match[2] ?? null), $dp, false),
            '/\{m(\.(-?\d+))?\}/' => fn ($match) => static::formatValue($this->getMinutes($dp = $match[2] ?? null), $dp, false),
            '/\{s(\.(-?\d+))?\}/' => fn ($match) => static::formatValue($this->getSeconds($dp = $match[2] ?? null), $dp, false),

            '/\{dd(\.(-?\d+))?\}/' => fn ($match) => static::formatValue($this->getDegrees($dp = $match[2] ?? null), $dp, true),
            '/\{mm(\.(-?\d+))?\}/' => fn ($match) => static::formatValue($this->getMinutes($dp = $match[2] ?? null), $dp, true),
            '/\{ss(\.(-?\d+))?\}/' => fn ($match) => static::formatValue($this->getSeconds($dp = $match[2] ?? null), $dp, true),

            ...$this->getFormatPlaceholders(),
        ];
    }

    protected static function formatValue(float $value, ?int $decimalPoints, bool $leadingZero): string
    {
        $value = is_null($decimalPoints) ? (string)$value : number_format($value, $decimalPoints);

        return $leadingZero && $value < 10 ? "0$value" : $value;
    }
}

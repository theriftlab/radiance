<?php

namespace RiftLab\Radiance\Concerns;

trait AngleFormat
{
    protected static function getStringFormat(): string
    {
        return '{D}{dd.-1}°{mm.-1}\'{ss.0}"';
    }

    protected static function getDirections(): array
    {
        return [
            'negative' => '-',
            'positive' => '+',
        ];
    }

    protected function getStringFormatPlaceholders(): array
    {
        return [
            '/\{D\}/' => fn () => $this->isNegative() ? $this->getDirection() : '',
            '/\{DD\}/' => fn () => $this->getDirection(),
        ];
    }
}

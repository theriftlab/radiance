<?php

namespace RiftLab\Radiance\Concerns;

use RiftLab\Radiance\Enum\Limit;

trait IsAngle
{
    protected static function getLimit(): Limit
    {
        return Limit::CIRCLE;
    }

    protected static function getNormalize(): bool
    {
        return true;
    }

    protected static function getStringFormat(): string
    {
        return '{D}{dd.-1}°{mm.-1}\'{ss.0}"';
    }

    protected static function getNegativeDirection(): string
    {
        return '-';
    }

    protected static function getPositiveDirection(): string
    {
        return '+';
    }

    protected function stringFormatPlaceholders(): array
    {
        return [
            '/\{D\}/' => fn () => $this->isNegative() ? $this->getDirection() : '',
            '/\{DD\}/' => fn () => $this->getDirection(),
        ];
    }
}

<?php

namespace RiftLab\Radiance\Concerns;

trait IsCoordinate
{
    protected static function getNormalize(): bool
    {
        return false;
    }

    protected static function getStringFormat(): string
    {
        return '{d.-1}{D}{m.2}';
    }

    protected function stringFormatPlaceholders(): array
    {
        return [
            '/\{D\}/' => fn () => $this->getDirection(),
            '/\{DD\}/' => fn () => strtoupper($this->getDirection()),
        ];
    }
}

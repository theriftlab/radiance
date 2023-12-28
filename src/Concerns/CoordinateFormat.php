<?php

namespace RiftLab\Radiance\Concerns;

trait CoordinateFormat
{
    protected static function getStringFormat(): string
    {
        return '{d.-1}{D}{m.2}';
    }

    protected function getStringFormatPlaceholders(): array
    {
        return [
            '/\{D\}/' => fn () => $this->getDirection(),
            '/\{DD\}/' => fn () => strtoupper($this->getDirection()),
        ];
    }
}

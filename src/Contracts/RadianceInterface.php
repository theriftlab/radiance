<?php

namespace RiftLab\Radiance\Contracts;

interface RadianceInterface
{
    public function isNegative(): bool;

    public function getDegrees(?int $decimalPlaces = null): float;

    public function getMinutes(?int $decimalPlaces = null): float;

    public function getSeconds(?int $decimalPlaces = null): float;

    public function toDecimal(?int $decimalPlaces = null): float;

    public function toRawDecimal(): string;

    public function toArray(): array;

    public function toString(): string;
}

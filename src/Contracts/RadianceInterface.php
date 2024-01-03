<?php

namespace RiftLab\Radiance\Contracts;

interface RadianceInterface
{
    public function isNegative(): bool;

    public function getDegrees(): float;

    public function getMinutes(): float;

    public function getSeconds(): float;

    public function toDecimal(): float;

    public function toBCDecimal(): string;

    public function toArray(): array;

    public function toString(): string;
}

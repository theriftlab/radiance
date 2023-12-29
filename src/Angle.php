<?php

namespace RiftLab\Radiance;

use RiftLab\Radiance\Classes\Abstract\BaseAngle;
use RiftLab\Radiance\Concerns\Formatted;
use RiftLab\Radiance\Contracts\AngleInterface;
use RiftLab\Radiance\Enum\Limit;
use RiftLab\Radiance\Services\Calculate;

class Angle extends BaseAngle implements AngleInterface
{
    use Formatted;

    protected static Limit $limit = Limit::CIRCLE;

    protected static bool $normalize = true;

    protected static string $defaultFormat = '{D}{dd.-1}°{mm.-1}\'{ss.0}"';

    public function getFormatPlaceholders(): array
    {
        return [
            '/\{D\}/' => fn () => $this->isNegative() ? '-' : '',
            '/\{DD\}/' => fn () => $this->isNegative() ? '-' : '+',
        ];
    }

    public function normalizeTo(int $size): Angle
    {
        return new static(Calculate::normalize($this->toDecimal(), $size));
    }
}

<?php

namespace RiftLab\Radiance\Classes\Exceptions;

use RiftLab\Radiance\Enum\Limit;

abstract class RadianceBoundaryException extends \Exception
{
    protected static string $type;

    public function __construct(float $angle, Limit $limit) {
        parent::__construct($angle.' exceeds '.static::$type.' boundary and must be between -'.$limit->value.' and '.$limit->value);
    }
}

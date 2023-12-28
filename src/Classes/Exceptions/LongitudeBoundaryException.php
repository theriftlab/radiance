<?php

namespace RiftLab\Radiance\Classes\Exceptions;

class LongitudeBoundaryException extends BoundaryException
{
    protected ?string $customMessage = 'Longitude value must be between -180° and 180°.';
}

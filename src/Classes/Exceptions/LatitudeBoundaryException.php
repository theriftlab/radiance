<?php

namespace RiftLab\Radiance\Classes\Exceptions;

class LatitudeBoundaryException extends BoundaryException
{
    protected ?string $customMessage = 'Latitude value must be between -90° and 90°.';
}

<?php

namespace RiftLab\Radiance\Classes\Exceptions;

final class LongitudeBoundaryError extends BoundaryError
{
    protected ?string $customMessage = 'Longitude value must be between -180° and 180°.';
}

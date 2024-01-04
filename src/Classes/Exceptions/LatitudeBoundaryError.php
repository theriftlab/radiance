<?php

namespace RiftLab\Radiance\Classes\Exceptions;

final class LatitudeBoundaryError extends BoundaryError
{
    protected ?string $customMessage = 'Latitude value must be between -90° and 90°.';
}

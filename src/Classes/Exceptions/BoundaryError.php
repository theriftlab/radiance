<?php

namespace RiftLab\Radiance\Classes\Exceptions;

class BoundaryError extends \ValueError
{
    protected ?string $customMessage = null;

    public function __construct(float $angle) {
        $this->message = 'Invalid angle given: '.$angle;

        if ($this->customMessage) {
            $this->message .= '. '.$this->customMessage;
        }

        parent::__construct();
    }
}

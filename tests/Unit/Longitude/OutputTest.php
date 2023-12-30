<?php

use RiftLab\Radiance\Longitude;

test('toString basic placeholders', function () {
    expect($this->longitude->toString())->toBe('51e28.68');
    expect($this->negativeLongitude->toString())->toBe('51w28.68');

    expect($this->longitude->toString('{D}{d.-1}{m.-1}{s.0}'))->toBe('e512841');
    expect($this->negativeLongitude->toString('{D}{d.-1}{m.-1}{s.0}'))->toBe('w512841');

    expect($this->longitude->toString('{DD}'))->toBe('E');
    expect($this->negativeLongitude->toString('{DD}'))->toBe('W');
});

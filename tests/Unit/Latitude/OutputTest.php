<?php

use RiftLab\Radiance\Latitude;

test('toString basic placeholders', function () {
    expect($this->latitude->toString())->toBe('51n28.68');
    expect($this->negativeLatitude->toString())->toBe('51s28.68');

    expect($this->latitude->toString('{D}{d.-1}{m.-1}{s.0}'))->toBe('n512841');
    expect($this->negativeLatitude->toString('{D}{d.-1}{m.-1}{s.0}'))->toBe('s512841');

    expect($this->latitude->toString('{DD}'))->toBe('N');
    expect($this->negativeLatitude->toString('{DD}'))->toBe('S');
});

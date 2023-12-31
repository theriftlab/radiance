<?php

use RiftLab\Radiance\Classes\Exceptions\LongitudeBoundaryError;
use RiftLab\Radiance\Longitude;

test('format conversion', function () {
    expect($this->longitude->toDecimal())->toBe($this->decimalAngle);
    expect(Longitude::make((string)$this->decimalAngle)->toDecimal())->toBe($this->decimalAngle);

    foreach ($this->stringFormats as $stringFormat) {
        expect(Longitude::make($stringFormat)->toDecimal())->toBe($this->decimalAngle);
    }

    expect($this->negativeLongitude->toDecimal())->toBe(-$this->decimalAngle);
    expect(Longitude::make((string)-$this->decimalAngle)->toDecimal())->toBe(-$this->decimalAngle);

    foreach ($this->stringFormats as $stringFormat) {
        expect(Longitude::make('-'.$stringFormat)->toDecimal())->toBe(-$this->decimalAngle);
    }
});

test('initial longitude out of bounds exception', function () {
    expect(fn () => Longitude::make(-181))->toThrow(LongitudeBoundaryError::class);
    expect(fn () => Longitude::make(181))->toThrow(LongitudeBoundaryError::class);
});

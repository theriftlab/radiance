<?php

use RiftLab\Radiance\Classes\Exceptions\LatitudeBoundaryError;
use RiftLab\Radiance\Latitude;

test('format conversion', function () {
    expect($this->latitude->toDecimal())->toBe($this->decimalAngle);
    expect(Latitude::make((string)$this->decimalAngle)->toDecimal())->toBe($this->decimalAngle);

    foreach ($this->stringFormats as $stringFormat) {
        expect(Latitude::make($stringFormat)->toDecimal())->toBe($this->decimalAngle);
    }

    expect($this->negativeLatitude->toDecimal())->toBe(-$this->decimalAngle);
    expect(Latitude::make((string)-$this->decimalAngle)->toDecimal())->toBe(-$this->decimalAngle);

    foreach ($this->stringFormats as $stringFormat) {
        expect(Latitude::make('-'.$stringFormat)->toDecimal())->toBe(-$this->decimalAngle);
    }
});

test('initial latitude out of bounds exception', function () {
    expect(fn () => Latitude::make(-91))->toThrow(LatitudeBoundaryError::class);
    expect(fn () => Latitude::make(91))->toThrow(LatitudeBoundaryError::class);
});

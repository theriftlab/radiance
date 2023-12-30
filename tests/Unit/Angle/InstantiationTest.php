<?php

use RiftLab\Radiance\Angle;

test('format conversion', function () {
    expect($this->angle->toDecimal())->toBe($this->decimalAngle);
    expect(Angle::make((string)$this->decimalAngle)->toDecimal())->toBe($this->decimalAngle);

    foreach ($this->stringFormats as $stringFormat) {
        expect(Angle::make($stringFormat)->toDecimal())->toBe($this->decimalAngle);
    }

    expect($this->negativeAngle->toDecimal())->toBe(-$this->decimalAngle);
    expect(Angle::make((string)-$this->decimalAngle)->toDecimal())->toBe(-$this->decimalAngle);

    foreach ($this->stringFormats as $stringFormat) {
        expect(Angle::make('-'.$stringFormat)->toDecimal())->toBe(-$this->decimalAngle);
    }
});

test('angle normalization', function () {
    expect(Angle::make($this->decimalAngle + 360)->toDecimal())->toBeLessThan(360);
});

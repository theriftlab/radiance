<?php

use RiftLab\Radiance\Classes\Exceptions\LatitudeBoundaryException;
use RiftLab\Radiance\Latitude;

test('add', function () {
    expect($this->latitude->add($this->smallDecimalAngle))->toBeInstanceOf(Latitude::class);
    expect($this->latitude->add($this->smallDecimalAngle)->toString())->toBe('52n30.78');
    expect(fn () => $this->latitude->add($this->decimalAngle))->toThrow(LatitudeBoundaryException::class);
});

test('sub', function () {
    expect($this->latitude->sub($this->smallDecimalAngle))->toBeInstanceOf(Latitude::class);
    expect($this->latitude->sub($this->smallDecimalAngle)->toString())->toBe('50n26.58');
    expect(fn () => $this->negativeLatitude->sub($this->decimalAngle))->toThrow(LatitudeBoundaryException::class);
});

test('distanceTo', function () {
    expect($this->latitude->distanceTo($this->smallDecimalAngle)->toString())->toBe('50s26.58');
    expect($this->smallLatitude->distanceTo($this->decimalAngle)->toString())->toBe('50n26.58');
    expect(fn () => $this->latitude->distanceTo(91))->toThrow(LatitudeBoundaryException::class);
});

test('distanceFrom', function () {
    expect($this->latitude->distanceFrom($this->smallDecimalAngle)->toString())->toBe('50n26.58');
    expect($this->smallLatitude->distanceFrom($this->decimalAngle)->toString())->toBe('50s26.58');
    expect(fn () => $this->latitude->distanceFrom(-91))->toThrow(LatitudeBoundaryException::class);
});

test('midpointWith', function () {
    expect(Latitude::make(-10)->midpointWith(20)->toString())->toBe('5n0.00');
    expect(Latitude::make(20)->midpointWith(-10)->toString())->toBe('5n0.00');
    expect(fn () => Latitude::make(20)->midpointWith(91))->toThrow(LatitudeBoundaryException::class);
});

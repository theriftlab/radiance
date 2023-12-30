<?php

use RiftLab\Radiance\Classes\Exceptions\LongitudeBoundaryException;
use RiftLab\Radiance\Longitude;

test('add', function () {
    expect($this->longitude->add($this->smallDecimalAngle))->toBeInstanceOf(Longitude::class);
    expect($this->longitude->add($this->smallDecimalAngle)->toString())->toBe('52e30.78');
    expect(fn () => $this->longitude->add(150))->toThrow(LongitudeBoundaryException::class);
});

test('sub', function () {
    expect($this->longitude->sub($this->smallDecimalAngle))->toBeInstanceOf(Longitude::class);
    expect($this->longitude->sub($this->smallDecimalAngle)->toString())->toBe('50e26.58');
    expect(fn () => $this->negativeLongitude->sub(150))->toThrow(LongitudeBoundaryException::class);
});

test('distanceTo', function () {
    expect($this->longitude->distanceTo($this->smallDecimalAngle)->toString())->toBe('50w26.58');
    expect($this->smallLongitude->distanceTo($this->decimalAngle)->toString())->toBe('50e26.58');
    expect(fn () => $this->longitude->distanceTo(181))->toThrow(LongitudeBoundaryException::class);
});

test('distanceFrom', function () {
    expect($this->longitude->distanceFrom($this->smallDecimalAngle)->toString())->toBe('50e26.58');
    expect($this->smallLongitude->distanceFrom($this->decimalAngle)->toString())->toBe('50w26.58');
    expect(fn () => $this->longitude->distanceFrom(-181))->toThrow(LongitudeBoundaryException::class);
});

test('midpointWith', function () {
    expect(Longitude::make(-10)->midpointWith(20)->toString())->toBe('5e0.00');
    expect(Longitude::make(20)->midpointWith(-10)->toString())->toBe('5e0.00');
    expect(fn () => Longitude::make(20)->midpointWith(181))->toThrow(LongitudeBoundaryException::class);
});

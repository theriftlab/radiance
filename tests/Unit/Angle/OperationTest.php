<?php

use RiftLab\Radiance\Angle;
use RiftLab\Radiance\Classes\Internal\Diff;

test('add', function () {
    $sum = floatval(bcadd($this->decimalAngle, $this->smallDecimalAngle, 6));

    expect($this->angle->add($this->smallAngle)->toDecimal())->toBe($sum);
    expect($this->angle->add($this->smallDecimalAngle)->toDecimal())->toBe($sum);
});

test('sub', function () {
    $difference = floatval(bcsub($this->decimalAngle, $this->smallDecimalAngle, 6));

    expect($this->angle->sub($this->smallAngle)->toDecimal())->toBe($difference);
    expect($this->angle->sub($this->smallDecimalAngle)->toDecimal())->toBe($difference);
});

test('distanceTo', function () {
    $distance = floatval(bcsub($this->smallDecimalAngle, $this->decimalAngle, 6));

    expect($this->angle->distanceTo($this->angle))->toBeInstanceOf(Diff::class);
    expect($this->angle->distanceTo($this->angle)->toDecimal())->toBe(0.0);

    expect($this->angle->distanceTo($this->smallAngle)->toDecimal())->toBe($distance);
    expect($this->angle->distanceTo($this->smallDecimalAngle)->toDecimal())->toBe($distance);

    expect($this->smallAngle->distanceTo($this->angle)->toDecimal())->toBe(-$distance);
    expect($this->smallAngle->distanceTo($this->decimalAngle)->toDecimal())->toBe(-$distance);

    expect(Angle::make(-200)->distanceTo(140)->toDecimal())->toBe(-20.0);
    expect(Angle::make(-200)->distanceTo(180)->toDecimal())->toBe(20.0);

    expect(Angle::make(-560)->distanceTo(-190)->toDecimal())->toBe(10.0);
    expect(Angle::make(-560)->distanceTo(-210)->toDecimal())->toBe(-10.0);

    expect($this->angle->distanceTo($this->smallAngle)->toString())->toBe('-50°26\'35"');
});

test('distanceFrom', function () {
    $distance = floatval(bcsub($this->smallDecimalAngle, $this->decimalAngle, 6));

    expect($this->angle->distanceFrom($this->angle))->toBeInstanceOf(Diff::class);
    expect($this->angle->distanceFrom($this->angle)->toDecimal())->toBe(0.0);

    expect($this->angle->distanceFrom($this->smallAngle)->toDecimal())->toBe(-$distance);
    expect($this->angle->distanceFrom($this->smallDecimalAngle)->toDecimal())->toBe(-$distance);

    expect($this->smallAngle->distanceFrom($this->angle)->toDecimal())->toBe($distance);
    expect($this->smallAngle->distanceFrom($this->decimalAngle)->toDecimal())->toBe($distance);

    $distanceTo = Angle::make(-200)->distanceTo(140)->toDecimal();
    expect(Angle::make(-200)->distanceFrom(140)->toDecimal())->toBe(-$distanceTo);
    $distanceTo = Angle::make(-560)->distanceTo(-190)->toDecimal();
    expect(Angle::make(-560)->distanceFrom(-190)->toDecimal())->toBe(-$distanceTo);
});

test('midpointWith', function () {
    expect($this->angle->midpointWith($this->angle)->toDecimal())->toBe($this->angle->toDecimal());

    expect(Angle::make(350)->midpointWith(20)->toDecimal())->toBe(5.0);
    expect(Angle::make(20)->midpointWith(350)->toDecimal())->toBe(5.0);

    expect(Angle::make(90)->midpointWith(270)->toDecimal())->toBe(180.0);
    expect(Angle::make(270)->midpointWith(90)->toDecimal())->toBe(0.0);

    expect(Angle::make(100)->midpointWith(280)->toDecimal())->toBe(190.0);
    expect(Angle::make(280)->midpointWith(100)->toDecimal())->toBe(10.0);
});

test('normalizeTo', function () {
    expect($this->angle->normalizeTo(60)->toDecimal())->toBe($this->decimalAngle);
    expect($this->angle->normalizeTo(30)->toDecimal())->toBe(21.477928);
    expect($this->angle->normalizeTo(10)->toDecimal())->toBe(1.477928);
});

<?php

use RiftLab\Radiance\Angle;

test('isNegative', function () {
    expect($this->angle->isNegative())->toBeFalse();
    expect($this->negativeAngle->isNegative())->toBeTrue();
});

test('getDegrees', function () {
    expect($this->angle->getDegrees())->toBe(51.477928);
    expect($this->angle->getDegrees(-1))->toBe(51.0);
    expect($this->angle->getDegrees(0))->toBe(51.0);
    expect($this->angle->getDegrees(1))->toBe(51.5);
    expect($this->angle->getDegrees(2))->toBe(51.48);
    expect($this->angle->getDegrees(3))->toBe(51.478);
    expect($this->angle->getDegrees(4))->toBe(51.4779);
    expect($this->angle->getDegrees(5))->toBe(51.47793);
    expect($this->angle->getDegrees(6))->toBe(51.477928);
});

test('getMinutes', function () {
    expect($this->angle->getMinutes())->toBe(28.67568);
    expect($this->angle->getMinutes(-1))->toBe(28.0);
    expect($this->angle->getMinutes(0))->toBe(29.0);
    expect($this->angle->getMinutes(1))->toBe(28.7);
    expect($this->angle->getMinutes(2))->toBe(28.68);
    expect($this->angle->getMinutes(3))->toBe(28.676);
    expect($this->angle->getMinutes(4))->toBe(28.6757);
    expect($this->angle->getMinutes(5))->toBe(28.67568);
});

test('getSeconds', function () {
    expect($this->angle->getSeconds())->toBe(40.5408);
    expect($this->angle->getSeconds(-1))->toBe(40.0);
    expect($this->angle->getSeconds(0))->toBe(41.0);
    expect($this->angle->getSeconds(1))->toBe(40.5);
    expect($this->angle->getSeconds(2))->toBe(40.54);
    expect($this->angle->getSeconds(3))->toBe(40.541);
    expect($this->angle->getSeconds(4))->toBe(40.5408);
});

test('toDecimal', function () {
    expect($this->angle->toDecimal())->toBe($this->decimalAngle);
    expect(Angle::make($this->decimalAngle + 370)->toDecimal())->toBe($this->decimalAngle + 10);
});

test('toArray', function () {
    expect($this->angle->toArray())->toBeArray();
    expect($this->angle->toArray()['direction'])->toBe('+');
    expect($this->angle->toArray()['degrees'])->toBe(51);
    expect($this->angle->toArray()['minutes'])->toBe(28);
    expect($this->angle->toArray()['seconds'])->toBe(40.5408);
});

test('toString basic placeholders', function () {
    expect($this->angle->toString())->toBe('51°28\'41"');
    expect($this->smallAngle->toString('{SS}{dd.-1}°{mm.-1}\'{ss.0}"'))->toBe('+01°02\'06"');

    expect($this->negativeAngle->toString('{d.-1}{m.-1}{s.0}'))->toBe('512841');
    expect($this->negativeAngle->toString('{S}{d.-1}{m.-1}{s.0}'))->toBe('-512841');
    expect($this->smallNegativeAngle->toString('{SS}{dd.-1}°{mm.-1}\'{ss.0}"'))->toBe('-01°02\'06"');
});

test('toString degree placeholder precision', function () {
    expect($this->angle->toString('{d.-1}'))->toBe('51');
    expect($this->angle->toString('{d.0}'))->toBe('51');
    expect($this->angle->toString('{d.1}'))->toBe('51.5');
    expect($this->angle->toString('{d.2}'))->toBe('51.48');
    expect($this->angle->toString('{d.3}'))->toBe('51.478');
    expect($this->angle->toString('{d.4}'))->toBe('51.4779');
    expect($this->angle->toString('{d.5}'))->toBe('51.47793');
    expect($this->angle->toString('{d.6}'))->toBe('51.477928');

    expect($this->smallAngle->toString('{dd.-1}'))->toBe('01');
    expect($this->smallAngle->toString('{dd.0}'))->toBe('01');
    expect($this->smallAngle->toString('{dd.1}'))->toBe('01.0');
    expect($this->smallAngle->toString('{dd.2}'))->toBe('01.04');
    expect($this->smallAngle->toString('{dd.3}'))->toBe('01.035');
});

test('toString minute placeholder precision', function () {
    expect($this->angle->toString('{mm.-1}'))->toBe('28');
    expect($this->angle->toString('{mm.0}'))->toBe('29');
    expect($this->angle->toString('{mm.1}'))->toBe('28.7');
    expect($this->angle->toString('{mm.2}'))->toBe('28.68');
    expect($this->angle->toString('{mm.3}'))->toBe('28.676');
    expect($this->angle->toString('{mm.4}'))->toBe('28.6757');
    expect($this->angle->toString('{mm.5}'))->toBe('28.67568');

    expect($this->smallAngle->toString('{mm.-1}'))->toBe('02');
    expect($this->smallAngle->toString('{mm.0}'))->toBe('02');
    expect($this->smallAngle->toString('{mm.1}'))->toBe('02.1');
    expect($this->smallAngle->toString('{mm.2}'))->toBe('02.10');
});

test('toString second placeholder precision', function () {
    expect($this->angle->toString('{ss.-1}'))->toBe('40');
    expect($this->angle->toString('{ss.0}'))->toBe('41');
    expect($this->angle->toString('{ss.1}'))->toBe('40.5');
    expect($this->angle->toString('{ss.2}'))->toBe('40.54');
    expect($this->angle->toString('{ss.3}'))->toBe('40.541');
    expect($this->angle->toString('{ss.4}'))->toBe('40.5408');

    expect($this->smallAngle->toString('{ss.-1}'))->toBe('06');
    expect($this->smallAngle->toString('{ss.0}'))->toBe('06');
    expect($this->smallAngle->toString('{ss.1}'))->toBe('06.0');
    expect($this->smallAngle->toString('{ss.2}'))->toBe('06.00');
});

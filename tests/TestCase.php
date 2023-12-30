<?php

namespace Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;
use RiftLab\Radiance\Angle;
use RiftLab\Radiance\Latitude;
use RiftLab\Radiance\Longitude;

abstract class TestCase extends BaseTestCase
{
    protected array $stringFormats = [
        '51°28\'40.5408"',
        '51e28\'40.5408"',
        '51n28\'40.5408"',
        '51°n28\'40.5408"',
        '51°e28\'40.5408"',
        '51n28.67568',
        '51e28.67568',
    ];

    protected float $decimalAngle;

    protected Angle $angle;
    protected Angle $negativeAngle;

    protected Latitude $latitude;
    protected Longitude $longitude;

    protected Latitude $negativeLatitude;
    protected Longitude $negativeLongitude;

    protected float $smallDecimalAngle;

    protected Angle $smallAngle;
    protected Angle $smallNegativeAngle;

    protected Latitude $smallLatitude;
    protected Longitude $smallLongitude;

    protected Latitude $smallNegativeLatitude;
    protected Longitude $smallNegativeLongitude;

    protected function setUp(): void
    {
        $this->decimalAngle = 51.477928;

        $this->angle = Angle::make($this->decimalAngle);
        $this->negativeAngle = Angle::make(-$this->decimalAngle);

        $this->latitude = Latitude::make($this->decimalAngle);
        $this->negativeLatitude = Latitude::make(-$this->decimalAngle);

        $this->longitude = Longitude::make($this->decimalAngle);
        $this->negativeLongitude = Longitude::make(-$this->decimalAngle);

        $this->smallDecimalAngle = 1.035;

        $this->smallAngle = Angle::make($this->smallDecimalAngle);
        $this->smallNegativeAngle = Angle::make(-$this->smallDecimalAngle);

        $this->smallLatitude = Latitude::make($this->smallDecimalAngle);
        $this->smallLongitude = Longitude::make($this->smallDecimalAngle);

        $this->smallNegativeLatitude = Latitude::make(-$this->smallDecimalAngle);
        $this->smallNegativeLongitude = Longitude::make(-$this->smallDecimalAngle);
    }
}

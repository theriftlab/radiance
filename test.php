<?php

use RiftLab\Radiance\Angle;
use RiftLab\Radiance\Latitude;
use RiftLab\Radiance\Longitude;

require __DIR__ . '/vendor/autoload.php';

// TODO: type-hint formatter?
// TODO: consolidate coordinate formatters?


// echo Angle::make(-1.035)->toString('{DD}{dd.-1}°{mm.-1}\'{ss.0}"');
// var_dump(Angle::make(1.035)->toString('{DD}{dd.-1}°{mm.-1}\'{ss.0}"'));
// var_dump(Angle::make(-1.035)->toString('{DD}{dd.-1}°{mm.-1}\'{ss.0}"'));

// ->toBe('-01°02\'06"');

// 51.477928
// +1.035 = 52.512928
// -1.035 = 50.442928 = 50°26.57568;


echo Latitude::make(51.477928)->distanceTo(1.035);
echo PHP_EOL;
// echo Angle::make(51.477928)->distanceFrom(1.035);
// echo PHP_EOL;
// echo Angle::make(50.442928);
// echo Latitude::make(51.477928)->distanceTo(80);
// echo PHP_EOL;
// echo Latitude::make(51.477928)->distanceFrom(80);
// echo PHP_EOL;
// echo $lat;


// $angle = -117.15;
// $angle = 51.477928;             // 51°28'40.5408"
// $lat = '180°28e40.5408"59';
// $lat2 = '20.5°';

// $angle = Latitude::make(51.477928)->distanceTo(10);
// echo $angle;
// $angle = Angle::make(1);
// echo $angle->toString('{dd.-1}°{mm.-1}\'{ss.3}"');

// echo Angle::make(570)->add(420);

// echo Calculate::between(350, 20);
// echo PHP_EOL;
// echo Calculate::between(20, 350);
// echo PHP_EOL;
// echo Calculate::between(90, 270);
// echo PHP_EOL;
// echo Calculate::between(270, 90);
// echo PHP_EOL;

// echo Angle::make(350)->distanceTo(20);
// echo PHP_EOL;
// echo Angle::make(30)->midpointWith(20);
// echo PHP_EOL;
// echo Angle::make(350)->distanceFrom(20);
// echo PHP_EOL;

// $values = [1, 1.2, 1.234, 23, 23.5, 23.4567];

// foreach ($values as $value) {
//     echo sprintf('%05.2f', $value); //.'.'.bcsub($value, intval($value), 10);
//     // echo PHP_EOL;
//     // echo bcsub($value, intval($value), 10);
//     echo PHP_EOL;
// }

// 280.5813029476475
// 226.43074774492607
// 253.50602534628678

// $angle1 = Angle::make(280.5813029476475);
// $angle2 = Angle::make(226.43074774492607);

// echo $angle1->midpoint($angle2)->toDecimal();

// $angle = 9.477928;

// foreach (range(0, 4) as $precision) {
//     $value = number_format($angle, $precision);

//     $value = $value < 10 ? "0$value" : (string)$value;

//     print($value) . PHP_EOL;
// }


// $angle = 51.477928;
// $angle = 1.035;
// $angle = '0°0′5.3″W';

// $distance1 = Angle::make(100)->distanceTo(280)->toDecimal();
// echo $distance1;
// echo PHP_EOL;
// $distance2 = Angle::make(280)->distanceTo(100)->toDecimal();
// echo $distance2;

// Angle::setDefaultFormat(Format::LATITUDE);

// echo Angle::make('-12.345');


// echo Angle::make('451°28\'40.5408"')->add(370);


// echo PHP_EOL;

// $angle = Angle::make(10);

// $lon1 = Longitude::make(10);
// $lon2 = Longitude::make(-170);
// echo $lon1->midpointWith($lon2);
// echo PHP_EOL;
// echo $lon2->midpointWith($lon1);
// echo PHP_EOL;


// // echo $lon->add($angle);
// $lat1 = Latitude::make(52.512928);
// echo $lat1;

// $lat = Latitude::make(51.477928)->distanceTo(91);
// echo $lat;
// 52n30.78

// echo 'yo';


// echo Angle::make(-90)->distanceTo(90);
// echo PHP_EOL;
// echo Angle::make(-90)->midpointWith(90);
// echo PHP_EOL;
// echo Angle::make(90)->distanceTo(-90);
// echo PHP_EOL;
// echo Angle::make(90)->midpointWith(-90);
// echo PHP_EOL;


// echo Angle::make(-100)->distanceTo(100);
// echo PHP_EOL;
// echo Angle::make(-100)->midpointWith(100);
// echo PHP_EOL;
// echo Angle::make(100)->distanceTo(-100);
// echo PHP_EOL;
// echo Angle::make(100)->midpointWith(-100);
// echo PHP_EOL;

# Angle Alchemy

Radiance provides simple, lightweight classes to make it easy for your PHP applications to convert between various angle and coordinate formats, and to perform common operations on them such as addition and subtraction, and finding distances and midpoints.

## Installation

```bash
composer require theriftlab/radiance
```

## Usage

### Examples

Radiance offers three main classes: `Angle`, `Latitude` and `Longitude`. Being fairly simple classes, their underlying structure is much the same, with only a few differences.

```php
use RiftLab\Radiance\Angle;

$angle = Angle::make(-51.477928);

echo $angle;
// Output: -51°28'41"

$angle2 = Angle::make('10°');

echo $angle->distanceTo($angle2);
// Output: 61°28'41"
echo $angle->distanceFrom($angle2);
// Output: -61°28'41"
echo $angle2->distanceTo($angle);
// Output: -61°28'41"
echo $angle->distanceTo(10);
// Output: 61°28'41"

echo $angle->add($angle2);
// Output: -41°28'41"
echo $angle->add(10);
// Output: -41°28'41"
echo $angle->sub($angle2);
// Output: -61°28'41"
echo $angle->sub(10);
// Output: -61°28'41"
echo $angle->add($angle2)->distanceTo($angle);
// Output: -10°00'00"

echo Angle::make(350)->midpointWith(20);
// Output: 05°00'00
```

### Instantiation

Objects can be constructed from almost any format. A few more examples using `Angle`:

```php
// These will all produce identical objects:
$angle1 = Angle::make(-51.477928);
$angle2 = Angle::make('-51°28\'40.5408"');
$angle3 = Angle::make('51°28\'40.5408"W');
$angle4 = Angle::make('51w28\'40.5408');
$angle5 = Angle::make('51s28.67568');

var_dump($angle1 == $angle2);
// Output: bool(true)
var_dump($angle2 == $angle3);
// Output: bool(true)
// ..etc.
```

### Coordinate Classes

In addition to the basic `Angle` class, there are also `Latitude` and `Longitude` classes. These behave the same as the `Angle` class, only they are limited to their geographical boundaries: -90° to 90° for `Latitude` and -180° to 180° for `Longitude`. Attempting to instantiate with angles outside these limits, or to `add()` / `sub()` values that would push them outside of these limits, will throw an exception.

Although the output for all types can be customized (see the [String Formatting](#string-formatting) section below), the only other difference with the coordinate classes is their default string format:

```php
$lat = Latitude::make(-51.477928);
echo $lat;
// Output: 51s28.68

echo $lat->add(60);
// Output: 8n31.32

echo $lat->midpointWith(10);
// Output: 20s44.34

echo $lat->sub(40);
// Below -90°: LatitudeBoundaryException thrown

$dist = Angle::make(40);
echo $lat->sub($dist);
// LatitudeBoundaryException still thrown
```

### Negative Angles

Radiance is fairly non-opinionated about the angles you wish to represent with an `Angle` instance. You can construct one from a negative angle, although it will be normalized:

```php
echo Angle::make(-560);
// Output: -200°0'0"
```

However, since the `distanceTo()` / `distanceFrom()` and `midpointWith()` calculations are designed to find the shortest distance between two points on a 0-360° circle, using negative angles might yield results that appear less than intuitive at first glance:

```php
$angle = Angle::make(-200);     // 160° on a circle

echo $angle;
// Output: -200°0'0"
echo $angle->distanceTo(140);   // 160° to 140°
// Output: -20°0'0"
echo $angle->distanceTo(180);   // 160° to 180°
// Output: 20°0'0"
```

If we get really weird and mix our negatives, they still stack up:

```php
$angle = Angle::make(-560);     // still 160°

echo $angle;
// Output: -200°0'0"
echo $angle->distanceTo(-220);  // 140° on a circle, so still 160° to 140°
// Output: -20°0'0"
echo $angle->distanceTo(-180);  // 180° on a circle, so still 160° to 180°
// Output: 20°0'0"
```

### Diffs

Although not designed for direct instantiation, an instance of the `Diff` class is returned for all `distanceTo()` and `distanceFrom()` operations. This is essentially the same as the `Angle` class but limited to output functionality only, without any further operations available. Its default formatting will reflect whatever class it is calculated from:

```php
echo Angle::make(10)->distanceTo(30);
// Output: 20°00'00"

echo Latitude::make(10)->distanceTo(30);
// Output: 20n0.00

echo Longitude::make(10)->distanceTo(30);
// Output: 20e0.00
```

See the [String Formatting](#string-formatting) section below for details on how to customize the output.

### Functions

The following functions are available for all class types, including `Diff`:

| Method | Return Type | Parameters | Default | Description |
| --- | --- | --- | --- | --- |
| `isNegative()` | `bool` | None | None | Returns whether the angle is negative. |
| `getDegrees()` | `float` | `int $decimalPoints` | `null` | Returns the unsigned degrees portion of the angle. If decimal points are set to `-1` it will be `floor()`ed, passing `0` and upward will round it as normal, and `null` will simply return the full decimal value. |
| `getMinutes()` | `float` | `int $decimalPoints` | `null` | The same as above but for minutes. |
| `getSeconds()` | `float` | `int $decimalPoints` | `null` | The same as above but for seconds. |
| `toDecimal()` | `float` | None | None | Returns the underlying `float` angle. |
| `toArray()` | `array` | None | None | Returns an array with the following elements:<br>* `direction`: either `-` or `+`.<br>* `degrees`: rounded-down `int` representing degrees.<br>* `minutes`: rounded-down `int` representing minutes.<br>* `seconds`: a `float` representing seconds. |
| `toString()` | `string` | `string $format` | Dependent on type | Formats the angle as requested. See the [String Formatting](#string-formatting) section below for details. Calling this with no arguments will yield the default format depending on the calling instance's class type, as demonstrated in the examples above. |

The following additional operations are available for the `Angle`, `Latitude` and `Longitude` classes which implement `AngleInterface`:

| Method | Return Type | Parameters | Default | Description |
| --- | --- | --- | --- | --- |
| `add()` | self | `AngleInterface \| float $angle` | None | Adds either another `AngleInterface` instance or a float, and returns a new instance of the calling class' type constructed from the result. |
| `sub()` | self | `AngleInterface \| float $angle` | None | The same as above but for subtraction. |
| `distanceTo()` | `Diff` | `AngleInterface \| float $angle` | None | Calculates the shortest distance on a circle between the calling instance and the passed `AngleInterface` instance or float, and returns a new instance of the calling class' type constructed from the result. As seen in the examples above, the result will be negative if the passed angle is behind the first, and positive if ahead. |
| `distanceFrom()` | `Diff` | `AngleInterface \| float $angle` | None | The inverse of the above function. |
| `midpointWith()` | self | `AngleInterface \| float $angle` | None | Calculates the midpoint of the shortest distance on a circle between the calling instance and the passed `AngleInterface` instance or float, and returns a new instance of the calling class' type constructed from the result. |

The `Angle` class itself has one additional function:

| Method | Return Type | Parameters | Default | Description |
| --- | --- | --- | --- | --- |
| `normalizeTo()` | `Angle` | `int $size` | None | Normalizes the angle to the passed integer and returns a new `Angle` instance constructed from the result. For example, if a circle is split into quadrants and you only wish to know the angle within its own quadrant, you would pass `90` to this function. |

### String Formatting

The `toString()` function accepts a string of placeholders to dictate its formatting. The default format strings for each class type are as follows:

| Class | Format String | Output |
| --- | --- | --- |
| `Angle` | `'{D}{dd.-1}°{mm.-1}\'{ss.0}"'` | Degrees, minutes, and seconds with leading zeroes. Seconds are rounded, and the output is prefixed by a `-` sign if negative. |
| `Latitude` | `'{d.-1}{D}{m.2}'` | Geographical latitude. Degrees, North / South direction, and a decimal minute rounded to two places. |
| `Longitude` | `'{d.-1}{D}{m.2}'` | Geographical longitude. Similar to above: degrees, West / East direction, and a decimal minute rounded to two places. |

To pass your own format, the following placeholders are available for all class types:

| Placeholder | Output |
| --- | --- |
| `{S}` | Sign: a `-` symbol if the angle is negative, otherwise nothing. |
| `{SS}` | Sign: a `-` symbol if the angle is negative, otherwise `+`. |
| `{d.X}` | Degrees, rounded to `X` places, identical to the `$decimalPoints` parameter described above in the [operations](#operations) table. To pass `null` simply omit the decimal point, ie. `{d}`. |
| `{m.X}` | The same as above, but for minutes. |
| `{s.X}` | The same as above, but for seconds. |
| `{dd.X}` | Degrees as above, but with leading zero. |
| `{mm.X}` | The same as above, but for minutes. |
| `{ss.X}` | The same as above, but for seconds. |

For the `Latitude` class only, the following additional placeholders are available:

| Placeholder | Output |
| --- | --- |
| `{D}` | Direction: a lowercase `s` if the angle is negative, otherwise lowercase `n`. |
| `{DD}` | Direction: the same as above but uppercase. |

For the `Longitude` class only, the following additional placeholders are available:

| Placeholder | Output |
| --- | --- |
| `{D}` | Direction: a lowercase `w` if the angle is negative, otherwise lowercase `e`. |
| `{DD}` | Direction: the same as above but uppercase. |

## Tests

Tests are included via Pest:

```bash
./vendor/bin/pest
```

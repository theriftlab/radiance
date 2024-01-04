<?php

namespace RiftLab\Radiance\Services;

class Convert
{
    public static function toRawDecimal(float | string $angle): string
    {
        if (is_numeric($angle)) {
            return (string)$angle;
        }

        $values = array_values(array_pad(array_filter(mb_split('([^0-9\.-])', $angle), 'strlen'), 3, 0.0));

        $arrayAngle = array_map(
            fn ($value, $index) => bcdiv(abs($value), bcpow('60', $index), Precision::forString()),
            $values,
            array_keys($values),
        );

        $decimalAngle = array_reduce($arrayAngle, fn ($carry, $item) => bcadd($carry, $item, Precision::forString()), 0);

        if ($values[0] < 0 || preg_match('/s|w/i', $angle) > 0) {
            $decimalAngle = '-'.$decimalAngle;
        }

        return $decimalAngle;
    }

    public static function toArray(string $angle): array
    {
        $arrayAngle = [Value::abs($angle), 0.0, 0.0];

        foreach ([1, 2] as $i) {
            $arrayAngle[$i] = bcmul(bcsub($arrayAngle[$i-1], intval($arrayAngle[$i-1]), Precision::forString()), '60', Precision::forString());
        }

        return $arrayAngle;
    }
}

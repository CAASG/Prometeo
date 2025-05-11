<?php

namespace App\Helpers;

class ColorHelper
{
    /**
     * Determines if a given hex color is dark.
     *
     * @param string $hexColor The hex color code (e.g., "#RRGGBB" or "#RGB").
     * @return bool True if the color is dark, false otherwise.
     */
    public static function isColorDark(string $hexColor): bool
    {
        $hexColor = ltrim($hexColor, '#');

        if (strlen($hexColor) == 3) {
            $hexColor = $hexColor[0] . $hexColor[0] . $hexColor[1] . $hexColor[1] . $hexColor[2] . $hexColor[2];
        }

        if (strlen($hexColor) != 6) {
            // Default to assuming light if format is incorrect
            return false;
        }

        $r = hexdec(substr($hexColor, 0, 2));
        $g = hexdec(substr($hexColor, 2, 2));
        $b = hexdec(substr($hexColor, 4, 2));

        // HSP (Highly Sensitive Poo) equation from http://alienryderflex.com/hsp.html
        $hsp = sqrt(
            0.299 * ($r * $r) +
            0.587 * ($g * $g) +
            0.114 * ($b * $b)
        );

        // Using 127.5 as the threshold means that colors with HSP < 127.5 are considered dark.
        return $hsp < 127.5;
    }
} 
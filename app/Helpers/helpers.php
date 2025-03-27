<?php

use App\Helpers\Menu\Contracts\MenuItem;
use App\Helpers\Menu\Contracts\MenuProvider;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\App;

if (!function_exists('menu')) {
    /**
     * Get the menu items.
     *
     * @param  string $key
     * @return array<MenuItem>
     */
    function menu(string $key): array
    {
        try {
            return App::make(MenuProvider::class)->menu($key);
        } catch (BindingResolutionException) {
            return [];
        }
    }
}

if (!function_exists('dummyImage')) {
    /**
     * Generate a dummy image.
     *
     * @param  int    $width
     * @param  int    $height
     * @param  string $bgHex
     * @param  string $textHex
     * @param  string $text
     * @return string
     */
    function dummyImage(int $width, int $height, string $bgHex, string $textHex, string $text): string
    {
        $hexToRgb = fn ($hex) => [
            hexdec(substr($hex, 0, 2)),
            hexdec(substr($hex, 2, 2)),
            hexdec(substr($hex, 4, 2)),
        ];

        $image = imagecreate($width, $height);
        imagecolorallocate($image, ...$hexToRgb($bgHex));
        $textColor = imagecolorallocate($image, ...$hexToRgb($textHex));

        $fontPath = public_path('fonts/arial.ttf');
        $textBox = imagettfbbox(12, 0, $fontPath, $text);
        $x = ($width - abs($textBox[4] - $textBox[0])) / 2;
        $y = ($height + abs($textBox[5] - $textBox[1])) / 2;

        imagettftext($image, 12, 0, $x, $y, $textColor, $fontPath, $text);

        ob_start();
        imagepng($image);
        $imageData = ob_get_clean();

        imagedestroy($image);

        return $imageData;
    }
}

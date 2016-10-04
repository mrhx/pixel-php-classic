<?php
/**
 * Return a GIF with Nth image
 * @link https://github.com/mrhx/pixel-php-classic
 */

define('PIXEL_APP', 1);

require 'protected/config.php';

$blockId = validateBlockId(isset($_GET['id']) ? $_GET['id'] : '1');

$db = db();

$query = $db->query("SELECT pixels FROM block WHERE id = $blockId LIMIT 1");
if (!$data = $query->fetch()) {
    http_response_code(404);
    exit;
}

if (!$image = imagecreatetruecolor(BLOCK_WIDTH, BLOCK_HEIGHT)) {
    trigger_error("Can't create an image of the $blockId block", E_USER_ERROR);
}

$pixels = str_split($data->pixels, 6);

imagefill($image, 0, 0, allocateRGBColor($image, COLOR_BG2));

$bgColor = allocateRGBColor($image, COLOR_BG);
$palette = [];

foreach (array_unique($pixels) as $color) {
    $palette[$color] = allocateRGBColor($image, $color);
}

for ($y = $i = 0; $y < BLOCK_HEIGHT; ++$y) {
    for ($x = 0; $x < BLOCK_WIDTH; ++$x, ++$i) {
        if (COLOR_TRANSPARENT !== $pixels[$i]) {
            imagesetpixel($image, $x, $y, $palette[$pixels[$i]]);
        } elseif (($x + $y) % 2) {
            imagesetpixel($image, $x, $y, $bgColor);
        }
    }
}

header('Content-Type: image/png');

imagepng($image);
imagedestroy($image);

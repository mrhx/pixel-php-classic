<?php
/**
 * Draw one pixel
 * @link https://github.com/mrhx/pixel-php-classic
 */

define('PIXEL_APP', 1);

require 'protected/config.php';

$blockId = validateBlockId(isset($_GET['id']) ? $_GET['id'] : '');
$posX = validatePosition(isset($_POST['image_x']) ? $_POST['image_x'] : '');
$posY = validatePosition(isset($_POST['image_y']) ? $_POST['image_y'] : '');
$width = validatePosition(isset($_POST['width']) ? $_POST['width'] : '');
$color = validateColor(isset($_POST['color']) ? $_POST['color'] : '');

$step = $width / BLOCK_WIDTH;
$posX = intval(($posX - 1) / $step);
$posY = intval(($posY - 1) / $step);

if ($posX >= BLOCK_WIDTH || $posY >= BLOCK_HEIGHT) {
    header('Location: /?error=21');
    exit;
}

$pixelId = $posY * BLOCK_WIDTH + $posX;

$db = db();

$db->exec(getClickQuery($pixelId, $color, $blockId));

if (!empty($_GET['ajax'])) {
    echo 'OK';
    exit;
}

if ($blockId == 1) {
    header("Location: /?color={$color}");
} else {
    header("Location: /?id={$blockId}&color={$color}");
}

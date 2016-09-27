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

// $db = $this->getPdo();
// if ($this->hasUser()) {
//     $condition = "user_id = $userId";
//     $limit = 500;
//     $error = 'click_user_limit';
// } else {
//     $condition = "ip = {$db->quote($this->getIp())}";
//     $limit = 300;
//     $error = 'click_ip_limit';
// }
// $query = $db->query("SELECT COUNT(*) FROM history WHERE $condition AND created > DATE_SUB(NOW(), INTERVAL 1 DAY)");
// if ($query->fetch(\PDO::FETCH_COLUMN) >= $limit) {
//     $this->setError('click', $error);
// }

$db = db();

$exec = $db->exec("UPDATE block SET
    updated = NOW(),
    updated_by = 0,
    pixels = INSERT(pixels, $pixelId * 6 + 1, 6, '$color')
    WHERE id = $blockId LIMIT 1");

if ($exec !== false) {
    $db->exec("INSERT INTO history SET
        created = NOW(),
        user_id = 0,
        ip = '127.0.0.1',
        block_id = $blockId,
        pixel_id = $pixelId,
        value = '$color'");
}

header("Location: /?id={$blockId}&color={$color}");

<?php
/**
 * Configuration of the app
 * @link https://github.com/mrhx/pixel-php-classic
 */

if (!defined('PIXEL_APP')) {
    exit;
}

define('BLOCK_MAX', 278);
define('BLOCK_WIDTH', 60);
define('BLOCK_HEIGHT', 60);
define('COLOR_BG', 'ecf0f1');
define('COLOR_BG2', 'ffffff');
define('COLOR_TRANSPARENT', '000000');

/**
 * Get config param
 * @param string $key
 * @return mixed
 */
function getConfig($key)
{
    static $config;
    if ($config === null) {
        $config = require __DIR__ . DIRECTORY_SEPARATOR . 'config-local.php';
    }
    return isset($config[$key]) ? $config[$key] : null;
}

/**
 * Connect to the database
 * @return PDO
 */
function db()
{
    return new PDO(getConfig('db.dsn'), getConfig('db.user'), getConfig('db.password'), [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
    ]);
}

/**
 * Allocate a RGB color
 * @param resource $image
 * @param string $rgbColor RRGGBB
 * @return integer
 */
function allocateRGBColor($image, $rgbColor)
{
    list($red, $green, $blue) = str_split($rgbColor, 2);
    return imagecolorallocate($image, hexdec($red), hexdec($green), hexdec($blue));
}

/**
 * Validate block ID or exit, if it's invalid
 * @param string $blockId
 * @return integer
 */
function validateBlockId($blockId)
{
    if (!ctype_digit($blockId) || $blockId < 1 || $blockId > BLOCK_MAX) {
        http_response_code(404);
        exit;
    }
    return intval($blockId);
}

/**
 * Validate pixel position or exit, if it's invalid
 * @param string $pos
 * @return integer
 */
function validatePosition($pos)
{
    if (!ctype_digit($pos) || $pos < 1) {
        header('Location: /?error=11');
        exit;
    }
    return intval($pos);
}

/**
 * Validate RGB color or exit, if it's invalid
 * @param string $color
 * @return string
 */
function validateColor($color)
{
    if (!ctype_xdigit($color) || strlen($color) != 6) {
        header('Location: /?error=12');
        exit;
    }
    return $color;
}

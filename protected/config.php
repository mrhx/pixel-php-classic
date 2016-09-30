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
 * Get available colors
 * @return array
 */
function getColors()
{
    return [
        'transparent' => '000000',
        'white' => 'ffffff',
        'blue' => '2980b9',
        'green' => '27ae60',
        'yellow' => 'f1c40f',
        'red' => 'c0392b'
    ];
}

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
 * Check the database and install the tables, if needed
 */
function checkAndInstall()
{
    $dsn = getConfig('db.dsn');
    if (strncmp($dsn, 'sqlite', 6) === 0) {
        if (!file_exists(__DIR__ . DIRECTORY_SEPARATOR . 'database.sqlite')) {
            $db = db();
            $exec = $db->exec("CREATE TABLE IF NOT EXISTS block (
                id INT UNSIGNED NOT NULL PRIMARY KEY,
                pixels VARCHAR(21600) NOT NULL
            )");
            $pixels = str_repeat('0', 21600);
            for ($i = 1; $i <= BLOCK_MAX; ++$i) {
                $db->exec("INSERT INTO block VALUES ($i, '$pixels')");
            }
        }
    } elseif (strncmp($dsn, 'mysql', 5) === 0) {
        // $db = db();
        // $db->exec("CREATE TABLE IF NOT EXISTS block (
        //     id INT(8) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        //     pixels VARCHAR(21600) NOT NULL
        // ) ENGINE InnoDB CHARACTER SET latin1 COLLATE latin1_bin");
    }
}

/**
 * Get a query for the click action
 * @param integer $pixelId
 * @param string $color
 * @param integer $blockId
 * @return string
 */
function getClickQuery($pixelId, $color, $blockId)
{
    $dsn = getConfig('db.dsn');
    if (strncmp($dsn, 'sqlite', 6) === 0) {
        return "UPDATE block SET pixels = SUBSTR(pixels, 1, $pixelId * 6) || '$color' || SUBSTR(pixels, $pixelId * 6 + 1 + 6) WHERE id = $blockId";
    }
    return "UPDATE block SET pixels = INSERT(pixels, $pixelId * 6 + 1, 6, '$color') WHERE id = $blockId LIMIT 1";
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

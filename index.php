<?php
/**
 * @link https://github.com/mrhx/pixel-php-classic
 */

define('PIXEL_APP', 1);

require 'protected/config.php';

checkAndInstall();

$blockId = validateBlockId(isset($_GET['id']) ? $_GET['id'] : '1');
$color = isset($_GET['color']) ? $_GET['color'] : '2980b9';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Youpixelart - Crowd pixel art online</title>
    <meta name="keywords" content="pixelart, crowd, pixel art, 8bit, painting, drawing, online">
    <meta name="description" content="Draw pixel art online on a canvas of million pixels">
    <link rel="stylesheet" href="/css/app.min.css">
    <!--[if IE]><link rel="shortcut icon" href="/favicon.ico"><![endif]-->
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="icon" href="/favicon.png">
</head>
<body>
    <div class="container" id="container" data-block-id="<?= $blockId ?>">
        <form action="/click.php?id=<?= $blockId ?>" method="POST" id="form">
            <input type="hidden" name="width" value="960" id="width">
            <div class="toolbar" id="toolbar">
                <?php foreach (getColors() as $key => $value): ?>
                    <input type="radio" name="color" value="<?= $value ?>" id="<?= $key ?>"<?= $value === $color ? ' checked' : '' ?>>
                    <label for="<?= $key ?>" style="background: #<?= $value === COLOR_TRANSPARENT ? 'bdc3c7' : $value ?>;" title="<?= ucfirst($key) ?>"></label>
                <?php endforeach ?>
            </div>
            <div class="page-link" id="page-up">
                <?php if ($blockId == 1): ?>
                    <a href="/?id=<?= BLOCK_MAX ?>">Previous page &uarr;</a>
                <?php elseif ($blockId == 2): ?>
                    <a href="/">Previous page &uarr;</a>
                <?php else: ?>
                    <a href="/?id=<?= $blockId - 1 ?>">Previous page &uarr;</a>
                <?php endif ?>
            </div>
            <div id="images" class="images">
                <input type="image" name="image" src="/image.php?id=<?= $blockId ?>&amp;rnd=<?= time() ?>" width="<?= BLOCK_WIDTH ?>" height="<?= BLOCK_HEIGHT 
                ?>">
            </div>
            <div class="page-link" id="page-down">
                <?php if ($blockId == BLOCK_MAX): ?>
                    <a href="/">Next page &darr;</a>
                <?php else: ?>
                    <a href="/?id=<?= $blockId + 1 ?>">Next page &darr;</a>
                <?php endif ?>
            </div>
        </form>
    </div>
    <script src="/js/app.min.js"></script>
</body>
</html>

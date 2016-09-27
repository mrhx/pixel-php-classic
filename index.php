<?php
/**
 * @link https://github.com/mrhx/pixel-php-classic
 */

define('PIXEL_APP', 1);

require 'protected/config.php';

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
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
    <div class="container">
        <form action="/click.php?id=<?= $blockId ?>" method="POST">
            <input type="hidden" name="width" value="960">
            <div class="toolbar">
                <?php foreach (getColors() as $key => $value): ?>
                    <input type="radio" name="color" value="<?= $value ?>" id="c-<?= $key ?>"<?= $value === $color ? ' checked' : '' ?>>
                    <label for="c-<?= $key ?>" style="background: #<?= $value === COLOR_TRANSPARENT ? 'bdc3c7' : $value ?>;" title="<?= ucfirst($key) ?>"></label>
                <?php endforeach ?>
            </div>
            <div class="page-link">
                <?php if ($blockId == 1): ?>
                    <a href="/?id=<?= BLOCK_MAX ?>">Previous page &uarr;</a>
                <?php elseif ($blockId == 2): ?>
                    <a href="/">Previous page &uarr;</a>
                <?php else: ?>
                    <a href="/?id=<?= $blockId - 1 ?>">Previous page &uarr;</a>
                <?php endif ?>
            </div>
            <input type="image" name="image" src="/image.php?id=<?= $blockId ?>" width="<?= BLOCK_WIDTH ?>" height="<?= BLOCK_HEIGHT ?>">
            <div class="page-link">
                <?php if ($blockId == BLOCK_MAX): ?>
                    <a href="/">Next page &darr;</a>
                <?php else: ?>
                    <a href="/?id=<?= $blockId + 1 ?>">Next page &darr;</a>
                <?php endif ?>
            </div>
        </form>
    </div>
    <script src="/js/app.js"></script>
</body>
</html>

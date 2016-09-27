<?php
/**
 * @link https://github.com/mrhx/pixel-php-classic
 */

define('PIXEL_APP', 1);

require 'protected/config.php';

$blockId = validateBlockId(isset($_GET['id']) ? $_GET['id'] : '1');

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
        <form action="/click.php" method="POST">
            <input type="hidden" name="id" value="<?= $blockId ?>">
            <input type="hidden" name="width" value="960">
            <div class="toolbar">
                <input type="radio" name="color" value="000000">
                <input type="radio" name="color" value="ffffff">
                <input type="radio" name="color" value="2980b9" checked>
                <input type="radio" name="color" value="27ae60">
                <input type="radio" name="color" value="f1c40f">
                <input type="radio" name="color" value="c0392b">
            </div>
            <?php if ($blockId == 1): ?>
                <a href="/?id=<?= BLOCK_MAX ?>">Previous page</a>
            <?php elseif ($blockId == 2): ?>
                <a href="/">Previous page</a>
            <?php else: ?>
                <a href="/?id=<?= $blockId - 1 ?>">Previous page</a>
            <?php endif ?>
            <input type="image" name="image" src="/image.php?id=<?= $blockId ?>" width="<?= BLOCK_WIDTH ?>" height="<?= BLOCK_HEIGHT ?>">
            <?php if ($blockId == BLOCK_MAX): ?>
                <a href="/">Next page</a>
            <?php else: ?>
                <a href="/?id=<?= $blockId + 1 ?>">Next page</a>
            <?php endif ?>
        </form>
    </div>
    <script src="/js/app.js"></script>
</body>
</html>

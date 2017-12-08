<?php
/* @var $this \meow\base\View */
/* @var $content string */


?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?=$this->title?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>

    <h3>До контента</h3>
        <?= $content ?>
    <h3>После контента</h3>

    <?php $this->endBody() ?>
</body>
</html>
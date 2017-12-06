<?php
/**
 * Created by PhpStorm.
 * User: Konstantin
 * Date: 06.06.2017
 * Time: 23:03
 */
mb_internal_encoding('UTF-8');

require(__DIR__ . DIRECTORY_SEPARATOR . 'meow' . DIRECTORY_SEPARATOR . 'Meow.php');
$config = require(__DIR__ . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php');

(new \meow\base\App($config))->run();
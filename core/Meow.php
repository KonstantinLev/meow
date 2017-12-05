<?php

/**
 * Created by PhpStorm.
 * User: Konstantin
 * Date: 19.10.2017
 * Time: 21:38
 */

require(__DIR__ . '/SuperMeow.php');

class Meow extends \core\SuperMeow{}

defined('MEOW_PATH') or define('MEOW_PATH', __DIR__);

Meow::$classes = require(__DIR__ . '/classes.php');

spl_autoload_register(['Meow', 'autoload'], true, true);
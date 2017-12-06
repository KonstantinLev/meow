<?php
/**
 * Created by PhpStorm.
 * User: kote
 * Date: 12/6/17
 * Time: 2:35 PM
 */

namespace meow\web;

interface ResponseFormatterInterface {
    public function format($response);
}
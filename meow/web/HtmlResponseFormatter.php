<?php
/**
 * Created by PhpStorm.
 * User: kote
 * Date: 12/6/17
 * Time: 2:34 PM
 */

namespace meow\web;

use meow\base\Response;


class HtmlResponseFormatter implements ResponseFormatterInterface
{
    public $contentType = 'text/html';
    /**
     * @param Response $response
     */
    public function format($response)
    {
        if (stripos($this->contentType, 'charset') === false) {
            $this->contentType .= '; charset=' . $response->charset;
        }
        $response->getHeaders()->set('Content-Type', $this->contentType);
        if ($response->data !== null) {
            $response->content = $response->data;
        }
    }
}
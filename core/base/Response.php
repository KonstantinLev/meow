<?php
/**
 * Created by PhpStorm.
 * User: kote
 * Date: 12/5/17
 * Time: 9:58 AM
 */

namespace core\base;


class Response
{
    /*public function redirect($url, $statusCode = 302, $checkAjax = true)
    {
        if (is_array($url) && isset($url[0])) {
            // ensure the route is absolute
            $url[0] = '/' . ltrim($url[0], '/');
        }
        $url = Url::toRoute($url);
        if (strpos($url, '/') === 0 && strpos($url, '//') !== 0) {
            $url = App::$instance->getRequest()->getHostInfo() . $url;
        }
        if ($checkAjax) {
            if (App::$instance->getRequest()->getIsAjax()) {
                if (App::$instance->getRequest()->getHeaders()->get('X-Ie-Redirect-Compatibility') !== null && $statusCode === 302) {
                    // Ajax 302 redirect in IE does not work. Change status code to 200
                    $statusCode = 200;
                }
                if (App::$instance->getRequest()->getIsPjax()) {
                    $this->getHeaders()->set('X-Pjax-Url', $url);
                } else {
                    $this->getHeaders()->set('X-Redirect', $url);
                }
            } else {
                $this->getHeaders()->set('Location', $url);
            }
        } else {
            $this->getHeaders()->set('Location', $url);
        }
        $this->setStatusCode($statusCode);
        return $this;
    }*/
}
<?php
mb_internal_encoding('UTF-8');
require_once 'libs/manage_class.php';
require_once 'routes/url_class.php';

$url = new Url();
$manage = new Manage();
$link = ($_SERVER['HTTP_REFERER'] != '') ? $_SERVER['HTTP_REFERER'] : $url->index();
$func = $_REQUEST['func'];
switch ($func){
    case 'add_cart':
        $manage->addCart();
        break;
    case 'delete_cart':
        $manage->deleteCart();
        break;
    case 'cart':
        $manage->updateCart();
        break;
    case 'order':
        $result = $manage->addOrder();
        if ($result) $link = $url->message();
        break;
    default:
        exit;
}
header('Location: '.$link);
exit;
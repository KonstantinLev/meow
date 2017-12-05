<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="<?=$this->meta_desc?>">
    <meta name="keywords" content="<?=$this->meta_key?>">

    <meta property="og:image" content="path/to/image.jpg">
    <link rel="shortcut icon" href="files/img/favicon/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" href="img/favicon/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="img/favicon/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="img/favicon/apple-touch-icon-114x114.png">

    <!-- Chrome, Firefox OS and Opera -->
    <meta name="theme-color" content="#1a1a1a">
    <!-- Windows Phone -->
    <meta name="msapplication-navbutton-color" content="#1a1a1a">
    <!-- iOS Safari -->
    <meta name="apple-mobile-web-app-status-bar-style" content="#1a1a1a">

    <link rel="stylesheet" href="<?=$this->config->dir_bower_asset.'bootstrap-3.1.1/dist/css/bootstrap.css'?>">
    <title><?=$this->title?></title>
</head>
<body>

    <header class="site-header">
        <a href="<?=$this->index?>">Главная</a>
        <a href="<?=$this->cart?>">Корзина</a> (В корзине <b><?=$this->cart_count?></b> товаров на сумму <b><?=$this->cart_sum?></b> руб.)

        <p>Категории товаров</p>
        <?php include ('left_menu.tpl'); ?>

        <p>Поиск</p>
        <form method="get" action="search">
            <input type="text" name="q">
            <input type="submit" value="Найти">
        </form>
    </header>

    <div class="message">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php include "message.tpl"; ?>
                </div>
            </div>
        </div>

    </div>
    <div class="site-content">
        <?php include "content_".$this->content.".tpl";?>
    </div>

    <footer class="site-footer">
        <h2>Это мать его ФУТЕР!</h2>
    </footer>

    <link rel="stylesheet" href="files/css/main.css">
    <script src="<?=$this->config->dir_bower_asset.'jquery-2.0.3/jquery.min.js'?>"></script>
    <script src="<?=$this->config->dir_bower_asset.'bootstrap-3.1.1/dist/js/bootstrap.js'?>"></script>
</body>
</html>
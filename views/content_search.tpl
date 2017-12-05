<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php if ($this->q == '') { ?>
                <h2>Вы задали пустой поисковый запрос</h2>
            <?php } else { ?>
                <h3>Результаты поиска: <b><?=$rhis->q?></b></h3>
                <?php if (!$this->products) { ?>
                    <p>Ничего не найдено</p>
                <?php } else { ?>
                    <?php foreach($this->products as $product) { ?>
                    <div class="col-md-4">
                        <div class="good-block">
                            <p>Название товара: <?=$product['title']?></p>
                            <p>Артикул: <?=$product['articul']?></p>
                            <p>Цена: <?=$product['price']?></p>
                            <p>
                                фото товара:
                                <img class="good-block-img" src="<?=$product['path_img']?>" alt="доделать">
                            </p>
                            <a href="<?=$product['link']?>">Подробнее</a>
                            <a href="<?=$product['link_cart']?>">В корзину</a>
                        </div>
                    </div>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <?php include ('left_menu.tpl'); ?>
        </div>
        <div class="col-md-9">
            <section class="s-product">
                <ol class="breadcrumb">
                    <li><a href="<?=$this->index?>">Главная</a></li>
                    <li><a href="<?=$this->linkCategory?>"><?=$this->product['category']?></a></li>
                    <li class="active"><?=$this->product['title']?></li>
                </ol>
                <div class="good-block-current">
                    <h2><?=$this->product['title']?></h2>
                    <p>Артикул: <?=$this->product['articul']?></p>
                    <p>Тип: <?=$this->product['category']?></p>
                    <p><?=$this->product['short_desc']?></p>
                    <p>Цена: <?=$this->product['price']?></p>
                    <p>
                        фото товара:
                        <img class="good-block-img" src="<?=$this->product['path_img']?>" alt="<?=$this->product['title']?>">
                    </p>
                    <a href="<?=$this->product['link_cart']?>">В корзину</a>
                </div>
                <div class="other-goods">
                    <h3>С этим товаром также заказывают: </h3>
                    <div class="row">
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
                    </div>
                </div>
            </section>

        </div>
    </div>
</div>
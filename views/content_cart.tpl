<div class="container">
    <div class="row">
        <div class="col-md-12">
            <section class="s-cart">
                <form name="cart" action="<?=$this->action?>" method="post">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>Товар</th>
                            <th>Артикул</th>
                            <th>Цена ща 1 шт</th>
                            <th>Кол-во</th>
                            <th>Стоимость</th>
                            <th></th>
                        </tr>
                        <?php  ?>
                            <?php foreach($this->cartItems as $val) { ?>
                                <tr>
                                    <td><?=$val['title']?></td>
                                    <td><?=$val['articul']?></td>
                                    <td><?=$val['price']?></td>
                                    <td><input type="text" name="count_<?=$val['id']?>" value="<?=$val['count']?>"></td>
                                    <td><?=$val['summ']?></td>
                                    <td><a href="<?=$val['link_del']?>">Удалить</a></td>
                                </tr>
                            <?php } ?>
                        <?php  ?>
                    </table>
                    <p>Итого
                        <?php if($this->discount) { ?>
                            (с учетом скидки - <?=$this->absDiscount?>)
                        <?php } ?>:
                        <b><?=$this->summ?></b>
                        <?php if($this->discount) { ?>
                            (Скидка составила: <?=$this->relDiscount?> руб.)
                        <?php } ?>
                    </p>
                    <input type="submit" value="Пересчитать">
                    <hr>
                    <input type="text" name="discount" value="<?=$this->discount?>">
                    <input type="submit" value="Активировать купон">
                    <div class="right">
                        <input type="hidden" name="func" value="cart">
                        <a href="<?=$this->link_order?>">Оформить заказ</a>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>
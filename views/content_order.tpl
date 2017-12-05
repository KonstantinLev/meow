<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Оформляем заказ</h2>
            <form action="<?=$this->action?>" method="post">
                <div class="row">
                    <div class="col-md-6">
                        <select class="form-control" name="is_delivery">
                            <option value=""></option>
                            <option value="0">Самовывоз</option>
                            <option value="1">Доставка</option>
                        </select>
                        <div class="form-group">
                            <label for="name">Имя</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?=$this->name?>">
                        </div>
                        <div class="form-group">
                            <label for="phone">Телефон</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="<?=$this->phone?>">
                        </div>
                        <div class="form-group">
                            <label for="email">E-Mail</label>
                            <input type="text" class="form-control" id="email" name="email" value="<?=$this->email?>">
                        </div>
                        <div class="form-group">
                            <label for="address">Полный адрес (Страна, город, индекс, улица, дом, квартира)</label>
                            <textarea class="form-control" name="address" id="address" rows="10"><?=$this->address?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="notice">Примечания к заказу</label>
                            <textarea class="form-control" name="notice" id="notice"  rows="5"><?=$this->notice?></textarea>
                        </div>
                        <input type="hidden" name="func" value="order">
                        <button type="submit" class="btn btn-default">Оформить заказ</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="left-menu">
    <ul>
        <?php foreach($this->categories as $cat) { ?>
        <li><a href="<?=$cat['link']?>"><?=$cat['title']?></a></li>
        <?php } ?>
    </ul>
</div>
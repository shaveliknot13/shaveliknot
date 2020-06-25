<?php
defined('_JEXEC') or die;
?>

<ul class="so_tags_autocomplete">
<?php foreach($rows as $item): ?>
    <?php
    $item_str = str_replace($search,"<strong>$search</strong>",$item->title);
    ?>
    <li date-text="<?=$item->title?>"><?=$item_str?></li>
<?php endforeach; ?>
</ul>
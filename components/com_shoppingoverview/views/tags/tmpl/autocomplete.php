<?php
defined('_JEXEC') or die;
?>

<ul class="so_tags_autocomplete">
<?php foreach($rows as $item): ?>
    <?php
    if(!empty($item->{'title_'.$lang})){
        $item_str = str_replace($search,"<strong>$search</strong>",$item->{'title_'.$lang});
    }else{
        $item_str = str_replace($search,"<strong>$search</strong>",$item->title);
    }
    ?>
    <li date-text="<?=$item->title?>"><?=$item_str?></li>
<?php endforeach; ?>
</ul>
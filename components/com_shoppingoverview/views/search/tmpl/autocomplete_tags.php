<?php
defined('_JEXEC') or die;
?>

<ul>
<?php foreach($rows as $item): ?>
    <?php
    if(!empty($item->{'title_'.$lang})){
        $item_str = str_replace($search,"<strong>$search</strong>",$item->{'title_'.$lang});
    }else{
        $item_str = str_replace($search,"<strong>$search</strong>",$item->title);
    }
    ?>
    <li date-text="<?=$item->title?>">
        <a href="<?php echo JRoute::_( 'index.php?option=com_shoppingoverview&controller=tags&task=tag&Itemid=101&id='.$item->id ); ?>">
            <?=$item_str?>
        </a>
    </li>
<?php endforeach; ?>
</ul>
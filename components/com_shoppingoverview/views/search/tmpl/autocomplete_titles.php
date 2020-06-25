<?php
defined('_JEXEC') or die;
?>

<ul>
<?php foreach($rows as $item): ?>
    <?php
    $item_str = str_replace($search,"<strong>$search</strong>",$item->product.' '.$item->{'title_'.$lang});
    ?>
    <li>
        <a href="<?php echo JRoute::_( 'index.php?option=com_shoppingoverview&cat_alias='.$item->cat_alias.'&item_alias='.$item->{'alias_'.$lang}.'&Itemid=101' ); ?>">
            <?=$item_str?>
        </a>
    </li>
<?php endforeach; ?>
</ul>
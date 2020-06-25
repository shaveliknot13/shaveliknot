<?php
defined('_JEXEC') or die;
?>

<ul>
<?php foreach($rows as $item): ?>
    <?php
    $item_str = str_replace($search,"<strong>$search</strong>",$item->username);
    ?>
    <li>
        <a href="<?=JRoute::_( 'index.php?option=com_shoppingoverview&controller=users&task=profile&Itemid=101&id='.$item->id );?>">
            <?=$item_str?>
        </a>
    </li>
<?php endforeach; ?>
</ul>
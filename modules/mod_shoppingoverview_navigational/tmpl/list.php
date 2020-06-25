<?php
// No direct access
defined('_JEXEC') or die;

?>

<div class="fast_click">
    <?php
    $i=1;
    foreach($result as $key => $items):
    ?>
        <div class="fast_click_item"  date-comunitction="<?=$i?>"><?=$key?></div>
    <?php
    $i++;
    endforeach;
    ?>
</div>
<div class="clearfix"></div>
<?php
    $i=1;
    foreach($result as $key => $items):
?>
    <div class="list_item" date-comunitction="<?=$i?>"><?=$key?> <span><?php echo JText::_('MOD_SHOPPINGOVERVIEW_NAVIGATIONAL_CLICK_OPEN'); ?></span></div>
    <ul date-ul-comunitction="<?=$i?>">
        <?php
        foreach($items as $item):
        ?>
            <li>
                <a href="<?php echo JRoute::_( 'index.php?option=com_shoppingoverview&cat_alias='.$item->cat_alias.'&item_alias='.$item->{'alias_'.$lang}.'&Itemid=101' ); ?>">
                    <span><?=$key?></span><?php echo mb_substr($item->product.' '.$item->{'title_'.$lang},1,999,"UTF-8"); ?>
                </a>
            </li>
        <?php
        endforeach;
        ?>
    </ul>
<?php
    $i++;
    endforeach;
?>
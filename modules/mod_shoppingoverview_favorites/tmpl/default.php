<?php
// No direct access
defined('_JEXEC') or die;

$countfavorite = 0;
foreach($categories as $item){
    $countfavorite += $item->countfavorite;
}
?>
<div class="mod_shoppingoverview_favorites">
    <div class="name-modul-head-mobile"><i class="fas fa-star"></i> <?php echo JText::_('MOD_SHOPPINGOVERVIEW_FAVORITES'); ?></div>

    <div style="padding: 10px" class="name-modul-body-mobile">

        <div class="block-title name-modul-body-mobile hide-mobile"><?php echo JText::_('MOD_SHOPPINGOVERVIEW_FAVORITES'); ?></div>
        <div class="block name-modul-body-mobile">
            <ul class="nav">
                <li><a href="<?=JRoute::_('index.php?option=com_shoppingoverview&controller=users&task=userfavorites&Itemid=101')?>"><?php echo JText::_('MOD_SHOPPINGOVERVIEW_FAVORITES_ALL'); ?> <span>(<?=$countfavorite?>)</span></a></li>
                <?php foreach($categories as $item): ?>
                    <li><a href="<?=JRoute::_('index.php?option=com_shoppingoverview&controller=users&task=userfavorites&id='.$item->id.'&Itemid=101')?>"><?=$item->{'title_'.$lang}?> <span>(<?=$item->countfavorite?>)</span></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
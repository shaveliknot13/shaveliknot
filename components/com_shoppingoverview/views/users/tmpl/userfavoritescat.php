<?php

defined( '_JEXEC' ) or die; // No direct access

$countfavorite = 0;
foreach($this->cat as $item){
    $countfavorite += $item->countfavorite;
}

?>

<div class="row-fluid">
    <ul class="nav-user-favorites-cat">
        <li><a href="<?=JRoute::_('index.php?option=com_shoppingoverview&controller=users&task=userfavorites&Itemid=101')?>"><?php echo JText::_('COM_SHOPPINGOVERVIEW_ALL'); ?> (<?=$countfavorite?>)</a></li>
        <?php foreach($this->cat as $item): ?>
        <li><a href="<?=JRoute::_('index.php?option=com_shoppingoverview&controller=users&task=userfavorites&id='.$item->id.'&Itemid=101')?>"><?=$item->{'title_'.$this->lang}?> (<?=$item->countfavorite?>)</a></li>
        <?php endforeach; ?>
    </ul>
</div>

<?php

defined( '_JEXEC' ) or die; // No direct access

$countHits = 0;
foreach($this->cat as $item){
    $countHits += $item->countHits;
}

?>

<div class="row-fluid">
    <ul class="nav-user-favorites-cat">
        <li><a href="<?=JRoute::_('index.php?option=com_shoppingoverview&controller=users&task=userhits&Itemid=101')?>"><?php echo JText::_('COM_SHOPPINGOVERVIEW_ALL'); ?> (<?=$countHits?>)</a></li>
        <?php foreach($this->cat as $item): ?>
        <li><a href="<?=JRoute::_('index.php?option=com_shoppingoverview&controller=users&task=userhits&id='.$item->id.'&Itemid=101')?>"><?=$item->{'title_'.$this->lang}?> (<?=$item->countHits?>)</a></li>
        <?php endforeach; ?>
    </ul>
</div>

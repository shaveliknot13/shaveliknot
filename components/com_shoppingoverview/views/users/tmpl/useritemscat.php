<?php

defined( '_JEXEC' ) or die; // No direct access

$count = 0;
foreach($this->cat as $item){
    $count += $item->count;
}

?>

<div class="row-fluid">
    <ul class="nav-user-favorites-cat">
        <li><a href="<?=JRoute::_('index.php?option=com_shoppingoverview&controller=users&task=useritems&Itemid=101')?>"><?php echo JText::_('COM_SHOPPINGOVERVIEW_ALL'); ?> (<?=$count?>)</a></li>
        <?php foreach($this->cat as $item): ?>
        <li><a href="<?=JRoute::_('index.php?option=com_shoppingoverview&controller=users&task=useritems&id='.$item->id.'&Itemid=101')?>"><?=$item->{'title_'.$this->lang}?> (<?=$item->count?>)</a></li>
        <?php endforeach; ?>
    </ul>
</div>

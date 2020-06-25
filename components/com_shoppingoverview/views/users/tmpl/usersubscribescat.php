<?php

defined( '_JEXEC' ) or die; // No direct access

$countSubcribes = 0;
foreach($this->cat as $item){
    $countSubcribes += $item->countSubscribes;
}

?>

<div class="row-fluid">
    <ul class="nav-user-favorites-cat">
        <li><a href="<?=JRoute::_('index.php?option=com_shoppingoverview&controller=users&task=usersubscribes&Itemid=101')?>"><?php echo JText::_('COM_SHOPPINGOVERVIEW_ALL'); ?> (<?=$countSubcribes?>)</a></li>
        <?php foreach($this->cat as $item): ?>
        <li><a href="<?=JRoute::_('index.php?option=com_shoppingoverview&controller=users&task=usersubscribes&id='.$item->id.'&Itemid=101')?>"><?=$item->{'title_'.$this->lang}?> (<?=$item->countSubscribes?>)</a></li>
        <?php endforeach; ?>
    </ul>
</div>

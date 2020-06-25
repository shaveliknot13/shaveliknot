<?php

defined( '_JEXEC' ) or die; // No direct access


?>



<div class="shoppingoverview-page-search">

    <h1><?php echo JText::_('COM_SHOPPINGOVERVIEW_SEARCH'); ?></h1>
    <form method="post" action="<?php echo JRoute::_( 'index.php?option=com_shoppingoverview&controller=search&Itemid=101'); ?>">
        <div class="shoppingoverview-page-search-input">
            <input autocomplete="off" name="search" type="text" placeholder="&#xF002; <?php echo JText::_('COM_SHOPPINGOVERVIEW_TEXT_62'); ?>">
            <div class="result_search">
            </div>
        </div>
        <div class="shoppingoverview-page-search-checkbox">
            <div><?php echo JText::_('COM_SHOPPINGOVERVIEW_TEXT_67'); ?></div>
            <div class="labelamx active"><?php echo JText::_('COM_SHOPPINGOVERVIEW_TEXT_63');?>
                <input autocomplete="off" checked="checked" type="radio" name="type" value="titles">
                <div><i class="fas fa-check"></i></div>
            </div>

            <div class="labelamx"><?php echo JText::_('COM_SHOPPINGOVERVIEW_TEXT_64');?>
                <input autocomplete="off" type="radio" name="type" value="tags">
                <div><i class="fas fa-check"></i></div>
            </div>

            <div class="labelamx"><?php echo JText::_('COM_SHOPPINGOVERVIEW_TEXT_65');?>
                <input autocomplete="off" type="radio" name="type" value="users">
                <div><i class="fas fa-check"></i></div>
            </div>
        </div>
        <div class="shoppingoverview-page-search-submit">
            <input type="submit" value="<?php echo JText::_('COM_SHOPPINGOVERVIEW_TEXT_66'); ?>">
        </div>
    </form>

</div>

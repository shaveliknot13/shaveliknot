<?php
defined( '_JEXEC' ) or die; // No direct access
?>

<div class="shoppingoverview-page-langs">

    <h1><?php echo JText::_('COM_SHOPPINGOVERVIEW_TEXT_68'); ?></h1>

    <a class="<?php if($this->lang == 'ru'):?>active<?php endif; ?>" href="<?php echo JRoute::_( 'index.php?option=com_shoppingoverview&controller=langs&task=display&lang=ru&Itemid=101'); ?>">Русский</a>
    <a class="<?php if($this->lang == 'en'):?>active<?php endif; ?>" href="<?php echo JRoute::_( 'index.php?option=com_shoppingoverview&controller=langs&task=display&lang=en&Itemid=101'); ?>">Eanglish</a>
    <a class="<?php if($this->lang == 'he'):?>active<?php endif; ?>" href="<?php echo JRoute::_( 'index.php?option=com_shoppingoverview&controller=langs&task=display&lang=he&Itemid=101'); ?>">עברית</a>

</div>
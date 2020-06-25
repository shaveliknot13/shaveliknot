<?php

defined( '_JEXEC' ) or die; // No direct access


JHtml::_('behavior.formvalidator');
JHtml::_('behavior.keepalive');

$this->setting = DopFunction::convertJSNO($this->setting->notifications,false);

?>



<div class="shoppingoverview-page-notifications">

    <h1><?php echo JText::_('COM_SHOPPINGOVERVIEW_TEXT_48'); ?></h1>
    <form method="post" action="/index.php?option=com_shoppingoverview&controller=notifications&task=save">
        <div class="shoppingoverview-page-notifications-checkbox">

        <?php foreach($this->rows as $item): ?>
            <div class="labelamx"><?=$item->{'title_'.$this->lang}?>
                <input  autocomplete="off" type="radio" <?php if($this->setting->{$item->id} == 1):?>checked="checked"<?php endif; ?> name="jform[<?=$item->id?>]" id="jform_<?=$item->id?>" value="1">
                <div><i class="fas fa-check"></i></div>
            </div>
        <?php endforeach; ?>

        </div>

        <?php echo JHtml::_('form.token'); ?>
        <div class="shoppingoverview-page-search-submit">
            <input type="submit" value="<?php echo JText::_('COM_SHOPPINGOVERVIEW_EDIT_FILD_23'); ?>">
        </div>

    </form>

</div>
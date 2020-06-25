<?php

defined('_JEXEC') or die;

JHtml::_('behavior.formvalidator');
JHtml::_('behavior.keepalive');

?>

<form class="form-validate form-horizontal" name="editForm" method="post" action="/index.php?option=com_shoppingoverview">


    <h1 class="add-ask-h1"><?php echo JText::_('COM_SHOPPINGOVERVIEW_TEXT_54'); ?></h1>

    <div style="margin: 20px 0px">
        <?=$this->modelAvertisings->advertisings("asks");?>
    </div>


    <div class="add-ask">
        <div><?=$this->form->getLabel('link', 'myFieldset')?></div>
        <div><?=$this->form->getInput('link','myFieldset', $this->row->link)?></div>
        <div><?=$this->form->getLabel('text', 'myFieldset')?></div>
        <div><?=$this->form->getInput('text','myFieldset', $this->row->text)?></div>
        <input type="hidden" name="controller" value="asks" />
        <input type="hidden" name="task" value="save" />
        <?php echo JHtml::_('form.token'); ?>
        <input onclick="form.submit();" type="button" value="<?php echo JText::_('COM_SHOPPINGOVERVIEW_TEXT_52'); ?>">
    </div>
</form>

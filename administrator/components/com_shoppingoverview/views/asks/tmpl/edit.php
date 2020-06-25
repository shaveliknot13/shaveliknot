<?php

defined('_JEXEC') or die;

JHtml::_('behavior.formvalidator');
JHtml::_('behavior.keepalive');

ShoppingoverviewHelper::setDocument();

?>

<form class="form-validate form-horizontal" id="adminForm" name="adminForm" method="post" action="/administrator/index.php?option=com_shoppingoverview&controller=asks">
    <fieldset class="adminform">
        <div class="control-group">
            <div class="control-label">
                <?=$this->form->getLabel('user_id', 'myFieldset')?>
            </div>
            <div class="controls">
                <?=$this->form->getInput('user_id','myFieldset', $this->row->user_id)?>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">
                Имя
            </div>
            <div class="controls">
                <?=JFactory::getUser($this->row->user_id)->username?>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">
                Емайл
            </div>
            <div class="controls">
                <?=JFactory::getUser($this->row->user_id)->email?>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">
                <?=$this->form->getLabel('link', 'myFieldset')?>
            </div>
            <div class="controls">
                <?=$this->form->getInput('link','myFieldset', $this->row->link)?>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">
                <?=$this->form->getLabel('text', 'myFieldset')?>
            </div>
            <div class="controls">
                <?=$this->form->getInput('text','myFieldset', $this->row->text)?>
            </div>
        </div>
    </fieldset>
    <input type="hidden" name="jform[myFieldset][id]" value="<?=$this->row->id?>" />

    <input type="hidden" name="task" value="" />
    <?php echo JHtml::_('form.token'); ?>
</form>

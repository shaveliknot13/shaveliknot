<?php

defined('_JEXEC') or die;

JHtml::_('behavior.formvalidator');
JHtml::_('behavior.keepalive');

?>

<form class="form-validate form-horizontal" id="adminForm" name="adminForm" method="post" action="/administrator/index.php?option=com_shoppingoverview&controller=privileges">
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
                <?=$this->form->getLabel('privilege','myFieldset')?>
            </div>
            <div class="controls">
                <?=$this->form->getInput('privilege','myFieldset', $this->row->privilege)?>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">
                <?=$this->form->getLabel('published','myFieldset')?>
            </div>
            <div class="controls">
                <?=$this->form->getInput('published','myFieldset', $this->row->published)?>
            </div>
        </div>
    </fieldset>
    <input type="hidden" name="jform[myFieldset][id]" value="<?=$this->row->id?>" />

    <input type="hidden" name="task" value="" />
    <?php echo JHtml::_('form.token'); ?>
</form>

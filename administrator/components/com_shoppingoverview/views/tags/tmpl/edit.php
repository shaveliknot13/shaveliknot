<?php

defined('_JEXEC') or die;

JHtml::_('behavior.formvalidator');
JHtml::_('behavior.keepalive');

?>

<form class="form-validate form-horizontal" id="adminForm" name="adminForm" method="post" action="/administrator/index.php?option=com_shoppingoverview&controller=tags">
    <fieldset class="adminform">
        <div class="control-group">
            <div class="control-label">
                <?=$this->form->getLabel('title', 'myFieldset')?>
            </div>
            <div class="controls">
                <?=$this->form->getInput('title','myFieldset', $this->row->title)?>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">
                <?=$this->form->getLabel('title_ru', 'myFieldset')?>
            </div>
            <div class="controls">
                <?=$this->form->getInput('title_ru','myFieldset', $this->row->title_ru)?>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">
                <?=$this->form->getLabel('title_en', 'myFieldset')?>
            </div>
            <div class="controls">
                <?=$this->form->getInput('title_en','myFieldset', $this->row->title_en)?>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">
                <?=$this->form->getLabel('title_he', 'myFieldset')?>
            </div>
            <div class="controls">
                <?=$this->form->getInput('title_he','myFieldset', $this->row->title_he)?>
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

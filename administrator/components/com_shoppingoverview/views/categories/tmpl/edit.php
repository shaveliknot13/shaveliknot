<?php

defined('_JEXEC') or die;

JHtml::_('behavior.formvalidator');
JHtml::_('behavior.keepalive');

ShoppingoverviewHelper::setDocument();

?>

<form class="form-validate form-horizontal" id="adminForm" name="adminForm" method="post" action="/administrator/index.php?option=com_shoppingoverview&controller=categories">
    <fieldset class="adminform">
        <div class="control-group">
            <div class="control-label">
                <?=$this->form->getLabel('mini_title_ru', 'myFieldset')?>
            </div>
            <div class="controls">
                <?=$this->form->getInput('mini_title_ru','myFieldset', $this->row->mini_title_ru)?>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">
                <?=$this->form->getLabel('mini_title_en', 'myFieldset')?>
            </div>
            <div class="controls">
                <?=$this->form->getInput('mini_title_en','myFieldset', $this->row->mini_title_en)?>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">
                <?=$this->form->getLabel('mini_title_he', 'myFieldset')?>
            </div>
            <div class="controls">
                <?=$this->form->getInput('mini_title_he','myFieldset', $this->row->mini_title_he)?>
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
            <div class="btn btn-small button-arhw">Перевести заголовки</div>
        </div>
        <div class="control-group">
            <div class="control-label">
                <?=$this->form->getLabel('alias','myFieldset')?>
            </div>
            <div class="controls">
                <?=$this->form->getInput('alias','myFieldset', $this->row->alias)?>
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
        <div class="control-group">
            <div class="control-label">
                <?=$this->form->getLabel('icon','myFieldset')?>
            </div>
            <div class="controls">
                <?=$this->form->getInput('icon','myFieldset', $this->row->icon)?>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">
                <?=$this->form->getLabel('text','myFieldset')?>
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

<?php

defined('_JEXEC') or die;

JHtml::_('behavior.formvalidator');
JHtml::_('behavior.keepalive');

?>

<form class="form-validate form-horizontal" id="adminForm" name="adminForm" method="post" action="/administrator/index.php?option=com_shoppingoverview&controller=advertisings">
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
                <?=$this->form->getLabel('content', 'myFieldset')?>
            </div>
            <div class="controls">
                <?=$this->form->getInput('content','myFieldset', $this->row->content)?>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">
                <?=$this->form->getLabel('type_js_php', 'myFieldset')?>
            </div>
            <div class="controls">
                <?=$this->form->getInput('type_js_php','myFieldset', $this->row->type_js_php)?>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">
                <?=$this->form->getLabel('type_mod_com', 'myFieldset')?>
            </div>
            <div class="controls">
                <?=$this->form->getInput('type_mod_com','myFieldset', $this->row->type_mod_com)?>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">
                <?=$this->form->getLabel('position', 'myFieldset')?>
            </div>
            <div class="controls">
                <?=$this->form->getInput('position','myFieldset', $this->row->position)?>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">
                <?=$this->form->getLabel('mod_id', 'myFieldset')?>
            </div>
            <div class="controls">
                <?=$this->form->getInput('mod_id','myFieldset', $this->row->mod_id)?>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">
                <?=$this->form->getLabel('hits_constraints', 'myFieldset')?>
            </div>
            <div class="controls">
                <?=$this->form->getInput('hits_constraints','myFieldset', $this->row->hits_constraints)?>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">
                <?=$this->form->getLabel('hits', 'myFieldset')?>
            </div>
            <div class="controls">
                <?=$this->form->getInput('hits','myFieldset', $this->row->hits)?>
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

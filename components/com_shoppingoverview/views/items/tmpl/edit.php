<?php

defined('_JEXEC') or die;

JHtml::_('behavior.formvalidator');
JHtml::_('behavior.keepalive');

?>



<form class="form-validate form-horizontal" id="editForm" name="editForm" method="post" action="/index.php?option=com_shoppingoverview">


    <div class="row-fluid panel-my-add">
        <div class="span12">
            <?php echo JText::_('COM_SHOPPINGOVERVIEW_EDIT_FILD_30'); ?>
        </div>
    </div>
    <br/>
    <fieldset>
        <div class="standart-bg">
            <div class="control-group">
                <div class="control-label">
                    <?=$this->form->getLabel('product', 'myFieldset')?>
                </div>
                <div class="controls">
                    <?=$this->form->getInput('product','myFieldset', $this->row->product)?>
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
                </div>
                <div class="controls">
                    <div class="button-standard-blue button-arhw"> <i class="fal fa-globe"></i> <?php echo JText::_('COM_SHOPPINGOVERVIEW_EDIT_FILD_18'); ?></div>
                </div>
            </div>
            <div class="control-group">
                <div class="control-label">
                    <?=$this->form->getLabel('cat_id','myFieldset')?>
                </div>
                <div class="controls">
                    <?=$this->form->getInput('cat_id','myFieldset', $this->row->cat_id)?>
                </div>
            </div>
            <div class="control-group">
                <div class="control-label">
                    <?=$this->form->getLabel('delivery_id','myFieldset')?>
                </div>
                <div class="controls">
                    <?=$this->form->getInput('delivery_id','myFieldset', $this->row->delivery_id)?>
                </div>
            </div>

            <div class="control-group">
                <div class="control-label">
                    <?=$this->form->getLabel('price','myFieldset')?>
                </div>
                <div class="controls">
                    <?=$this->form->getInput('price','myFieldset', $this->row->price)?>
                </div>
            </div>

            <div class="control-group">
                <div class="control-label">
                    <?php echo JText::_('COM_SHOPPINGOVERVIEW_EDIT_FILD_16'); ?>
                </div>
                <div class="controls">
                    <?php require(__DIR__.'/tags.php') ?>
                </div>
            </div>

            <div class="control-group">
                <div class="control-label">
                    <?=$this->form->getLabel('shop_name','myFieldset')?>
                </div>
                <div class="controls">
                    <?=$this->form->getInput('shop_name','myFieldset', $this->row->shop_name)?>
                </div>
            </div>

            <div class="control-group">
                <div class="control-label">
                    <?=$this->form->getLabel('shop','myFieldset')?>
                </div>
                <div class="controls">
                    <?=$this->form->getInput('shop','myFieldset', $this->row->shop)?>
                </div>
            </div>
            <div class="control-group">
                <div class="control-label">
                    <?=$this->form->getLabel('youtube','myFieldset')?>
                </div>
                <div class="controls">
                    <?=$this->form->getInput('youtube','myFieldset', $this->row->youtube)?>
                </div>
            </div>
            <div class="control-group">
                <div class="control-label">
                    <?=$this->form->getLabel('youtube_begin_end','myFieldset')?>
                </div>
                <div class="controls">
                    <?=$this->form->getInput('youtube_begin_end','myFieldset', $this->row->youtube_begin_end)?>
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
        </div>
        <?=$this->modelAvertisings->advertisings("edit");?>

        <div class="row-fluid panel-my-add">
            <div class="span12">
                <?php echo JText::_('COM_SHOPPINGOVERVIEW_EDIT_FILD_31'); ?>
                <div class="shoppingoverview-page-items-tabs-original">
                    <?php echo JText::_('COM_SHOPPINGOVERVIEW_EDIT_FILD_32'); ?>:
                    <div class="shoppingoverview-page-items-tabs <?php if($this->lang == 'ru'):?>active<?php endif; ?>" date-lang="ru"><?php echo JText::_('COM_SHOPPINGOVERVIEW_EDIT_FILD_19'); ?></div>
                    <div class="shoppingoverview-page-items-tabs <?php if($this->lang == 'en'):?>active<?php endif; ?>" date-lang="en"><?php echo JText::_('COM_SHOPPINGOVERVIEW_EDIT_FILD_20'); ?></div>
                    <div class="shoppingoverview-page-items-tabs <?php if($this->lang == 'he'):?>active<?php endif; ?>" date-lang="he"><?php echo JText::_('COM_SHOPPINGOVERVIEW_EDIT_FILD_21'); ?></div>
                </div>
            </div>
        </div>
        <br/>

        <div class="standart-bg">


            <div class="control-group shoppingoverview-page-item-ru-hwp">
                <div class="control-label">
                    <?=$this->form->getLabel('hwp_text_ru','myFieldset')?>
                </div>
                <div class="controls">
                    <?=$this->form->getInput('hwp_text_ru','myFieldset', $this->row->hwp_text_ru)?>
                </div>
            </div>
            <div class="control-group shoppingoverview-page-item-ru-mini">
                <div class="control-label">
                    <?=$this->form->getLabel('mini_text_ru','myFieldset')?>
                </div>
                <div class="controls">
                    <?=$this->form->getInput('mini_text_ru','myFieldset', $this->row->mini_text_ru)?>
                </div>
            </div>
            <div class="control-group shoppingoverview-page-item-ru">
                <div class="control-label">
                    <?=$this->form->getLabel('text_ru','myFieldset')?>
                </div>
                <div class="controls">
                    <?php
                    $langBlock = 'ru';
                    $textAdd = $this->row->text_ru;
                    ?>
                    <?php require(__DIR__.'/itemlist.php') ?>
                </div>
            </div>


            <div class="control-group shoppingoverview-page-item-en-hwp">
                <div class="control-label">
                    <?=$this->form->getLabel('hwp_text_en','myFieldset')?>
                </div>
                <div class="controls">
                    <?=$this->form->getInput('hwp_text_en','myFieldset', $this->row->hwp_text_en)?>
                </div>
            </div>
            <div class="control-group shoppingoverview-page-item-en-mini">
                <div class="control-label">
                    <?=$this->form->getLabel('mini_text_en','myFieldset')?>
                </div>
                <div class="controls">
                    <?=$this->form->getInput('mini_text_en','myFieldset', $this->row->mini_text_en)?>
                </div>
            </div>
            <div class="control-group shoppingoverview-page-item-en">
                <div class="control-label">
                    <?=$this->form->getLabel('text_en','myFieldset')?>
                </div>
                <div class="controls">
                    <?php
                    $langBlock = 'en';
                    $textAdd = $this->row->text_en;
                    ?>
                    <?php require(__DIR__.'/itemlist.php') ?>
                </div>
            </div>


            <div class="control-group shoppingoverview-page-item-he-hwp">
                <div class="control-label">
                    <?=$this->form->getLabel('hwp_text_he','myFieldset')?>
                </div>
                <div class="controls">
                    <?=$this->form->getInput('hwp_text_he','myFieldset', $this->row->hwp_text_he)?>
                </div>
            </div>
            <div class="control-group shoppingoverview-page-item-he-mini">
                <div class="control-label">
                    <?=$this->form->getLabel('mini_text_he','myFieldset')?>
                </div>
                <div class="controls">
                    <?=$this->form->getInput('mini_text_he','myFieldset', $this->row->mini_text_he)?>
                </div>
            </div>
            <div class="control-group shoppingoverview-page-item-he">
                <div class="control-label">
                    <?=$this->form->getLabel('text_he','myFieldset')?>
                </div>
                <div class="controls">
                    <?php
                    $langBlock = 'he';
                    $textAdd = $this->row->text_he;
                    ?>
                    <?php require(__DIR__.'/itemlist.php') ?>
                </div>
            </div>


            <div class="control-group">
                <div class="control-label">
                </div>
                <div class="controls">
                    <div class="button-standard-blue button-arhw2"> <i class="fal fa-globe"></i> <?php echo JText::_('COM_SHOPPINGOVERVIEW_EDIT_FILD_22'); ?></div>
                </div>
            </div>
        </div>
    </fieldset>
    <input type="hidden" name="jform[myFieldset][id]" value="<?=$this->row->id?>" />

    <input type="hidden" name="task" value="save" />
    <?php echo JHtml::_('form.token'); ?>

    <button style="" class="button-standard-green" onclick="form.submit();" type="button">
    <i class="fal fa-save"></i> <?php echo JText::_('COM_SHOPPINGOVERVIEW_EDIT_FILD_23'); ?>
    </button>

</form>

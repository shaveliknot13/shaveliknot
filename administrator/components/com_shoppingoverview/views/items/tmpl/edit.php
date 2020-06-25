<?php

defined('_JEXEC') or die;

JHtml::_('behavior.formvalidator');
JHtml::_('behavior.keepalive');

ShoppingoverviewHelper::setDocument();

?>
<form class="form-validate form-horizontal" id="adminForm" name="adminForm" method="post" action="/administrator/index.php?option=com_shoppingoverview&controller=items">
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
                <?=$this->form->getLabel('product', 'myFieldset')?>
            </div>
            <div class="controls">
                <?=$this->form->getInput('product','myFieldset', $this->row->product)?>
            </div>
        </div>

        <div class="control-group">
            <div class="control-label">
                Теги
            </div>
            <div class="controls">
                <?php require(__DIR__.'/tags.php') ?>
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
                <?=$this->form->getLabel('trash','myFieldset')?>
            </div>
            <div class="controls">
                <?=$this->form->getInput('trash','myFieldset', $this->row->trash)?>
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
                <?=$this->form->getLabel('alias_ru','myFieldset')?>
            </div>
            <div class="controls">
                <?=$this->form->getInput('alias_ru','myFieldset', $this->row->alias_ru)?>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">
                <?=$this->form->getLabel('alias_en','myFieldset')?>
            </div>
            <div class="controls">
                <?=$this->form->getInput('alias_en','myFieldset', $this->row->alias_en)?>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">
                <?=$this->form->getLabel('alias_he','myFieldset')?>
            </div>
            <div class="controls">
                <?=$this->form->getInput('alias_he','myFieldset', $this->row->alias_he)?>
            </div>
        </div>

        <div class="control-group">
            <div class="control-label">
                <?=$this->form->getLabel('mini_text_ru', 'myFieldset')?>
            </div>
            <div class="controls">
                <?=$this->form->getInput('mini_text_ru','myFieldset', $this->row->mini_text_ru)?>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">
                <?=$this->form->getLabel('mini_text_en', 'myFieldset')?>
            </div>
            <div class="controls">
                <?=$this->form->getInput('mini_text_en','myFieldset', $this->row->mini_text_en)?>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">
                <?=$this->form->getLabel('mini_text_he', 'myFieldset')?>
            </div>
            <div class="controls">
                <?=$this->form->getInput('mini_text_he','myFieldset', $this->row->mini_text_he)?>
            </div>
        </div>

        <div class="control-group">
            <div class="control-label">
                <?=$this->form->getLabel('hwp_text_ru', 'myFieldset')?>
            </div>
            <div class="controls">
                <?=$this->form->getInput('hwp_text_ru','myFieldset', $this->row->hwp_text_ru)?>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">
                <?=$this->form->getLabel('hwp_text_en', 'myFieldset')?>
            </div>
            <div class="controls">
                <?=$this->form->getInput('hwp_text_en','myFieldset', $this->row->hwp_text_en)?>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label">
                <?=$this->form->getLabel('hwp_text_he', 'myFieldset')?>
            </div>
            <div class="controls">
                <?=$this->form->getInput('hwp_text_he','myFieldset', $this->row->hwp_text_he)?>
            </div>
        </div>

        <div class="editItemsInLine">

            <div class="editItemsInLineItem">
                <div class="control-group">
                    <div class="controls">
                        <?=$this->form->getLabel('text_ru','myFieldset')?>
                        <br/>
                        <?php
                        $langBlock = 'ru';
                        $textAdd = $this->row->text_ru;
                        ?>
                        <?php require(__DIR__.'/itemlist.php') ?>
                    </div>
                </div>
            </div>

            <div class="editItemsInLineItem">
                <div class="control-group">
                    <div class="controls">
                        <?=$this->form->getLabel('text_en','myFieldset')?>
                        <br/>
                        <?php
                        $langBlock = 'en';
                        $textAdd = $this->row->text_en;
                        ?>
                        <?php require(__DIR__.'/itemlist.php') ?>
                    </div>
                </div>
            </div>

            <div class="editItemsInLineItem">
                <div class="control-group">
                    <div class="controls">
                        <?=$this->form->getLabel('text_he','myFieldset')?>
                        <br/>
                        <?php
                        $langBlock = 'he';
                        $textAdd = $this->row->text_he;
                        ?>
                        <?php require(__DIR__.'/itemlist.php') ?>
                    </div>
                </div>
            </div>

        </div>

        <div class="control-group">
            <div class="btn btn-small button-arhw2">Перевести текста</div>
        </div>
    </fieldset>
    <input type="hidden" name="jform[myFieldset][id]" value="<?=$this->row->id?>" />

    <input type="hidden" name="task" value="" />
    <?php echo JHtml::_('form.token'); ?>
</form>

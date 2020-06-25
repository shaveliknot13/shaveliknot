<?php

defined( '_JEXEC' ) or die; // No direct access

?>
<div class="row-fluid">


    <div class="shoppingoverview-page-items span12">

        <div class="row-fluid panel-my-cat">
            <div class="span12">
                <span class="panel-my-cat-left">
                    <i class="fal fa-bars"></i>
                    <?=$this->nameCat->{'title_'.$this->lang}?>
                </span>
                <span data-filterSo="popular" class="panel-my-cat-right<?php if($this->massArrFilter->filterSoOrdering == 'popular'):?> active<?php endif; ?>"><?php echo JText::_('COM_SHOPPINGOVERVIEW_TEXT_30'); ?></span>
                <span data-filterSo="likes" class="panel-my-cat-right<?php if($this->massArrFilter->filterSoOrdering == 'likes'):?> active<?php endif; ?>"><?php echo JText::_('COM_SHOPPINGOVERVIEW_TEXT_31'); ?></span>
                <span data-filterSo="discussed" class="panel-my-cat-right<?php if($this->massArrFilter->filterSoOrdering == 'discussed'):?> active<?php endif; ?>"><?php echo JText::_('COM_SHOPPINGOVERVIEW_TEXT_32'); ?></span>
                <span data-filterSo="latest" class="panel-my-cat-right<?php if($this->massArrFilter->filterSoOrdering == 'latest'):?> active<?php endif; ?>"><?php echo JText::_('COM_SHOPPINGOVERVIEW_TEXT_33'); ?></span>
            </div>
        </div>

        <?=$this->modelAvertisings->advertisings("categories");?>

        <div class="ajaxSiteCategories">
            <?php $i=1; foreach ( $this->rows as $item ): ?>

                <?php
                // подготавливаем модели
                $modelFavorites = $this->modelFavorites;
                $modelImages = $this->modelImages;
                $modelTags = $this->modelTags;
                $modelAvertisings = $this->modelAvertisings;
                $lang = $this->lang;
                // Формируем шаблон
                $item = $item;
                ?>
                <?=$modelAvertisings->advertisingsItem();?>

            <div class="shoppingoverview-page-item">
                <div class="shoppingoverview-page-item-original">
                    <?php require(JPATH_SITE.'/components/com_shoppingoverview/views/items/tmpl/item.php');?>
                </div>
            </div>
            <?php $i++; endforeach; ?>
        </div>

        <button type="button" data-cat_alias="<?=$this->nameCat->alias?>" data-count="10" id="ajaxSiteCategories" class="button-block-success-xs"><?php echo JText::_('COM_SHOPPINGOVERVIEW_SHOW_MORE'); ?></button>
    </div>
</div>
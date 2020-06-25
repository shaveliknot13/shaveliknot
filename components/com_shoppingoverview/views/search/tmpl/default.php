<?php

defined( '_JEXEC' ) or die; // No direct access


?>



<div class="shoppingoverview-page-items">

    <h1><?php echo JText::_('COM_SHOPPINGOVERVIEW_SEARCH_1'); ?>: '<strong><?=$this->search?></strong>' <?php echo JText::_('COM_SHOPPINGOVERVIEW_SEARCH_2'); ?> <?=$this->count?></h1>
    <?=$this->modelAvertisings->advertisings("search");?>
    <div class="ajaxSiteSearch">
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

    <button type="button" data-search="<?=$this->search?>" data-type="<?=$this->type?>" data-count="10" id="ajaxSiteSearch" class="button-block-success-xs"><?php echo JText::_('COM_SHOPPINGOVERVIEW_SHOW_MORE'); ?></button>
</div>

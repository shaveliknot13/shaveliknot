<?php

defined( '_JEXEC' ) or die; // No direct access


?>

<div class="shoppingoverview-page-items">

    <h1><?php echo JText::_('COM_SHOPPINGOVERVIEW_WATCH_HISTORY'); ?></h1>

    <?php require(JPATH_SITE.'/components/com_shoppingoverview/views/users/tmpl/userhitscat.php');?>

    <?=$this->modelAvertisings->advertisings("userhits");?>
    <div class="ajaxSiteUserhits">
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
    <button type="button"  data-cat-id="<?=$this->cat_id?>" data-count="10" id="ajaxSiteUserhits" class="button-block-success-xs"><?php echo JText::_('COM_SHOPPINGOVERVIEW_SHOW_MORE'); ?></button>
</div>

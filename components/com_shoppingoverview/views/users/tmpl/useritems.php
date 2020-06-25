<?php

defined( '_JEXEC' ) or die; // No direct access


?>

<div class="shoppingoverview-page-items">

    <h1><?php echo JText::_('COM_SHOPPINGOVERVIEW_MY_REVIEWS'); ?></h1>

    <?php require(JPATH_SITE.'/components/com_shoppingoverview/views/users/tmpl/useritemscat.php');?>

    <?=$this->modelAvertisings->advertisings("useritems");?>

    <div class="ajaxSiteUseritems">
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
                <div class="function-admin">
                    <a class="edit-amx" href="<?php echo JRoute::_( 'index.php?option=com_shoppingoverview&task=edit&Itemid=101&id='.$item->id ); ?>"> <i class="fal fa-edit"></i> <?php echo JText::_('COM_SHOPPINGOVERVIEW_EDIT'); ?></a>
                    <a class="delete-amx" onclick="return confirm('<?php echo JText::_('COM_SHOPPINGOVERVIEW_DELETE_VOPROS'); ?>')" href="<?php echo JRoute::_( 'index.php?option=com_shoppingoverview&task=delete&Itemid=101&id='.$item->id ); ?>"> <i class="fal fa-trash-alt"></i> <?php echo JText::_('COM_SHOPPINGOVERVIEW_DELETE'); ?></a>
                </div>
                <?php require(JPATH_SITE.'/components/com_shoppingoverview/views/items/tmpl/item.php');?>
            </div>

        </div>
        <?php $i++; endforeach; ?>
    </div>
    <button type="button"  data-cat-id="<?=$this->cat_id?>" data-count="10" id="ajaxSiteUseritems" class="button-block-success-xs"><?php echo JText::_('COM_SHOPPINGOVERVIEW_SHOW_MORE'); ?></button>
</div>

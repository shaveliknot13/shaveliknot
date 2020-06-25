<?php

defined( '_JEXEC' ) or die; // No direct access


?>

<div class="shoppingoverview-page-items">

    <h1><?php echo JText::_('COM_SHOPPINGOVERVIEW_MY_SUBSCRIPTIONS'); ?></h1>

    <?php require(JPATH_SITE.'/components/com_shoppingoverview/views/users/tmpl/usersubscribescat.php');?>

    <?=$this->modelAvertisings->advertisings("usersubscribes");?>

    <div class="ajaxSiteUsersubscribes">
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
                        <a class="delete-amx" onclick="return confirm('<?php echo JText::_('COM_SHOPPINGOVERVIEW_UNSUBSCRIBE_VOPROS'); ?>')" href="<?php echo JRoute::_( 'index.php?option=com_shoppingoverview&controller=users&task=deletesubscribe&Itemid=101&id='.$item->user_id ); ?>"> <i class="far fa-minus-circle"></i> <?php echo JText::_('COM_SHOPPINGOVERVIEW_UNSUBSCRIBE'); ?></a>
                    </div>
                    <?php require(JPATH_SITE.'/components/com_shoppingoverview/views/items/tmpl/item.php');?>
                </div>

            </div>

        <?php $i++; endforeach; ?>
    </div>
    <button type="button"  data-cat-id="<?=$this->cat_id?>" data-count="10" id="ajaxSiteUsersubscribes" class="button-block-success-xs"><?php echo JText::_('COM_SHOPPINGOVERVIEW_SHOW_MORE'); ?></button>
</div>

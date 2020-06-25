<?php
// No direct access
defined('_JEXEC') or die;

?>
<div class="mod_shoppingoverview_product">

    <div class="name-modul-head-mobile"><i class="fal fa-ballot"></i> <?php echo JText::_('MOD_SHOPPINGOVERVIEW_PRODUCT_TEXT_1'); ?></div>

    <div class="titles name-modul-body-mobile" data-count="<?=$count?>" data-cat_alias="<?=$cat_alias?>">
    <?php
        foreach($viewDisplay as $itemTitle):
    ?>
        <div data-filter="<?=$itemTitle?>" class="title <?php if($itemTitle == $viewDefault):?>active<?php endif; ?>">
            <?=$viewDisplayArr[$itemTitle]?>
        </div>
    <?php
        endforeach;
    ?>
    </div>
    <div class="content name-modul-body-mobile">
        <?=$items?>
    </div>
</div>
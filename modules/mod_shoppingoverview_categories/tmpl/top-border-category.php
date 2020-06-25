<?php
// No direct access
defined('_JEXEC') or die; ?>

<div class="top-border-category-general">
    <div class="top-border-category-base">
        <i class="fal fa-bars"></i>
        <?php echo JText::_('MOD_SHOPPINGOVERVIEW_CATEGORIES_CATEGORIES'); ?>

    </div>
    <div class="top-border-category-list">
        <ul>
            <?php foreach($row as $item): ?>

                <li class="<?php if($cat_alias == $item->alias){ ?>active<?php } ?>" >
                    <a href="<?php echo JRoute::_( 'index.php?option=com_shoppingoverview&cat_alias='.$item->alias.'&Itemid=101' ); ?>">
                        <?=$item->icon;?>
                        <?=$item->{'title_'.$lang}?>
                    </a>
                </li>

            <?php endforeach; ?>
        </ul>
    </div>
</div>
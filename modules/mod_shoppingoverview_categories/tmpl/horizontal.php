<?php
// No direct access
defined('_JEXEC') or die;
?>
<?php $width = count($row) * 92;?>
<div class="mod_shoppingoverview_categories owl-carousel owl-theme">

            <a href="/">
                <i class="fal fa-home-heart"></i>
                <?php echo JText::_('COM_SHOPPINGOVERVIEW_HOME'); ?>
            </a>

        <?php foreach($row as $item): ?>

                <a  class="<?php if($cat_alias == $item->alias){ ?>active<?php } ?>"  href="<?php echo JRoute::_( 'index.php?option=com_shoppingoverview&cat_alias='.$item->alias.'&Itemid=101' ); ?>">
                    <?=$item->icon;?>
                    <?=$item->{'mini_title_'.$lang}?>
                </a>

        <?php endforeach; ?>

</div>


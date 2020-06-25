<?php
// No direct access
defined('_JEXEC') or die;
?>
<div class="mod_shoppingoverview_navigational">

    <div class="name-modul-head-mobile"><i class="fas fa-sort-alpha-down"></i> <?php echo JText::_('MOD_SHOPPINGOVERVIEW_NAVIGATIONAL_TEXT_1'); ?></div>

    <div class="name-modul-body-mobile" style="padding: 10px">

        <div class="block-title name-modul-body-mobile hide-mobile"><?php echo JText::_('MOD_SHOPPINGOVERVIEW_NAVIGATIONAL_TEXT_1'); ?></div>

        <div class="date_block name-modul-body-mobile">

            <select name="mod_shoppingoverview_navigational_date">
                <option value="7"><?php echo JText::_('MOD_SHOPPINGOVERVIEW_NAVIGATIONAL_7_DAYS'); ?></option>
                <option value="30"><?php echo JText::_('MOD_SHOPPINGOVERVIEW_NAVIGATIONAL_30_DAYS'); ?></option>
                <option value="60"><?php echo JText::_('MOD_SHOPPINGOVERVIEW_NAVIGATIONAL_60_DAYS'); ?></option>
                <option value="90"><?php echo JText::_('MOD_SHOPPINGOVERVIEW_NAVIGATIONAL_90_DAYS'); ?></option>
            </select>
        </div>
        <div class="select_block name-modul-body-mobile">
            <select>
                <option value=""><?php echo JText::_('MOD_SHOPPINGOVERVIEW_NAVIGATIONAL_ALL'); ?></option>
                <?php
                foreach($categories as $item):
                    ?>
                    <option value="<?=$item->id?>">
                        <?=$item->{'title_'.$lang}?>
                    </option>
                <?php
                endforeach;
                ?>
            </select>
        </div>
        <div class="list_block name-modul-body-mobile">
            <?=$items?>
        </div>
    </div>
</div>
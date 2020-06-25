<?php
// No direct access
defined('_JEXEC') or die;

?>

<div class="name-modul-head-mobile"><i class="far fa-filter"></i> <?php echo JText::_('MOD_SHOPPINGOVERVIEW_PUBLICATIONS_CATEGORIES_TEXT_1'); ?></div>

<div class="globalfilterCat name-modul-body-mobile">

    <?php if(!empty($categories)): ?>
    <ul class="nav nav-list">
        <li class="noClickCat"><a href="/"><i class="fal fa-home-heart"></i> <?php echo JText::_('COM_SHOPPINGOVERVIEW_HOME'); ?></a></li>
        <li class="nav-header" style="padding-top:15px!important;"><?php echo JText::_('MOD_SHOPPINGOVERVIEW_PUBLICATIONS_FILER_CATEGORIES'); ?>:</li>
        <li data-filterSo="<?=$categories->id?>" class="active noClickCat"><a><?=$categories->icon?> <?=$categories->{'title_'.$lang}?> <i class="fas fa-check-square"></i></a></li>
    </ul>
    <?php endif; ?>

    <ul class="nav nav-list filterSoPrice">
        <li class="nav-header"><?php echo JText::_('MOD_SHOPPINGOVERVIEW_PUBLICATIONS_CATEGORIES_PRICES'); ?>:</li>
        <li class="noClickCat">
            <input type="text" class="input-text-1" value="<?php if(!empty($massArrFilter->filterSoPrice1)): ?><?=$massArrFilter->filterSoPrice1?><?php endif; ?>">
            &nbsp;-&nbsp;
            <input type="text" class="input-text-2" value="<?php if(!empty($massArrFilter->filterSoPrice2)): ?><?=$massArrFilter->filterSoPrice2?><?php endif; ?>"> $
            <input class="input-button" type="button" value="Ok">
        </li>
    </ul>
    <ul class="nav nav-list filterSoDelivery">
        <li class="nav-header"><?php echo JText::_('MOD_SHOPPINGOVERVIEW_PUBLICATIONS_CATEGORIES_DELIVERY'); ?>:</li>
        <li data-filterSo="0" <?php if($massArrFilter->filterSoDelivery == '0'):?>class="active"<?php endif; ?>><a><?php echo JText::_('MOD_SHOPPINGOVERVIEW_PUBLICATIONS_CATEGORIES_ALL'); ?></a></li>
        <li data-filterSo="1" <?php if($massArrFilter->filterSoDelivery == '1'):?>class="active"<?php endif; ?>><a><?php echo JText::_('MOD_SHOPPINGOVERVIEW_PUBLICATIONS_CATEGORIES_PAID'); ?></a></li>
        <li data-filterSo="2" <?php if($massArrFilter->filterSoDelivery == '2'):?>class="active"<?php endif; ?>><a><?php echo JText::_('MOD_SHOPPINGOVERVIEW_PUBLICATIONS_CATEGORIES_FREE'); ?></a></li>
    </ul>
    <ul class="nav nav-list filterSoVideo">
        <li data-filterSo="<?=$massArrFilter->filterSoVideo?>" class="<?php if($massArrFilter->filterSoVideo == '1'):?>active<?php endif; ?> noClickCat"><a><?php echo JText::_('COM_SHOPPINGOVERVIEW_TEXT_69'); ?> <input type="checkbox"></a></li>
    </ul>
</div>



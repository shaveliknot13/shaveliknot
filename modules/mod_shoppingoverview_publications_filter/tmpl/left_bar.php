<?php
// No direct access
defined('_JEXEC') or die;

$catArr = explode(',', $massArrFilter->filterSoCat);

?>

<div class="name-modul-head-mobile"><i class="far fa-filter"></i> <?php echo JText::_('MOD_SHOPPINGOVERVIEW_PUBLICATIONS_FILER_TEXT_1'); ?></div>

<div class="globalfilterPub name-modul-body-mobile">
    <ul class="nav nav-list filterSoCat">
        <li class="nav-header" ><?php echo JText::_('MOD_SHOPPINGOVERVIEW_PUBLICATIONS_FILER_CATEGORIES'); ?>:</li>
        <li data-filterSo="0" <?php if(in_array(0,$catArr)):?>class="active"<?php endif; ?>><a><i class="fal fa-bars"></i> <?php echo JText::_('MOD_SHOPPINGOVERVIEW_PUBLICATIONS_FILER_ALL'); ?> <i class="fas fa-check-square"></i></a></li>
        <?php foreach($categories as $item): ?>
            <li data-filterSo="<?=$item->id?>" <?php if(in_array($item->id,$catArr)):?>class="active"<?php endif; ?>><a><?=$item->icon?> <?=$item->{'title_'.$lang}?> <i class="fas fa-check-square"></i></a></li>
        <?php endforeach; ?>
    </ul>
    <ul class="nav nav-list filterSoDay">
        <li class="nav-header"><?php echo JText::_('MOD_SHOPPINGOVERVIEW_PUBLICATIONS_FILER_DAYS'); ?>:</li>
        <li data-filterSo="7" <?php if($massArrFilter->filterSoDay == '7'):?>class="active"<?php endif; ?>><a><?php echo JText::_('MOD_SHOPPINGOVERVIEW_PUBLICATIONS_FILER_7DAYS'); ?></a></li>
        <li data-filterSo="30" <?php if($massArrFilter->filterSoDay == '30'):?>class="active"<?php endif; ?>><a><?php echo JText::_('MOD_SHOPPINGOVERVIEW_PUBLICATIONS_FILER_30DAYS'); ?></a></li>
        <li data-filterSo="60" <?php if($massArrFilter->filterSoDay == '60'):?>class="active"<?php endif; ?>><a><?php echo JText::_('MOD_SHOPPINGOVERVIEW_PUBLICATIONS_FILER_60DAYS'); ?></a></li>
        <li data-filterSo="90" <?php if($massArrFilter->filterSoDay == '90'):?>class="active"<?php endif; ?>><a><?php echo JText::_('MOD_SHOPPINGOVERVIEW_PUBLICATIONS_FILER_90DAYS'); ?></a></li>
    </ul>
    <ul class="nav nav-list filterSoPrice">
        <li class="nav-header"><?php echo JText::_('MOD_SHOPPINGOVERVIEW_PUBLICATIONS_FILER_PRICES'); ?>:</li>
        <li class="noClickCat">
            <input type="text" class="input-text-1" value="<?php if(!empty($massArrFilter->filterSoPrice1)): ?><?=$massArrFilter->filterSoPrice1?><?php endif; ?>">
            &nbsp;-&nbsp;
            <input type="text" class="input-text-2" value="<?php if(!empty($massArrFilter->filterSoPrice2)): ?><?=$massArrFilter->filterSoPrice2?><?php endif; ?>"> $
            <input class="input-button" type="button" value="Ok">
        </li>
    </ul>
    <ul class="nav nav-list filterSoDelivery">
        <li class="nav-header"><?php echo JText::_('MOD_SHOPPINGOVERVIEW_PUBLICATIONS_FILER_DELIVERY'); ?>:</li>
        <li data-filterSo="0" <?php if($massArrFilter->filterSoDelivery == '0'):?>class="active"<?php endif; ?>><a><?php echo JText::_('MOD_SHOPPINGOVERVIEW_PUBLICATIONS_FILER_ALL'); ?></a></li>
        <li data-filterSo="1" <?php if($massArrFilter->filterSoDelivery == '1'):?>class="active"<?php endif; ?>><a><?php echo JText::_('MOD_SHOPPINGOVERVIEW_PUBLICATIONS_FILER_PAID'); ?></a></li>
        <li data-filterSo="2" <?php if($massArrFilter->filterSoDelivery == '2'):?>class="active"<?php endif; ?>><a><?php echo JText::_('MOD_SHOPPINGOVERVIEW_PUBLICATIONS_FILER_FREE'); ?></a></li>
    </ul>
    <ul class="nav nav-list filterSoVideo">
        <li data-filterSo="<?=$massArrFilter->filterSoVideo?>" class="<?php if($massArrFilter->filterSoVideo == '1'):?>active<?php endif; ?> noClickCat"><a><?php echo JText::_('COM_SHOPPINGOVERVIEW_TEXT_69'); ?> <input type="checkbox"></a></li>
    </ul>
</div>


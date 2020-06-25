<?php

// No direct access
defined('_JEXEC') or die;
// Include the syndicate functions only once
require_once dirname(dirname(dirname(__FILE__))) . '/components/com_shoppingoverview/helpers/secondaryfunctions.php';
$opacity = DopFunction::getRoutPosition($params);

if($opacity) {
    require_once dirname(dirname(dirname(__FILE__))) . '/components/com_shoppingoverview/helpers/shoppingoverview.php';
    require_once dirname(__FILE__) . '/helper.php';

    $baseUrl = JUri::base();
    $doc = JFactory::getDocument();
    $app = JFactory::getApplication();
    JHtml::_('jquery.framework');
    $doc
        ->addScript($baseUrl . 'components/com_shoppingoverview/assets/js/shoppingoverview.js')
        ->addScript($baseUrl . 'modules/mod_shoppingoverview_advertisings/assets/js/shoppingoverview_advertisings.js')
        ->addStyleSheet($baseUrl . 'components/com_shoppingoverview/assets/css/shoppingoverview.css')
        ->addStyleSheet($baseUrl . 'modules/mod_shoppingoverview_advertisings/assets/css/shoppingoverview_advertisings.css');

    $lang = shoppingoverviewSiteHelper::getPerfixLang($doc->getlanguage());


    $moduleAmx = new ShoppingoverviewModuleModelAdvertisings();

    $result = $moduleAmx->advertisings($module->id);

    require JModuleHelper::getLayoutPath('mod_shoppingoverview_advertisings');
}
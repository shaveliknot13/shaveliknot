<?php

// No direct access
defined('_JEXEC') or die;
// Include the syndicate functions only once
require_once dirname(dirname(dirname(__FILE__))) . '/components/com_shoppingoverview/helpers/secondaryfunctions.php';
$opacity = DopFunction::getRoutPosition($params);

if($opacity) {
    require_once dirname(dirname(dirname(__FILE__))) . '/components/com_shoppingoverview/helpers/shoppingoverview.php';
    require_once dirname(__FILE__) . '/helper.php';

    JText::script('COM_SHOPPINGOVERVIEW_DATA_SENT_INCORRECTLY');

    $baseUrl = JUri::base();
    $doc = JFactory::getDocument();
    JHtml::_('jquery.framework');
    $doc
        ->addScript($baseUrl . 'components/com_shoppingoverview/assets/js/shoppingoverview.js')
        ->addScript($baseUrl . 'components/com_shoppingoverview/assets/js/jquery.imgareaselect.pack.js')
        ->addScript($baseUrl . 'modules/mod_shoppingoverview_navigational/assets/js/shoppingoverview_navigational.js')
        ->addStyleSheet($baseUrl . 'components/com_shoppingoverview/assets/css/shoppingoverview.css')
        ->addStyleSheet($baseUrl . 'modules/mod_shoppingoverview_navigational/assets/css/shoppingoverview_navigational.css')
        ->addStyleSheet($baseUrl . 'components/com_shoppingoverview/assets/css/imgareaselect-default.css');


    $lang = shoppingoverviewSiteHelper::getPerfixLang($doc->getlanguage());

    $module = new ShoppingoverviewModuleModelNavigational();

    $categories = $module->getListCategories($params);
    $items = $module->getListItems($lang);


    require JModuleHelper::getLayoutPath('mod_shoppingoverview_navigational');
}
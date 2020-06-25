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
    JHtml::_('jquery.framework');
    $doc
        ->addScript($baseUrl . 'components/com_shoppingoverview/assets/js/shoppingoverview.js')
        ->addScript($baseUrl . 'modules/mod_shoppingoverview_favorites/assets/js/shoppingoverview_favorites.js')
        ->addStyleSheet($baseUrl . 'components/com_shoppingoverview/assets/css/shoppingoverview.css')
        ->addStyleSheet($baseUrl . 'modules/mod_shoppingoverview_favorites/assets/css/shoppingoverview_favorites.css');

    $user = JFactory::getUser();

    $lang = shoppingoverviewSiteHelper::getPerfixLang($doc->getlanguage());

    $module = new ShoppingoverviewModuleModelFavorites();

    $categories = $module->itemFavoriteCat($user);

    require JModuleHelper::getLayoutPath('mod_shoppingoverview_favorites');
}
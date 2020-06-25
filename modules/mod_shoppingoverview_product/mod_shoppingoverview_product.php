<?php

// No direct access
defined('_JEXEC') or die;
// Include the syndicate functions only once
require_once dirname(dirname(dirname(__FILE__))) . '/components/com_shoppingoverview/helpers/secondaryfunctions.php';
$opacity = DopFunction::getRoutPosition($params);

if($opacity) {
    require_once dirname(dirname(dirname(__FILE__))) . '/components/com_shoppingoverview/helpers/shoppingoverview.php';
    require_once dirname(dirname(dirname(__FILE__))) . '/components/com_shoppingoverview/models/images.php';
    require_once dirname(dirname(dirname(__FILE__))) . '/components/com_shoppingoverview/models/tags.php';
    require_once dirname(dirname(dirname(__FILE__))) . '/components/com_shoppingoverview/models/favorites.php';
    require_once dirname(__FILE__) . '/helper.php';

    $baseUrl = JUri::base();
    $doc = JFactory::getDocument();
    $app = JFactory::getApplication();
    JHtml::_('jquery.framework');
    $doc
        ->addScript($baseUrl . 'components/com_shoppingoverview/assets/js/shoppingoverview.js')
        ->addScript($baseUrl . 'components/com_shoppingoverview/assets/js/jquery.imgareaselect.pack.js')
        ->addScript($baseUrl . 'modules/mod_shoppingoverview_product/assets/js/shoppingoverview_product.js')
        ->addStyleSheet($baseUrl . 'components/com_shoppingoverview/assets/css/shoppingoverview.css')
        ->addStyleSheet($baseUrl . 'modules/mod_shoppingoverview_product/assets/css/shoppingoverview_product.css')
        ->addStyleSheet($baseUrl . 'components/com_shoppingoverview/assets/css/imgareaselect-default.css');


    $cat_alias = $app->input->getString('cat_alias', null);
    $cat_alias = str_replace(':','-',$cat_alias);

    $lang = shoppingoverviewSiteHelper::getPerfixLang($doc->getlanguage());

    $module = new ShoppingoverviewModuleModelProduct();
    $modelImages = new ShoppingoverviewModelImages();
    $modelTags = new ShoppingoverviewModelTags();
    $modelFavorites = new ShoppingoverviewModelFavorites();

    $viewDefault = $params->get('viewDefault');

    $count = $params->get('count');

    $viewDisplay = $params->get('viewDisplay');

    $viewDisplayArr = array(
        'latest'=> JText::_('MOD_SHOPPINGOVERVIEW_PRODUCT_1'),
        'discussed'=> JText::_('MOD_SHOPPINGOVERVIEW_PRODUCT_2'),
        'likes'=> JText::_('MOD_SHOPPINGOVERVIEW_PRODUCT_3'),
        'popular'=> JText::_('MOD_SHOPPINGOVERVIEW_PRODUCT_4')
    );

    $items = $module->getListItems($cat_alias,$lang,$viewDefault,$count);


    require JModuleHelper::getLayoutPath('mod_shoppingoverview_product');
}
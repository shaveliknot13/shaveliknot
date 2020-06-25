<?php

// No direct access
defined('_JEXEC') or die;
// Include the syndicate functions only once

require_once dirname(dirname(dirname(__FILE__))) . '/components/com_shoppingoverview/helpers/secondaryfunctions.php';

$opacity = DopFunction::getRoutPosition($params);

if($opacity) {

    require_once dirname(__FILE__) . '/helper.php';
    require_once dirname(dirname(dirname(__FILE__))) . '/components/com_shoppingoverview/helpers/shoppingoverview.php';

    $baseUrl = JUri::base();
    $doc = JFactory::getDocument();
    JHtml::_('jquery.framework');
    $doc
        ->addScript( $baseUrl . 'modules/mod_shoppingoverview_categories/assets/js/owl.carousel.min.js' )
        ->addScript( $baseUrl . 'modules/mod_shoppingoverview_categories/assets/js/shoppingoverview_categories.js' )
        ->addStyleSheet( $baseUrl . 'modules/mod_shoppingoverview_categories/assets/css/owl.carousel.min.css' )
        ->addStyleSheet( $baseUrl . 'modules/mod_shoppingoverview_categories/assets/css/shoppingoverview_categories.css' );

    $lang =  shoppingoverviewSiteHelper::getPerfixLang($doc->getlanguage());

    $app = JFactory::getApplication();
    $cat_alias = $app->input->get('cat_alias', '', 'string');
    $cat_alias = str_replace(':','-',$cat_alias);

    $module = new ShoppingoverviewModuleModelCategories();

    $row = $module->getListAll($params);

    require JModuleHelper::getLayoutPath('mod_shoppingoverview_categories');

}
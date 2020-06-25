<?php

// No direct access
defined('_JEXEC') or die;
// Include the syndicate functions only once

require_once dirname(dirname(dirname(__FILE__))) . '/components/com_shoppingoverview/helpers/secondaryfunctions.php';
$opacity = DopFunction::getRoutPosition($params);

if($opacity) {
    require_once dirname(__FILE__) . '/helper.php';
    require_once dirname(dirname(dirname(__FILE__))) . '/components/com_shoppingoverview/helpers/shoppingoverview.php';
    require_once dirname(dirname(dirname(__FILE__))) . '/components/com_shoppingoverview/models/images.php';
    require_once dirname(dirname(dirname(__FILE__))) . '/components/com_shoppingoverview/models/tags.php';

    JText::script('COM_SHOPPINGOVERVIEW_DATA_SENT_INCORRECTLY');

    $baseUrl = JUri::base();
    $doc = JFactory::getDocument();
    JHtml::_('jquery.framework');
    $doc
        ->addScript($baseUrl . 'components/com_shoppingoverview/assets/js/shoppingoverview.js')
        ->addScript($baseUrl . 'components/com_shoppingoverview/assets/js/jquery.imgareaselect.pack.js')
        ->addScript($baseUrl . 'modules/mod_shoppingoverview_categories_filter/assets/js/shoppingoverview_categories_filter.js')
        ->addStyleSheet($baseUrl . 'components/com_shoppingoverview/assets/css/shoppingoverview.css')
        ->addStyleSheet($baseUrl . 'modules/mod_shoppingoverview_categories_filter/assets/css/shoppingoverview_categories_filter.css')
        ->addStyleSheet($baseUrl . 'components/com_shoppingoverview/assets/css/imgareaselect-default.css');


    $lang = shoppingoverviewSiteHelper::getPerfixLang($doc->getlanguage());


    $modelImages = new ShoppingoverviewModelImages();
    $modelTags = new ShoppingoverviewModelTags();
    $module = new ShoppingoverviewModuleModelCategoriesfilter();

    $categories = $module->getListCategories();

    $session = JFactory::getSession();
    $massArrFilter = $session->get('globalfilter', false);
    if ($massArrFilter == false) {
        $massArrFilter = (object)array(
            "filterSoCat" => 0,
            "filterSoDay" => 7,
            "filterSoPrice" => 0,
            "filterSoDelivery" => 0,
            "filterSoVideo" => 0,
            "filterSoOrdering" => 'latest'
        );
        $session->set('globalfilter', $massArrFilter);
    }

    require JModuleHelper::getLayoutPath('mod_shoppingoverview_categories_filter');
}
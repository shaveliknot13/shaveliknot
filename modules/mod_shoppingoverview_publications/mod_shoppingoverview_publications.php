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
    require_once dirname(dirname(dirname(__FILE__))) . '/components/com_shoppingoverview/models/favorites.php';
    require_once dirname(dirname(dirname(__FILE__))) . '/components/com_shoppingoverview/models/advertisings.php';

    $baseUrl = JUri::base();
    $doc = JFactory::getDocument();
    JHtml::_('jquery.framework');
    $doc
        ->addScript($baseUrl . 'components/com_shoppingoverview/assets/js/shoppingoverview.js')
        ->addScript($baseUrl . 'components/com_shoppingoverview/assets/js/jquery.imgareaselect.pack.js')
        ->addScript($baseUrl . 'modules/mod_shoppingoverview_publications/assets/js/shoppingoverview_publications.js')
        ->addStyleSheet($baseUrl . 'components/com_shoppingoverview/assets/css/shoppingoverview.css')
        ->addStyleSheet($baseUrl . 'modules/mod_shoppingoverview_publications/assets/css/shoppingoverview_publications.css')
        ->addStyleSheet($baseUrl . 'components/com_shoppingoverview/assets/css/imgareaselect-default.css');


    $lang = shoppingoverviewSiteHelper::getPerfixLang($doc->getlanguage());


    $modelImages = new ShoppingoverviewModelImages();
    $modelTags = new ShoppingoverviewModelTags();
    $module = new ShoppingoverviewModuleModelPublications();
    $modelFavorites = new ShoppingoverviewModelFavorites();
    $modelAvertisings = new ShoppingoverviewModelAdvertisings();

    $langYaz = JFactory::getLanguage();
    $langYaz->load('com_shoppingoverview');

    $categories = $module->getListCategories($params);

    $session = JFactory::getSession();
    $massArrFilter = $session->get('globalfilter', false);
    if ($massArrFilter == false) {
        $massArrFilter = (object)array(
            "filterSoCat" => 0,
            "filterSoDay" => 7,
            "filterSoPrice1" => 0,
            "filterSoPrice2" => 0,
            "filterSoDelivery" => 0,
            "filterSoVideo" => 0,
            "filterSoOrdering" => 'latest'
        );
        $session->set('globalfilter', $massArrFilter);
    }

    $items = $module->getListItems($lang, $massArrFilter);

    require JModuleHelper::getLayoutPath('mod_shoppingoverview_publications');
}
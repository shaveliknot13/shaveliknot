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

    $baseUrl = JUri::base();
    $doc = JFactory::getDocument();
    JHtml::_('jquery.framework');
    $doc
        ->addScript($baseUrl . 'components/com_shoppingoverview/assets/js/shoppingoverview.js')
        ->addScript($baseUrl . 'components/com_shoppingoverview/assets/js/jquery.imgareaselect.pack.js')
        ->addScript($baseUrl . 'modules/mod_shoppingoverview_preview/assets/js/shoppingoverview_preview.js')
        ->addStyleSheet($baseUrl . 'components/com_shoppingoverview/assets/css/shoppingoverview.css')
        ->addStyleSheet($baseUrl . 'modules/mod_shoppingoverview_preview/assets/css/shoppingoverview_preview.css')
        ->addStyleSheet($baseUrl . 'components/com_shoppingoverview/assets/css/imgareaselect-default.css');


    $lang = shoppingoverviewSiteHelper::getPerfixLang($doc->getlanguage());

    require JModuleHelper::getLayoutPath('mod_shoppingoverview_preview');
}
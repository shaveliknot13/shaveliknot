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
        ->addScript($baseUrl . 'modules/mod_shoppingoverview_breadcrumbs/assets/js/shoppingoverview_breadcrumbs.js')
        ->addStyleSheet($baseUrl . 'components/com_shoppingoverview/assets/css/shoppingoverview.css')
        ->addStyleSheet($baseUrl . 'modules/mod_shoppingoverview_breadcrumbs/assets/css/shoppingoverview_breadcrumbs.css')
        ->addStyleSheet($baseUrl . 'components/com_shoppingoverview/assets/css/imgareaselect-default.css');


    $lang = shoppingoverviewSiteHelper::getPerfixLang($doc->getlanguage());

    $module = new ShoppingoverviewModuleModelBreadcrumbs();

    $app = JFactory::getApplication();
    $cat_alias = $app->input->get('cat_alias', null, 'string');
    $cat_alias = str_replace(':','-',$cat_alias);

    $item_alias = $app->input->get('item_alias', null, 'string');
    $item_alias = str_replace(':','-',$item_alias);


    if(!empty($cat_alias) && !empty($item_alias)){

        $cat = $module->getCategory($cat_alias);
        $item = $module->getProduct($item_alias, $lang);

        if(empty($cat) || empty($item)){
            exit();
        }

        $result = '<span>></span> ';
        $result .= '<a href="'.JRoute::_( 'index.php?option=com_shoppingoverview&cat_alias='.$cat->alias.'&Itemid=101' ).'">';
        $result .= $cat->icon.' '.$cat->{'title_'.$lang};;
        $result .= '</a>';
        $result .= '<span> > </span> ';
        $result .= '<span>'.$item->product.'</span>';

    }elseif (!empty($cat_alias)){
        $cat = $module->getCategory($cat_alias);
        if(empty($cat)){
            exit();
        }

        $result = '<span>></span> ';
        $result .= $cat->icon.' '.$cat->{'title_'.$lang};;

    }else{
        exit();
    }


    require JModuleHelper::getLayoutPath('mod_shoppingoverview_breadcrumbs');
}
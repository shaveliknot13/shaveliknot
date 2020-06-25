<?php
// No direct access
defined( '_JEXEC' ) or die;


/**
 * Controller
 * @author Воропаев Валентин
 */


class ShoppingoverviewControllerLangs extends JControllerLegacy
{


    function display( $cachable = false, $urlparams = array() )
    {
        $doc = &JFactory::getDocument();
        $app = JFactory::getApplication();
        $lang =  shoppingoverviewSiteHelper::getPerfixLang($doc->getlanguage());
        shoppingoverviewSiteHelper::setDocument( 'Set langs' );

        $view = $this->getView('langs','html');
        $view->setLayout('default');
        $view->assignRef('lang',$lang);
        $view->display();
    }







}
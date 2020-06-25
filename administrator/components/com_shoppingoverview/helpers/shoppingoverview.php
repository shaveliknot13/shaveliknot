<?php

defined( '_JEXEC' ) or die;

class ShoppingoverviewHelper
{

	static function addSubmenu( $vName )
	{
		JHtmlSidebar::addEntry(
			JText::_( 'CATEGORIES_SUBMENU' ),
			'index.php?option=com_shoppingoverview&controller=categories',
			$vName == 'categories' );
		JHtmlSidebar::addEntry(
			JText::_( 'ITEMS_SUBMENU' ),
			'index.php?option=com_shoppingoverview&controller=items',
			$vName == 'items' );
		JHtmlSidebar::addEntry(
			JText::_( 'FAVORITES_SUBMENU' ),
			'index.php?option=com_shoppingoverview&controller=favorites',
			$vName == 'favorites' );
        JHtmlSidebar::addEntry(
            JText::_( 'DELIVERYS_SUBMENU' ),
            'index.php?option=com_shoppingoverview&controller=deliverys',
            $vName == 'deliverys' );
		JHtmlSidebar::addEntry(
			JText::_( 'TAGS_SUBMENU' ),
			'index.php?option=com_shoppingoverview&controller=tags',
			$vName == 'tags' );
        JHtmlSidebar::addEntry(
            JText::_( 'USERSUBSCRIBES_SUBMENU' ),
            'index.php?option=com_shoppingoverview&controller=usersubscribes',
            $vName == 'usersubscribes' );
		JHtmlSidebar::addEntry(
			JText::_( 'PRIVILEGES_SUBMENU' ),
			'index.php?option=com_shoppingoverview&controller=privileges',
			$vName == 'privileges' );
        JHtmlSidebar::addEntry(
            JText::_( 'ADVERTISINGS_SUBMENU' ),
            'index.php?option=com_shoppingoverview&controller=advertisings',
            $vName == 'advertisings' );
        JHtmlSidebar::addEntry(
            JText::_( 'NOTIFICATIONS_SUBMENU' ),
            'index.php?option=com_shoppingoverview&controller=notifications',
            $vName == 'notifications' );
        JHtmlSidebar::addEntry(
            JText::_( 'ASKS_SUBMENU' ),
            'index.php?option=com_shoppingoverview&controller=asks',
            $vName == 'asks' );
	}


    static function setDocument( )
    {
        $baseUrl = JUri::base();
        $doc = JFactory::getDocument();
        $doc
            ->addScript( $baseUrl . 'components/com_shoppingoverview/assets/js/shoppingoverview.js' )
            ->addScript( $baseUrl . 'components/com_shoppingoverview/assets/js/jquery.imgareaselect.pack.js' )
            ->addStyleSheet( $baseUrl . 'components/com_shoppingoverview/assets/css/shoppingoverview.css' )
            ->addStyleSheet( $baseUrl . 'components/com_shoppingoverview/assets/css/imgareaselect-default.css' )
        ;
    }


}
<?php
defined( '_JEXEC' ) or die; // No direct access

class ShoppingoverviewViewNotifications extends JViewLegacy
{

	public function display( $tpl = null )
	{
        ShoppingoverviewHelper::addSubmenu('notifications');
        $this->sidebar = JHtmlSidebar::render();
        parent::display($tpl);
	}

}
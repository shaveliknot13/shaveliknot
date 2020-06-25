<?php
defined( '_JEXEC' ) or die; // No direct access

class ShoppingoverviewViewUsersubscribes extends JViewLegacy
{

	public function display( $tpl = null )
	{
        ShoppingoverviewHelper::addSubmenu('usersubscribes');
        $this->sidebar = JHtmlSidebar::render();
        parent::display($tpl);
	}

}
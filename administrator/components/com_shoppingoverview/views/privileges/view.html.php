<?php
defined( '_JEXEC' ) or die; // No direct access

class ShoppingoverviewViewPrivileges extends JViewLegacy
{

	public function display( $tpl = null )
	{
        ShoppingoverviewHelper::addSubmenu('privileges');
        $this->sidebar = JHtmlSidebar::render();
        parent::display($tpl);
	}

}
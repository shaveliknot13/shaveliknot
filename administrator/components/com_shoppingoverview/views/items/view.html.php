<?php
defined( '_JEXEC' ) or die; // No direct access

class ShoppingoverviewViewItems extends JViewLegacy
{

	public function display( $tpl = null )
	{
        ShoppingoverviewHelper::addSubmenu('items');
        $this->sidebar = JHtmlSidebar::render();
        parent::display($tpl);
	}

}
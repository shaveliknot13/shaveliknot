<?php
defined( '_JEXEC' ) or die; // No direct access

class ShoppingoverviewViewCategories extends JViewLegacy
{

	public function display( $tpl = null )
	{
        ShoppingoverviewHelper::addSubmenu('categories');
        $this->sidebar = JHtmlSidebar::render();
        parent::display($tpl);
	}

}
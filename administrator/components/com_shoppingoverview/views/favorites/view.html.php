<?php
defined( '_JEXEC' ) or die; // No direct access

class ShoppingoverviewViewFavorites extends JViewLegacy
{

	public function display( $tpl = null )
	{
        ShoppingoverviewHelper::addSubmenu('favorites');
        $this->sidebar = JHtmlSidebar::render();
        parent::display($tpl);
	}

}
<?php
defined( '_JEXEC' ) or die; // No direct access

class ShoppingoverviewViewAsks extends JViewLegacy
{

	public function display( $tpl = null )
	{
        ShoppingoverviewHelper::addSubmenu('asks');
        $this->sidebar = JHtmlSidebar::render();
        parent::display($tpl);
	}

}
<?php
defined( '_JEXEC' ) or die; // No direct access

class ShoppingoverviewViewAdvertisings extends JViewLegacy
{

	public function display( $tpl = null )
	{
        ShoppingoverviewHelper::addSubmenu('advertisings');
        $this->sidebar = JHtmlSidebar::render();
        parent::display($tpl);
	}

}
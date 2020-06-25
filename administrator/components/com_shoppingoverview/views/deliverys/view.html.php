<?php
defined( '_JEXEC' ) or die; // No direct access

class ShoppingoverviewViewDeliverys extends JViewLegacy
{

	public function display( $tpl = null )
	{
        ShoppingoverviewHelper::addSubmenu('deliverys');
        $this->sidebar = JHtmlSidebar::render();
        parent::display($tpl);
	}

}
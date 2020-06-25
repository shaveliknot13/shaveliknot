<?php
defined( '_JEXEC' ) or die; // No direct access

class ShoppingoverviewViewTags extends JViewLegacy
{

	public function display( $tpl = null )
	{
        ShoppingoverviewHelper::addSubmenu('tags');
        $this->sidebar = JHtmlSidebar::render();
        parent::display($tpl);
	}

}
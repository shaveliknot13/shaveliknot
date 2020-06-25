<?php

defined('JPATH_BASE') or die;

JLoader::register('ShoppingoverviewModelPrivileges', JPATH_ADMINISTRATOR . '/components/com_shoppingoverview/models/privileges.php');

JFormHelper::loadFieldClass('list');


class JFormFieldPrivilegesfild extends JFormFieldList
{

	protected $type = 'Privilegesfild';

	protected function getOptions()
	{
        $doc = & JFactory::getDocument();
        $lang =  shoppingoverviewSiteHelper::getPerfixLang($doc->getlanguage());

        $this->value = unserialize($this->value);

        $privilegesList = new ShoppingoverviewModelPrivileges();
        $privilegesList = $privilegesList->getPrivileges();
        $argv = array();

        $filds = new stdClass();
        $filds->value = '';
        $filds->text = JText::_('COM_SHOPPINGOVERVIEW_EDIT_FILD_29');
        $filds->disable = true;
        $filds->multiple = true;
        $filds->class = '';
        $filds->selected = false;
        $filds->checked = false;
        $filds->onclick = '';
        $filds->onchange = '';

        $argv[] = $filds;

        foreach($privilegesList as $key => $item){
            $filds = new stdClass();
            $filds->value = $key;
            $filds->text = $item;
            $filds->disable = false;
            $argv[] = $filds;
        }

        return $argv;
	}
}

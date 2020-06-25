<?php

defined('JPATH_BASE') or die;

JLoader::register('ShoppingoverviewModelPrivileges', JPATH_ADMINISTRATOR . '/components/com_shoppingoverview/models/privileges.php');

JFormHelper::loadFieldClass('list');


class JFormFieldPrivilegesfild extends JFormFieldList
{

	protected $type = 'Privilegesfild';

	protected function getOptions()
	{

        $this->value = unserialize($this->value);

        $privilegesList = new ShoppingoverviewModelPrivileges();
        $privilegesList = $privilegesList->getPrivileges();
        $argv = array();

        $filds = new stdClass();
        $filds->value = '';
        $filds->text = '- Выбор привелегий -';
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

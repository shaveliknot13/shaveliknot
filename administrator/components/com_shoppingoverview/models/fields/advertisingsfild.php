<?php

defined('JPATH_BASE') or die;

JLoader::register('ShoppingoverviewModelPrivileges', JPATH_ADMINISTRATOR . '/components/com_shoppingoverview/models/advertisings.php');

JFormHelper::loadFieldClass('list');


class JFormFieldAdvertisingsfild extends JFormFieldList
{

	protected $type = 'Advertisingsfild';

	protected function getOptions()
	{

        $advertisingsList = new ShoppingoverviewModelAdvertisings();
        $advertisingsList = $advertisingsList->getAdvertisings();
        $argv = array();

        $filds = new stdClass();
        $filds->value = '';
        $filds->text = '- Выбор позиции -';
        $filds->disable = true;
        $filds->class = '';
        $filds->selected = false;
        $filds->checked = false;
        $filds->onclick = '';
        $filds->onchange = '';

        $argv[] = $filds;

        foreach($advertisingsList as $key => $item){
            $filds = new stdClass();
            $filds->value = $key;
            $filds->text = $item;
            $filds->disable = false;

            $argv[] = $filds;
        }

        return $argv;
	}
}

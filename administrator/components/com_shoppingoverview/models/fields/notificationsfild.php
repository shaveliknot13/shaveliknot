<?php

defined('JPATH_BASE') or die;

JLoader::register('ShoppingoverviewModelNotifications', JPATH_ADMINISTRATOR . '/components/com_shoppingoverview/models/notifications.php');

JFormHelper::loadFieldClass('list');


class JFormFieldNotificationsfild extends JFormFieldList
{

	protected $type = 'Notificationsfild';

	protected function getOptions()
	{

        $notificationsList = new ShoppingoverviewModelNotifications();
        $notificationsList = $notificationsList->getNotifications();
        $argv = array();

        $filds = new stdClass();
        $filds->value = '';
        $filds->text = '- Выбор шаблона -';
        $filds->disable = true;
        $filds->class = '';
        $filds->selected = false;
        $filds->checked = false;
        $filds->onclick = '';
        $filds->onchange = '';

        $argv[] = $filds;

        foreach($notificationsList as $key => $item){
            $filds = new stdClass();
            $filds->value = $key;
            $filds->text = $item;
            $filds->disable = false;
            $argv[] = $filds;
        }

        return $argv;
	}
}

<?php

defined('JPATH_BASE') or die;

JLoader::register('ShoppingoverviewModelCategories', JPATH_ADMINISTRATOR . '/components/com_shoppingoverview/models/categories.php');

JFormHelper::loadFieldClass('list');


class JFormFieldCatfild extends JFormFieldList
{

	protected $type = 'Catfild';

	protected function getOptions()
	{

        $catList = new ShoppingoverviewModelCategories();
        $catList = $catList->getListAll();
        $argv = array();

        $filds = new stdClass();
        $filds->value = '';
        $filds->text = '- Выбор категории -';
        $filds->disable = true;
        $filds->class = '';
        $filds->selected = false;
        $filds->checked = false;
        $filds->onclick = '';
        $filds->onchange = '';

        $argv[] = $filds;

        foreach($catList as $item){
            $filds = new stdClass();
            $filds->value = $item->id;
            $filds->text = $item->id.' | '.$item->title_ru.'| '.$item->title_en.' | '.$item->title_he;
            $filds->disable = false;

            $argv[] = $filds;
        }

        return $argv;
	}
}

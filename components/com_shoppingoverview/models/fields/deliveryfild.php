<?php

defined('JPATH_BASE') or die;

JLoader::register('ShoppingoverviewModelDeliverys', JPATH_ADMINISTRATOR . '/components/com_shoppingoverview/models/deliverys.php');

JFormHelper::loadFieldClass('list');


class JFormFieldDeliveryfild extends JFormFieldList
{

    protected $type = 'Deliveryfild';

    protected function getOptions()
    {
        $doc = & JFactory::getDocument();
        $lang =  shoppingoverviewSiteHelper::getPerfixLang($doc->getlanguage());

        $filter = new stdClass();
        $filter->search = '';
        $filter->ordering ='id DESC';
        $filter->limit = '0';

        $catList = new ShoppingoverviewModelDeliverys();
        $catList = $catList->getListAll();
        $argv = array();

        $filds = new stdClass();
        $filds->value = '';
        $filds->text = JText::_('COM_SHOPPINGOVERVIEW_EDIT_FILD_28');
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
            $filds->text = $item->{"title_".$lang};
            $filds->disable = false;

            $argv[] = $filds;
        }

        return $argv;
    }
}

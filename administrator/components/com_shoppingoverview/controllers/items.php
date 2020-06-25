<?php

// No direct access
defined( '_JEXEC' ) or die;

class ShoppingoverviewControllersItems extends JControllerLegacy
{

    function display( $cachable = false, $urlparams = array() )
    {
        JToolBarHelper::title('Обзоры');
        JToolBarHelper::addNew('.edit');
        JToolBarHelper::deleteList();
        JToolBarHelper::publish();
        JToolBarHelper::unpublish();
        JToolBarHelper::custom( '.duplicate', 'copy', 'copy', 'Дублировать', false, false );
        JToolBarHelper::divider();
        JToolBarHelper::preferences('com_shoppingoverview');

        $session = JFactory::getSession();
        $filter = $session->get('AdminItemsFilterSearch', false);

        if($filter == false){
            $filter = new stdClass();
            $filter->published = '0';
            $filter->trash = '0';
            $filter->search = '';
            $filter->ordering ='id DESC';
            $filter->limit = '10';
            $session->set('AdminItemsFilterSearch', $filter);
        }

        $model = $this->getModel('items');
        $modelTags = $this->getModel('tags');

        $rows = $model->getListItems($filter);

        $view = $this->getView('items','html');
        $view->setLayout('default');
        $view->assignRef('rows',$rows);
        $view->assignRef('modelTags',$modelTags);
        $view->assignRef('filter',$filter);
        $view->display();
    }

    function edit( $cachable = false, $urlparams = array() )
    {
        JToolBarHelper::title('Новый обзор');
        JToolBarHelper::save();
        JToolBarHelper::back();

        $app = JFactory::getApplication();
        $id = $app->input->getInt('id', null);

        $model = $this->getModel('items');
        $modelImages = $this->getModel('images');
        $modelTags = $this->getModel('tags');
        $form = $model->getForm();
        $row = $model->getItem($id);

        $view = $this->getView('items','html');
        $view->setLayout('edit');
        $view->assignRef('modelImages',$modelImages);
        $view->assignRef('modelTags',$modelTags);
        $view->assignRef('row',$row);
        $view->assignRef('form',$form);
        $view->display();
    }

    function save( $cachable = false, $urlparams = array() )
    {
        JToolBarHelper::title('Новый обзор');
        JToolBarHelper::save();
        JToolBarHelper::back();

        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        $app = JFactory::getApplication();
        $data = $app->input->get('jform', array(), 'array');
        $model = $this->getModel('items');
        $modelImages = $this->getModel('images');
        $modelTags = $this->getModel('tags');
        $form = $model->getForm();

        $data = DopFunction::arrayToObjects($data['myFieldset']);

        // картинки и текст формируються и проверяються на количество
        if(
            count($data->text_ru) == 10 && count($data->text_en) == 10 && count($data->text_he) == 10 &&
            count($data->images_ru) == 10 && count($data->images_en) == 10 && count($data->images_he) == 10
        )
        {

            $formating = $model->formating($data,$modelImages);
            $data->text_ru = $formating['content_ru'];
            $data->text_en = $formating['content_en'];
            $data->text_he = $formating['content_he'];

        }else{

            $app->enqueueMessage('Данные переданые неверно', 'warning');
            $app->Redirect('index.php?option=com_shoppingoverview&controller=items');

        }

        // групируем кардинаты обрезки с id изоображений и уникализируем массив
        $imgCoordinates = $modelImages->formating($data);
        // проверяем принадлежат ли все картинки владельцу
        if( !$modelImages->validate($imgCoordinates) ){
            $app->enqueueMessage('Данные переданые неверно', 'warning');
            $app->Redirect('index.php?option=com_shoppingoverview&controller=items');
        }
        // обрезаем картинку по кардинатам и создаем миниатюру
        $modelImages->crops($imgCoordinates);


        // валидация общих данных
        $validate = $model->validate($data);


        //die();

        if(!$validate['status']){

            $app->enqueueMessage($validate['text'], 'warning');
            $view = $this->getView('items','html');
            $view->setLayout('edit');
            $view->assignRef('modelImages',$modelImages);
            $view->assignRef('row',$data);
            $view->assignRef('modelTags',$modelTags);
            $view->assignRef('form',$form);
            $view->display();

        }else{

            $idItem = $model->save($data);

            if($idItem){

                $this->saveTags($data,$idItem);

                $app->enqueueMessage('Сохранено');
                $app->Redirect('index.php?option=com_shoppingoverview&controller=items');

            }else{

                $app->enqueueMessage('Не сохранилось', 'warning');
                $app->Redirect('index.php?option=com_shoppingoverview&controller=items');

            }

        }

    }

    function saveTags($data,$id){

        $modelCat = $this->getModel('categories');
        $modelTags = $this->getModel('tags');

        $argv = array();

        foreach($data->tags as $item){
            $argv[] = substr(trim(mb_strtolower($item, 'UTF-8')), 0, 35);
        }

        // обязательные тэги
        $argv[] = substr(trim(mb_strtolower($data->product, 'UTF-8')), 0, 35);
        $argv[] = substr(trim(mb_strtolower($modelCat->getItem($data->cat_id)->title, 'UTF-8')), 0, 35);

        $argv = array_unique($argv);
        $argv = array_diff($argv, array('', null, false));

        $modelTags->saveList($id,$argv,true);

    }

    function remove(){
        $app = JFactory::getApplication();
        $data = $app->input->get('cid', array(), 'array');
        $model = $this->getModel('items');

        if(count($data) > 0){

            $model->remove($data);
            $app->enqueueMessage('Удалено');
            $app->Redirect('index.php?option=com_shoppingoverview&controller=items');

        }else{

            $app->enqueueMessage('Нечего не выбрано', 'warning');
            $app->Redirect('index.php?option=com_shoppingoverview&controller=items');

        }
    }

    function publish(){
        $app = JFactory::getApplication();
        $data = $app->input->get('cid', array(), 'array');
        $model = $this->getModel('items');

        if(count($data) > 0){

            $model->publish($data);
            $app->enqueueMessage('Опубликовано');
            $app->Redirect('index.php?option=com_shoppingoverview&controller=items');

        }else{

            $app->enqueueMessage('Нечего не выбрано', 'warning');
            $app->Redirect('index.php?option=com_shoppingoverview&controller=items');

        }
    }

    function unpublish(){
        $app = JFactory::getApplication();
        $data = $app->input->get('cid', array(), 'array');
        $model = $this->getModel('items');

        if(count($data) > 0){

            $model->unpublish($data);
            $app->enqueueMessage('Снято с публикации');
            $app->Redirect('index.php?option=com_shoppingoverview&controller=items');

        }else{

            $app->enqueueMessage('Нечего не выбрано', 'warning');
            $app->Redirect('index.php?option=com_shoppingoverview&controller=items');

        }
    }

    function duplicate(){
        $app = JFactory::getApplication();
        $data = $app->input->get('cid', array(), 'array');
        $model = $this->getModel('items');

        if(count($data) > 0){

            $model->duplicate($data);
            $app->enqueueMessage('Продублировано');
            $app->Redirect('index.php?option=com_shoppingoverview&controller=items');

        }else{

            $app->enqueueMessage('Нечего не выбрано', 'warning');
            $app->Redirect('index.php?option=com_shoppingoverview&controller=items');

        }
    }

    function  filter(){

        $app = JFactory::getApplication();
        $data = $app->input->get('filter', array(), 'array');
        $data = DopFunction::arrayToObjects($data);

        if(!property_exists($data,'trash')){
            $data->trash = '0';
        }
        if(!property_exists($data,'published')){
            $data->published = '0';
        }
        if(!property_exists($data,'search')){
            $data->search = '';
        }
        if(!property_exists($data,'ordering')){
            $data->ordering ='id DESC';
        }
        if(!property_exists($data,'limit')){
            $data->limit = '10';
        }


        $session = JFactory::getSession();
        $session->set('AdminItemsFilterSearch', $data);
        $app->Redirect('index.php?option=com_shoppingoverview&controller=items');
    }

    function ajaxGetItems(){
        header('Content-Type: application/json');
        $result = array('error' => 0, 'result' => '', 'count' => '');

        $app = JFactory::getApplication();
        $count = $app->input->get('count', null, 'int');
        if($count == 0){ $count = null; }

        $session = JFactory::getSession();
        $filter = $session->get('AdminItemsFilterSearch', false);
        $model = $this->getModel('items');
        $this->modelTags = $this->getModel('tags');

        if($filter->limit != 0) {

            $rows = $model->getListItems($filter, $count);
            $result['count'] = $count + $filter->limit;

            ob_start();
            require_once(dirname(dirname(__FILE__)) . '/views/items/tmpl/items.php');
            $result['result'] = ob_get_contents();
            ob_end_clean();

        }

        echo json_encode($result);
        exit();
    }



}
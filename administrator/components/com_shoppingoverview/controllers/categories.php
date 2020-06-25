<?php

// No direct access
defined( '_JEXEC' ) or die;

class ShoppingoverviewControllersCategories extends JControllerLegacy
{

    function display( $cachable = false, $urlparams = array() )
    {
        JToolBarHelper::title('Категории');
        JToolBarHelper::addNew('.edit');
        JToolBarHelper::deleteList();
        JToolBarHelper::publish();
        JToolBarHelper::unpublish();
        JToolBarHelper::custom( '.duplicate', 'copy', 'copy', 'Дублировать', false, false );
        JToolBarHelper::divider();
        JToolBarHelper::preferences('com_shoppingoverview');

        $session = JFactory::getSession();
        $filter = $session->get('AdminCategoriesFilterSearch', false);

        if($filter == false){
            $filter = new stdClass();
            $filter->search = '';
            $filter->ordering ='id DESC';
            $filter->limit = '10';
            $session->set('AdminCategoriesFilterSearch', $filter);
        }

        $model = $this->getModel('categories');
        $rows = $model->getListItems($filter);

        $view = $this->getView('categories','html');
        $view->setLayout('default');
        $view->assignRef('rows',$rows);
        $view->assignRef('filter',$filter);
        $view->display();
    }

    function edit( $cachable = false, $urlparams = array() )
    {
        JToolBarHelper::title('Новая категория');
        JToolBarHelper::save();
        JToolBarHelper::back();

        $app = JFactory::getApplication();
        $id = $app->input->getInt('id', null);

        $model = $this->getModel('categories');
        $form = $model->getForm();
        $row = $model->getItem($id);

        $view = $this->getView('categories','html');
        $view->setLayout('edit');
        $view->assignRef('row',$row);
        $view->assignRef('form',$form);
        $view->display();
    }

    function save( $cachable = false, $urlparams = array() )
    {
        JToolBarHelper::title('Новая категория');
        JToolBarHelper::save();
        JToolBarHelper::back();

        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        $app = JFactory::getApplication();
        $data = $app->input->get('jform', array(), 'array');
        $model = $this->getModel('categories');
        $form = $model->getForm();

        $data = DopFunction::arrayToObjects($data['myFieldset']);

        if(empty($data->alias)){
            if( !empty($data->title_en) ){
                $data->alias = $data->title_en;
            }elseif( !empty($data->title_ru) ){
                $data->alias = $data->title_ru;
            }else{
                $data->alias = $data->title_he;
            }
        }

        $validate = $model->validate($data);


        if(!$validate['status']){

            $app->enqueueMessage($validate['text'], 'warning');
            $view = $this->getView('categories','html');
            $view->setLayout('edit');
            $view->assignRef('row',$data);
            $view->assignRef('form',$form);
            $view->display();

        }else{

            if($model->save($data)){

                $app->enqueueMessage('Сохранено');
                $app->Redirect('index.php?option=com_shoppingoverview&controller=categories');

            }else{

                $app->enqueueMessage('Не сохранилось', 'warning');
                $app->Redirect('index.php?option=com_shoppingoverview&controller=categories');

            }

        }

    }

    function remove(){
        $app = JFactory::getApplication();
        $data = $app->input->get('cid', array(), 'array');
        $model = $this->getModel('categories');

        if(count($data) > 0){

            $model->remove($data);
            $app->enqueueMessage('Удалено');
            $app->Redirect('index.php?option=com_shoppingoverview&controller=categories');

        }else{

            $app->enqueueMessage('Нечего не выбрано', 'warning');
            $app->Redirect('index.php?option=com_shoppingoverview&controller=categories');

        }
    }

    function publish(){
        $app = JFactory::getApplication();
        $data = $app->input->get('cid', array(), 'array');
        $model = $this->getModel('categories');

        if(count($data) > 0){

            $model->publish($data);
            $app->enqueueMessage('Опубликовано');
            $app->Redirect('index.php?option=com_shoppingoverview&controller=categories');

        }else{

            $app->enqueueMessage('Нечего не выбрано', 'warning');
            $app->Redirect('index.php?option=com_shoppingoverview&controller=categories');

        }
    }

    function unpublish(){
        $app = JFactory::getApplication();
        $data = $app->input->get('cid', array(), 'array');
        $model = $this->getModel('categories');

        if(count($data) > 0){

            $model->unpublish($data);
            $app->enqueueMessage('Снято с публикации');
            $app->Redirect('index.php?option=com_shoppingoverview&controller=categories');

        }else{

            $app->enqueueMessage('Нечего не выбрано', 'warning');
            $app->Redirect('index.php?option=com_shoppingoverview&controller=categories');

        }
    }

    function duplicate(){
        $app = JFactory::getApplication();
        $data = $app->input->get('cid', array(), 'array');
        $model = $this->getModel('categories');

        if(count($data) > 0){

            $model->duplicate($data);
            $app->enqueueMessage('Продублировано');
            $app->Redirect('index.php?option=com_shoppingoverview&controller=categories');

        }else{

            $app->enqueueMessage('Нечего не выбрано', 'warning');
            $app->Redirect('index.php?option=com_shoppingoverview&controller=categories');

        }
    }

    function  filter(){

        $app = JFactory::getApplication();
        $data = $app->input->get('filter', array(), 'array');
        $data = DopFunction::arrayToObjects($data);
        if(!property_exists($data,'search') || !property_exists($data,'ordering') || !property_exists($data,'limit')){
            if(!property_exists($data,'search')){
                $data->search = '';
            }
            if(!property_exists($data,'ordering')){
                $data->ordering ='id DESC';
            }
            if(!property_exists($data,'limit')){
                $data->limit = '10';
            }
        }
        $session = JFactory::getSession();
        $session->set('AdminCategoriesFilterSearch', $data);
        $app->Redirect('index.php?option=com_shoppingoverview&controller=categories');
    }

    function ajaxGetItems(){
        header('Content-Type: application/json');
        $result = array('error' => 0, 'result' => '', 'count' => '');

        $app = JFactory::getApplication();
        $count = $app->input->get('count', null, 'int');
        if($count == 0){ $count = null; }

        $session = JFactory::getSession();
        $filter = $session->get('AdminCategoriesFilterSearch', false);
        $model = $this->getModel('categories');

        if($filter->limit != 0) {

            $rows = $model->getListItems($filter, $count);
            $result['count'] = $count + $filter->limit;

            ob_start();
            require_once(dirname(dirname(__FILE__)) . '/views/categories/tmpl/items.php');
            $result['result'] = ob_get_contents();
            ob_end_clean();

        }

        echo json_encode($result);
        exit();
    }

}
<?php

// No direct access
defined( '_JEXEC' ) or die;

class ShoppingoverviewControllersTags extends JControllerLegacy
{

    function display( $cachable = false, $urlparams = array() )
    {
        JToolBarHelper::title('Тэги');
        JToolBarHelper::addNew('.edit');
        JToolBarHelper::deleteList();
        JToolBarHelper::publish();
        JToolBarHelper::unpublish();
        JToolBarHelper::divider();
        JToolBarHelper::preferences('com_shoppingoverview');

        $session = JFactory::getSession();
        $filter = $session->get('AdminTagsFilterSearch', false);

        if($filter == false){
            $filter = new stdClass();
            $filter->search = '';
            $filter->ordering ='id DESC';
            $filter->limit = '10';
            $session->set('AdminTagsFilterSearch', $filter);
        }

        $model = $this->getModel('tags');
        $rows = $model->getListItems($filter);

        $view = $this->getView('tags','html');
        $view->setLayout('default');
        $view->assignRef('rows',$rows);
        $view->assignRef('filter',$filter);
        $view->display();
    }

    function edit( $cachable = false, $urlparams = array() )
    {
        JToolBarHelper::title('Новый тэг');
        JToolBarHelper::save();
        JToolBarHelper::back();

        $app = JFactory::getApplication();
        $id = $app->input->getInt('id', null);

        $model = $this->getModel('tags');
        $form = $model->getForm();
        $row = $model->getItem($id);

        $view = $this->getView('tags','html');
        $view->setLayout('edit');
        $view->assignRef('row',$row);
        $view->assignRef('form',$form);
        $view->display();
    }

    function save( $cachable = false, $urlparams = array() )
    {
        JToolBarHelper::title('Новый тэг');
        JToolBarHelper::save();
        JToolBarHelper::back();

        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        $app = JFactory::getApplication();
        $data = $app->input->get('jform', array(), 'array');
        $model = $this->getModel('tags');
        $form = $model->getForm();

        $data = DopFunction::arrayToObjects($data['myFieldset']);


        $validate = $model->validate($data);


        if(!$validate['status']){

            $app->enqueueMessage($validate['text'], 'warning');
            $view = $this->getView('tags','html');
            $view->setLayout('edit');
            $view->assignRef('row',$data);
            $view->assignRef('form',$form);
            $view->display();

        }else{

            if($model->save($data)){

                $app->enqueueMessage('Сохранено');
                $app->Redirect('index.php?option=com_shoppingoverview&controller=tags');

            }else{

                $app->enqueueMessage('Не сохранилось', 'warning');
                $app->Redirect('index.php?option=com_shoppingoverview&controller=tags');

            }

        }

    }

    function remove(){
        $app = JFactory::getApplication();
        $data = $app->input->get('cid', array(), 'array');
        $model = $this->getModel('tags');

        if(count($data) > 0){

            $model->remove($data);
            $app->enqueueMessage('Удалено');
            $app->Redirect('index.php?option=com_shoppingoverview&controller=tags');

        }else{

            $app->enqueueMessage('Нечего не выбрано', 'warning');
            $app->Redirect('index.php?option=com_shoppingoverview&controller=tags');

        }
    }

    function publish(){
        $app = JFactory::getApplication();
        $data = $app->input->get('cid', array(), 'array');
        $model = $this->getModel('tags');

        if(count($data) > 0){

            $model->publish($data);
            $app->enqueueMessage('Опубликовано');
            $app->Redirect('index.php?option=com_shoppingoverview&controller=tags');

        }else{

            $app->enqueueMessage('Нечего не выбрано', 'warning');
            $app->Redirect('index.php?option=com_shoppingoverview&controller=tags');

        }
    }

    function unpublish(){
        $app = JFactory::getApplication();
        $data = $app->input->get('cid', array(), 'array');
        $model = $this->getModel('tags');

        if(count($data) > 0){

            $model->unpublish($data);
            $app->enqueueMessage('Снято с публикации');
            $app->Redirect('index.php?option=com_shoppingoverview&controller=tags');

        }else{

            $app->enqueueMessage('Нечего не выбрано', 'warning');
            $app->Redirect('index.php?option=com_shoppingoverview&controller=tags');

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
        $session->set('AdminTagsFilterSearch', $data);
        $app->Redirect('index.php?option=com_shoppingoverview&controller=tags');
    }

    function ajaxGetItems(){
        header('Content-Type: application/json');
        $result = array('error' => 0, 'result' => '', 'count' => '');

        $app = JFactory::getApplication();
        $count = $app->input->get('count', null, 'int');
        if($count == 0){ $count = null; }

        $session = JFactory::getSession();
        $filter = $session->get('AdminTagsFilterSearch', false);
        $model = $this->getModel('tags');

        if($filter->limit != 0) {

            $rows = $model->getListItems($filter, $count);
            $result['count'] = $count + $filter->limit;

            ob_start();
            require_once(dirname(dirname(__FILE__)) . '/views/tags/tmpl/items.php');
            $result['result'] = ob_get_contents();
            ob_end_clean();

        }

        echo json_encode($result);
        exit();
    }

    function getTags(){
        header('Content-Type: application/json');
        $result = array('result' => '');

        $app = JFactory::getApplication();
        $search = $app->input->get('search', "", 'string');
        $model = $this->getModel('tags');

        $rows = $model->getListItemsAjax($search);

        if(!empty($rows)){

            ob_start();
            require_once(dirname(dirname(__FILE__)) . '/views/tags/tmpl/autocomplete.php');
            $result['result'] = ob_get_contents();
            ob_end_clean();

        }

        echo json_encode($result);
        exit();
    }

}
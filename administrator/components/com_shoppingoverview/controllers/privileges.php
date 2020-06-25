<?php

// No direct access
defined( '_JEXEC' ) or die;

class ShoppingoverviewControllersPrivileges extends JControllerLegacy
{

    function display( $cachable = false, $urlparams = array() )
    {
        JToolBarHelper::title('Привелегии');
        JToolBarHelper::addNew('.edit');
        JToolBarHelper::deleteList();
        JToolBarHelper::publish();
        JToolBarHelper::unpublish();
        JToolBarHelper::divider();
        JToolBarHelper::preferences('com_shoppingoverview');

        $session = JFactory::getSession();
        $filter = $session->get('AdminPrivilegesFilterSearch', false);

        if($filter == false){
            $filter = new stdClass();
            $filter->search = '';
            $filter->ordering ='id DESC';
            $filter->limit = '10';
            $session->set('AdminPrivilegesFilterSearch', $filter);
        }

        $model = $this->getModel('privileges');

        $rows = $model->getListItems($filter);
        $privileges = $model->getPrivileges();

        $view = $this->getView('privileges','html');
        $view->setLayout('default');
        $view->assignRef('privileges',$privileges);
        $view->assignRef('rows',$rows);
        $view->assignRef('filter',$filter);
        $view->display();
    }

    function edit( $cachable = false, $urlparams = array() )
    {
        JToolBarHelper::title('Новая привелегия');
        JToolBarHelper::save();
        JToolBarHelper::back();

        $app = JFactory::getApplication();
        $id = $app->input->getInt('id', null);

        $model = $this->getModel('privileges');
        $form = $model->getForm();
        $row = $model->getItem($id);

        $view = $this->getView('privileges','html');
        $view->setLayout('edit');
        $view->assignRef('row',$row);
        $view->assignRef('form',$form);
        $view->display();
    }

    function save( $cachable = false, $urlparams = array() )
    {
        JToolBarHelper::title('Новая привелегия');
        JToolBarHelper::save();
        JToolBarHelper::back();

        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        $app = JFactory::getApplication();
        $data = $app->input->get('jform', array(), 'array');
        $model = $this->getModel('privileges');
        $form = $model->getForm();

        $data = DopFunction::arrayToObjects($data['myFieldset']);

        $validate = $model->validate($data);

        if(!$validate['status']){

            $app->enqueueMessage($validate['text'], 'warning');
            $view = $this->getView('privileges','html');
            $view->setLayout('edit');
            $view->assignRef('row',$data);
            $view->assignRef('form',$form);
            $view->display();

        }else{

            if($model->save($data)){

                $app->enqueueMessage('Сохранено');
                $app->Redirect('index.php?option=com_shoppingoverview&controller=privileges');

            }else{

                $app->enqueueMessage('Не сохранилось', 'warning');
                $app->Redirect('index.php?option=com_shoppingoverview&controller=privileges');

            }

        }

    }

    function remove(){
        $app = JFactory::getApplication();
        $data = $app->input->get('cid', array(), 'array');
        $model = $this->getModel('privileges');

        if(count($data) > 0){

            $model->remove($data);
            $app->enqueueMessage('Удалено');
            $app->Redirect('index.php?option=com_shoppingoverview&controller=privileges');

        }else{

            $app->enqueueMessage('Нечего не выбрано', 'warning');
            $app->Redirect('index.php?option=com_shoppingoverview&controller=privileges');

        }
    }

    function publish(){
        $app = JFactory::getApplication();
        $data = $app->input->get('cid', array(), 'array');
        $model = $this->getModel('privileges');

        if(count($data) > 0){

            $model->publish($data);
            $app->enqueueMessage('Опубликовано');
            $app->Redirect('index.php?option=com_shoppingoverview&controller=privileges');

        }else{

            $app->enqueueMessage('Нечего не выбрано', 'warning');
            $app->Redirect('index.php?option=com_shoppingoverview&controller=privileges');

        }
    }

    function unpublish(){
        $app = JFactory::getApplication();
        $data = $app->input->get('cid', array(), 'array');
        $model = $this->getModel('privileges');

        if(count($data) > 0){

            $model->unpublish($data);
            $app->enqueueMessage('Снято с публикации');
            $app->Redirect('index.php?option=com_shoppingoverview&controller=privileges');

        }else{

            $app->enqueueMessage('Нечего не выбрано', 'warning');
            $app->Redirect('index.php?option=com_shoppingoverview&controller=privileges');

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
        $session->set('AdminPrivilegesFilterSearch', $data);
        $app->Redirect('index.php?option=com_shoppingoverview&controller=privileges');
    }

    function ajaxGetItems(){
        header('Content-Type: application/json');
        $result = array('error' => 0, 'result' => '', 'count' => '');

        $app = JFactory::getApplication();
        $count = $app->input->get('count', null, 'int');
        if($count == 0){ $count = null; }

        $session = JFactory::getSession();
        $filter = $session->get('AdminPrivilegesFilterSearch', false);
        $model = $this->getModel('privileges');
        $this->privileges = $model->getPrivileges();

        if($filter->limit != 0) {

            $rows = $model->getListItems($filter, $count);
            $result['count'] = $count + $filter->limit;

            ob_start();
            require_once(dirname(dirname(__FILE__)) . '/views/privileges/tmpl/items.php');
            $result['result'] = ob_get_contents();
            ob_end_clean();

        }

        echo json_encode($result);
        exit();
    }

}
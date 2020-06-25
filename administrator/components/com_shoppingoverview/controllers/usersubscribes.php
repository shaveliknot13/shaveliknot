<?php

// No direct access
defined( '_JEXEC' ) or die;

class ShoppingoverviewControllersUsersubscribes extends JControllerLegacy
{

    function display( $cachable = false, $urlparams = array() )
    {
        JToolBarHelper::title('Подписчики авторов');
        JToolBarHelper::addNew('.edit');
        JToolBarHelper::deleteList();
        JToolBarHelper::custom( '.publish', 'publish', 'publish', 'Подписать', false, false );
        JToolBarHelper::custom( '.unpublish', 'unpublish', 'unpublish', 'Отписать', false, false );
        JToolBarHelper::divider();
        JToolBarHelper::preferences('com_shoppingoverview');

        $session = JFactory::getSession();
        $filter = $session->get('AdminUsersubscribesFilterSearch', false);

        if($filter == false){
            $filter = new stdClass();
            $filter->search = '';
            $filter->ordering ='id DESC';
            $filter->limit = '10';
            $session->set('AdminUsersubscribesFilterSearch', $filter);
        }

        $model = $this->getModel('usersubscribes');
        $rows = $model->getListItems($filter);

        $view = $this->getView('usersubscribes','html');
        $view->setLayout('default');
        $view->assignRef('rows',$rows);
        $view->assignRef('filter',$filter);
        $view->display();
    }

    function edit( $cachable = false, $urlparams = array() )
    {
        JToolBarHelper::title('Подписать пользователя на автора');
        JToolBarHelper::save();
        JToolBarHelper::back();

        $app = JFactory::getApplication();
        $id = $app->input->getInt('id', null);

        $model = $this->getModel('usersubscribes');
        $form = $model->getForm();
        $row = $model->getItem($id);

        $view = $this->getView('usersubscribes','html');
        $view->setLayout('edit');
        $view->assignRef('row',$row);
        $view->assignRef('form',$form);
        $view->display();
    }

    function save( $cachable = false, $urlparams = array() )
    {
        JToolBarHelper::title('Подписать пользователя на автора');
        JToolBarHelper::save();
        JToolBarHelper::back();

        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        $app = JFactory::getApplication();
        $data = $app->input->get('jform', array(), 'array');
        $model = $this->getModel('usersubscribes');
        $form = $model->getForm();

        $data = DopFunction::arrayToObjects($data['myFieldset']);

        $validate = $model->validate($data);

        if(!$validate['status']){

            $app->enqueueMessage($validate['text'], 'warning');
            $view = $this->getView('usersubscribes','html');
            $view->setLayout('edit');
            $view->assignRef('row',$data);
            $view->assignRef('form',$form);
            $view->display();

        }else{

            if($model->save($data)){

                $app->enqueueMessage('Сохранено');
                $app->Redirect('index.php?option=com_shoppingoverview&controller=usersubscribes');

            }else{

                $app->enqueueMessage('Не сохранилось', 'warning');
                $app->Redirect('index.php?option=com_shoppingoverview&controller=usersubscribes');

            }

        }

    }

    function remove(){
        $app = JFactory::getApplication();
        $data = $app->input->get('cid', array(), 'array');
        $model = $this->getModel('usersubscribes');

        if(count($data) > 0){

            $model->remove($data);
            $app->enqueueMessage('Удалено');
            $app->Redirect('index.php?option=com_shoppingoverview&controller=usersubscribes');

        }else{

            $app->enqueueMessage('Нечего не выбрано', 'warning');
            $app->Redirect('index.php?option=com_shoppingoverview&controller=usersubscribes');

        }
    }

    function publish(){
        $app = JFactory::getApplication();
        $data = $app->input->get('cid', array(), 'array');
        $model = $this->getModel('usersubscribes');

        if(count($data) > 0){

            $model->publish($data);
            $app->enqueueMessage('Опубликовано');
            $app->Redirect('index.php?option=com_shoppingoverview&controller=usersubscribes');

        }else{

            $app->enqueueMessage('Нечего не выбрано', 'warning');
            $app->Redirect('index.php?option=com_shoppingoverview&controller=usersubscribes');

        }
    }

    function unpublish(){
        $app = JFactory::getApplication();
        $data = $app->input->get('cid', array(), 'array');
        $model = $this->getModel('usersubscribes');

        if(count($data) > 0){

            $model->unpublish($data);
            $app->enqueueMessage('Снято с публикации');
            $app->Redirect('index.php?option=com_shoppingoverview&controller=usersubscribes');

        }else{

            $app->enqueueMessage('Нечего не выбрано', 'warning');
            $app->Redirect('index.php?option=com_shoppingoverview&controller=usersubscribes');

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
        $session->set('AdminUsersubscribesFilterSearch', $data);
        $app->Redirect('index.php?option=com_shoppingoverview&controller=usersubscribes');
    }

    function ajaxGetItems(){
        header('Content-Type: application/json');
        $result = array('error' => 0, 'result' => '', 'count' => '');

        $app = JFactory::getApplication();
        $count = $app->input->get('count', null, 'int');
        if($count == 0){ $count = null; }

        $session = JFactory::getSession();
        $filter = $session->get('AdminUsersubscribesFilterSearch', false);
        $model = $this->getModel('usersubscribes');

        if($filter->limit != 0) {

            $rows = $model->getListItems($filter, $count);
            $result['count'] = $count + $filter->limit;

            ob_start();
            require_once(dirname(dirname(__FILE__)) . '/views/usersubscribes/tmpl/items.php');
            $result['result'] = ob_get_contents();
            ob_end_clean();

        }

        echo json_encode($result);
        exit();
    }

}
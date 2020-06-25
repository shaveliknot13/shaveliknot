<?php

// No direct access
defined( '_JEXEC' ) or die;

class ShoppingoverviewControllersAdvertisings extends JControllerLegacy
{

    function display( $cachable = false, $urlparams = array() )
    {
        JToolBarHelper::title('Реклама');
        JToolBarHelper::addNew('.edit');
        JToolBarHelper::deleteList();
        JToolBarHelper::publish();
        JToolBarHelper::unpublish();
        JToolBarHelper::divider();
        JToolBarHelper::preferences('com_shoppingoverview');

        $session = JFactory::getSession();
        $filter = $session->get('AdminAdvertisingsFilterSearch', false);

        if($filter == false){
            $filter = new stdClass();
            $filter->search = '';
            $filter->ordering ='id DESC';
            $filter->limit = '10';
            $session->set('AdminAdvertisingsFilterSearch', $filter);
        }

        $model = $this->getModel('advertisings');

        $rows = $model->getListItems($filter);
        $advertisings = $model->getAdvertisings();

        $view = $this->getView('advertisings','html');
        $view->setLayout('default');
        $view->assignRef('advertisings',$advertisings);
        $view->assignRef('rows',$rows);
        $view->assignRef('filter',$filter);
        $view->display();

    }

    function edit( $cachable = false, $urlparams = array() )
    {
        JToolBarHelper::title('Новая реклама');
        JToolBarHelper::save();
        JToolBarHelper::back();

        $app = JFactory::getApplication();
        $id = $app->input->getInt('id', null);

        $model = $this->getModel('advertisings');
        $form = $model->getForm();
        $row = $model->getItem($id);

        $view = $this->getView('advertisings','html');
        $view->setLayout('edit');
        $view->assignRef('row',$row);
        $view->assignRef('form',$form);
        $view->display();
    }

    function save( $cachable = false, $urlparams = array() )
    {
        JToolBarHelper::title('Новая реклама');
        JToolBarHelper::save();
        JToolBarHelper::back();

        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        $app = JFactory::getApplication();
        $data = $app->input->get('jform', array(), 'array');
        $model = $this->getModel('advertisings');
        $form = $model->getForm();

        $data = DopFunction::arrayToObjects($data['myFieldset']);

        $validate = $model->validate($data);

        if(!$validate['status']){

            $app->enqueueMessage($validate['text'], 'warning');
            $view = $this->getView('advertisings','html');
            $view->setLayout('edit');
            $view->assignRef('row',$data);
            $view->assignRef('form',$form);
            $view->display();

        }else{

            if($model->save($data)){

                $app->enqueueMessage('Сохранено');
                $app->Redirect('index.php?option=com_shoppingoverview&controller=advertisings');

            }else{

                $app->enqueueMessage('Не сохранилось', 'warning');
                $app->Redirect('index.php?option=com_shoppingoverview&controller=advertisings');

            }

        }

    }

    function remove(){
        $app = JFactory::getApplication();
        $data = $app->input->get('cid', array(), 'array');
        $model = $this->getModel('advertisings');

        if(count($data) > 0){

            $model->remove($data);
            $app->enqueueMessage('Удалено');
            $app->Redirect('index.php?option=com_shoppingoverview&controller=advertisings');

        }else{

            $app->enqueueMessage('Нечего не выбрано', 'warning');
            $app->Redirect('index.php?option=com_shoppingoverview&controller=advertisings');

        }
    }

    function publish(){
        $app = JFactory::getApplication();
        $data = $app->input->get('cid', array(), 'array');
        $model = $this->getModel('advertisings');

        if(count($data) > 0){

            $model->publish($data);
            $app->enqueueMessage('Опубликовано');
            $app->Redirect('index.php?option=com_shoppingoverview&controller=advertisings');

        }else{

            $app->enqueueMessage('Нечего не выбрано', 'warning');
            $app->Redirect('index.php?option=com_shoppingoverview&controller=advertisings');

        }
    }

    function unpublish(){
        $app = JFactory::getApplication();
        $data = $app->input->get('cid', array(), 'array');
        $model = $this->getModel('advertisings');

        if(count($data) > 0){

            $model->unpublish($data);
            $app->enqueueMessage('Снято с публикации');
            $app->Redirect('index.php?option=com_shoppingoverview&controller=advertisings');

        }else{

            $app->enqueueMessage('Нечего не выбрано', 'warning');
            $app->Redirect('index.php?option=com_shoppingoverview&controller=advertisings');

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
        $session->set('AdminAdvertisingsFilterSearch', $data);
        $app->Redirect('index.php?option=com_shoppingoverview&controller=advertisings');
    }

    function ajaxGetItems(){
        header('Content-Type: application/json');
        $result = array('error' => 0, 'result' => '', 'count' => '');

        $app = JFactory::getApplication();
        $count = $app->input->get('count', null, 'int');
        if($count == 0){ $count = null; }

        $session = JFactory::getSession();
        $filter = $session->get('AdminAdvertisingsFilterSearch', false);
        $model = $this->getModel('advertisings');
        $this->advertisings = $model->getAdvertisings();

        if($filter->limit != 0) {

            $rows = $model->getListItems($filter, $count);
            $result['count'] = $count + $filter->limit;

            ob_start();
            require_once(dirname(dirname(__FILE__)) . '/views/advertisings/tmpl/items.php');
            $result['result'] = ob_get_contents();
            ob_end_clean();

        }

        echo json_encode($result);
        exit();
    }

}
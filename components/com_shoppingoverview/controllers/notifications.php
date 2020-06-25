<?php

// No direct access
defined( '_JEXEC' ) or die;

class ShoppingoverviewControllerNotifications extends JControllerLegacy
{

    function __construct( $config = array() )
    {
        $app = JFactory::getApplication();
        $task = $app->input->get('task','display');
        $user = JFactory::getUser();
        $needcheck = 0;

        switch ($task) {
            case 'display':
                $needcheck = 1;
                break;
            case 'save':
                $needcheck = 1;
                break;
        }

        if($needcheck == 1 && $user->get('guest') == 1){
            $app->enqueueMessage(JText::_('COM_SHOPPINGOVERVIEW_LOG_IN_TO_THE_SITE'), 'warning');
            $app->Redirect('/');
        }

        parent::__construct( $config );
    }

    function display( $cachable = false, $urlparams = array() ){

        $doc    = JFactory::getDocument();
        $user   = JFactory::getUser();

        $lang =  shoppingoverviewSiteHelper::getPerfixLang($doc->getlanguage());

        $model = $this->getModel('notifications');

        $rows = $model->getListNotifications();
        $setting = $model->getUserNotifications($user->id);

        shoppingoverviewSiteHelper::setDocument( JText::_('Настройка уведомлений') );

        $view = $this->getView('notifications','html');
        $view->setLayout('default');
        $view->assignRef('rows',$rows);
        $view->assignRef('setting',$setting);
        $view->assignRef('lang',$lang);
        $view->display();

    }

    function save( $cachable = false, $urlparams = array() )
    {

        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        $doc = & JFactory::getDocument();
        $app = JFactory::getApplication();
        $data = $app->input->get('jform', array(), 'array');

        $model = $this->getModel('notifications');

        $user   = JFactory::getUser();
        $lang =  shoppingoverviewSiteHelper::getPerfixLang($doc->getlanguage());

        $data['user_id'] = $user->id;
        $data = DopFunction::arrayToObjects($data);

        $model->save($data);

        $app->enqueueMessage(JText::_('COM_SHOPPINGOVERVIEW_SAVED'));
        $app->Redirect('/notifications');


    }

    function cron(){

        $app = JFactory::getApplication();

        $password = $app->input->getString('password', null);

        $params = &JComponentHelper::getParams('com_shoppingoverview');

        if($params->get('password_cron') != $password){
            die("ERROR");
        }

        $template = $app->input->getString('template', null);

        $modelTags = $this->getModel('tags');
        $modelImages = $this->getModel('images');
        $modelAvertisings = $this->getModel('advertisings');
        $modelNotifications = $this->getModel('notifications');
        $modelNotifications->notifications($template);

        die("OK");

    }


}
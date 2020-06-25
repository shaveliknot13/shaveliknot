<?php

// No direct access
defined( '_JEXEC' ) or die;

class ShoppingoverviewControllerCrosspostings extends JControllerLegacy
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

        $app = JFactory::getApplication();
        $app->Redirect('/');

    }


    function cron(){

        $app = JFactory::getApplication();

        $password = $app->input->getString('password', null);

        $params = &JComponentHelper::getParams('com_shoppingoverview');

        if($params->get('password_cron') != $password){
            die("ERROR");
        }

        $modelFacebook = $this->getModel('crosspostingsfacebook');

        $modelFacebook->setItems();

        die("OK");

    }


}
<?php

// No direct access
defined( '_JEXEC' ) or die;

class ShoppingoverviewControllerUsersubscribes extends JControllerLegacy
{

    function __construct( $config = array() )
    {
        $app = JFactory::getApplication();
        $task = $app->input->get('task','display');
        $user = JFactory::getUser();
        $needcheck = 0;

        switch ($task) {
            case 'getTags':
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

    public function ajaxSubscribe()
    {
        header('Content-Type: application/json');
        $app = JFactory::getApplication();
        $id = $app->input->getInt('id', 0);
        $user = JFactory::getUser();
        $resultArr = array();

        $model = $this->getModel('usersubscribes');

        if(!$user->guest && $id != 0 ){

            if($id == $user->id ){
                $resultArr['errors'] = JText::_('COM_SHOPPINGOVERVIEW_YOU_CAN_NOT_SUBSCRIBE_TO_YOURSELF');
                echo json_encode($resultArr);
                exit();
            }

            $result = $model->userSubscribe($id,$user->id);

            if( !empty($result) ){

                if($result->published == 1){
                    $resultArr['result'] = 'unsubscribe';
                    $amq = 0;
                }else{
                    $resultArr['result'] = 'subscribe';
                    $amq = 1;
                }

                $model->userSubscribeUpdate($id,$user->id,$amq);

            }else{

                $model->userSubscribeInsert($id,$user->id);

                $resultArr['result'] = 'subscribe';

            }

        }else{
            $resultArr['errors'] = JText::_('COM_SHOPPINGOVERVIEW_LOG_IN_TO_THE_SITE');
        }

        echo json_encode($resultArr);
        exit();
    }


}
<?php

// No direct access
defined( '_JEXEC' ) or die;

class ShoppingoverviewControllerFavorites extends JControllerLegacy
{

    function __construct( $config = array() )
    {
        $app = JFactory::getApplication();
        $task = $app->input->get('task','display');
        $user = JFactory::getUser();
        $needcheck = 0;

        switch ($task) {
            case 'createCatFavorites':
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

    public function ajaxFavorites()
    {
        header('Content-Type: application/json');

        $app = JFactory::getApplication();
        $id = $app->input->getInt('id', 0);
        $user = JFactory::getUser();
        $resultArr = array();

        if($user->guest){
            $resultArr['errors'] = JText::_('COM_SHOPPINGOVERVIEW_LOG_IN_TO_THE_SITE');
            echo json_encode($resultArr);
            exit();
        }

        $model = $this->getModel('favorites');


        if($id != 0) {
            $result = $model->itemFavorite($id, $user);

            if (!empty($result)) {

                if ($result->published == 1) {
                    $resultArr['result'] = 'unfavorite';
                    $model->itemFavoriteUpdate($id, 0, $user);
                } else {
                    $resultArr['result'] = 'favorite';
                    $model->itemFavoriteUpdate($id, 1, $user);
                }

            } else {

                $model->itemFavoriteInsert($id, $user);
                $resultArr['result'] = 'favorite';

            }
        }


        echo json_encode($resultArr);
        exit();
    }


}
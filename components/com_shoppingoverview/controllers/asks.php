<?php
// No direct access
defined( '_JEXEC' ) or die;


/**
 * Controller
 * @author Воропаев Валентин
 */


class ShoppingoverviewControllerAsks extends JControllerLegacy
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
            case 'edit':
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

    function display( $cachable = false, $urlparams = array() )
    {
        $this->edit();
    }

    function edit( $cachable = false, $urlparams = array() )
    {

        $doc = &JFactory::getDocument();
        $app = JFactory::getApplication();
        $lang =  shoppingoverviewSiteHelper::getPerfixLang($doc->getlanguage());
        shoppingoverviewSiteHelper::setDocument( 'addAsks' );

        $data = $app->getUserState('com_shoppingoverview.editAsks.data');

        $model = $this->getModel('asks');
        $modelAvertisings = $this->getModel('advertisings');
        $form = $model->getForm();

        if(!empty($data)){
            $row = $data;
            $app->setUserState('com_shoppingoverview.editAsks.data', null);
        }

        $view = $this->getView('asks','html');
        $view->setLayout('edit');
        $view->assignRef('row',$row);
        $view->assignRef('form',$form);
        $view->assignRef('lang',$lang);
        $view->assignRef('modelAvertisings',$modelAvertisings);
        $view->display();

    }


    function save( $cachable = false, $urlparams = array() )
    {

        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        $doc = & JFactory::getDocument();
        $app = JFactory::getApplication();
        $data = $app->input->get('jform', array(), 'array');
        $model = $this->getModel('asks');

        $user   = JFactory::getUser();
        $lang =  shoppingoverviewSiteHelper::getPerfixLang($doc->getlanguage());

        $data['myFieldset']['user_id'] = $user->id;

        $data = DopFunction::arrayToObjects($data['myFieldset']);

        // валидация общих данных
        $validate = $model->validate($data);

        if(!$validate['status']){

            $app->enqueueMessage($validate['text'], 'warning');
            $app->setUserState('com_shoppingoverview.editAsks.data', $data);
            $app->Redirect('index.php?option=com_shoppingoverview&controller=asks&task=edit');

        }else{

            $idItem = $model->save($data);

            if($idItem){

                $app->enqueueMessage(JText::_('COM_SHOPPINGOVERVIEW_SAVED'));
                $app->Redirect('index.php?option=com_shoppingoverview&controller=asks&task=edit');

            }else{

                $app->enqueueMessage(JText::_('COM_SHOPPINGOVERVIEW_NOT_SAVED'), 'warning');
                $app->Redirect('index.php?option=com_shoppingoverview&controller=asks&task=edit');

            }

        }

    }



}
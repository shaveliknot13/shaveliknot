<?php

// No direct access
defined( '_JEXEC' ) or die;

/**
 * @author Воропаев Валентин
 */

jimport('joomla.application.component.modellist');

class ShoppingoverviewModelAsks extends JModelAdmin
{

    const TABLE = '#__shoppingoverview_asks';
    public $db;


    public function __construct($config = array())
    {

        parent::__construct($config);

        $params = &JComponentHelper::getParams('com_shoppingoverview');

        $option             = array();                      //Инициализация
        $option['driver']   = $params->get('bd_driver');    // Имя драйвера БД
        $option['host']     = $params->get('bd_host');      // Хост БД
        $option['user']     = $params->get('bd_user');      // Имя пользователя
        $option['password'] = $params->get('bd_password');  // Пароль
        $option['database'] = $params->get('bd_database');  // Имя БД
        $option['prefix']   = $params->get('bd_prefix');    // префикс (может быть пустым)

        $db = & JDatabase::getInstance( $option );
        parent::setDbo($db);
        $this->db = parent::getDbo();
    }

    public function getForm( $data = array(), $loadData = true )
    {
        $form = $this->loadForm( 'com_shoppingoverview.asks', 'asks', array( 'control' => 'jform', 'load_data' => $loadData ) );
        if ( empty( $form ) ) {
            return false;
        }
        return $form;
    }


    public function save($data,$privilege=array()){

        $data->created = date('Y-m-d H:i:s');

        $database = $this->db;


        $database->setQuery('INSERT INTO '.self::TABLE.'
        (
        `user_id`,
        `link`,
        `text`,
        `created`
        )
        VALUES
        (
        '.$database->quote($data->user_id).',
        '.$database->quote($data->link).',
        '.$database->quote($data->text).',
        '.$database->quote($data->created).'
        )
        ');


        if($database->query()){
            return $database->insertid();
        }else{
            return false;
        }

    }


    public function validate($data){

        $error = array();
        $error['text'] = "";
        $error['status'] = true;

        if(empty($data->link)){
            $error['text'] .= JText::_('COM_SHOPPINGOVERVIEW_TEXT_53')."<br/>";
            $error['status'] = false;
        }

        return $error;

    }



}
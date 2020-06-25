<?php

// No direct access
defined( '_JEXEC' ) or die;

/**
 *@author Воропаев Валентин
 */
jimport('joomla.application.component.modellist');

class ShoppingoverviewModelPrivilege extends JModelList
{

    const TABLE = '#__shoppingoverview_privileges';
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
        $this->db = parent::getDbo();;
    }


    public function getPrivilege($user_id){
        $database = $this->db;
        $amx = 'SELECT * FROM '.self::TABLE.' WHERE user_id='.$database->quote($user_id);
        $database->setQuery($amx);
        $result = $database->loadObject();

        if($result){
            $result = unserialize($result->privilege);
            return $result;
        }else{
            return array();
        }

    }

}
<?php

jimport('joomla.application.component.modellist');

class ShoppingoverviewModuleModelCategories extends JModelList
{

    const TABLE = '#__shoppingoverview_categories';
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


    public function getListAll($params){

        $database = $this->db;

        $sql = '
          SELECT *
          FROM '.self::TABLE.'
          WHERE published = 1
          ORDER BY id DESC
        ';

        $database->setQuery($sql);
        $result = $database->loadObjectList();

        return $result;
    }


}
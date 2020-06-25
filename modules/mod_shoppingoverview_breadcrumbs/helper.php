<?php

jimport('joomla.application.component.modellist');

class ShoppingoverviewModuleModelBreadcrumbs extends JModelList
{

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

    public function getCategory($item){
        $database = $this->db;

        $sql = '
          SELECT *
          FROM #__shoppingoverview_categories
          WHERE published = 1 AND alias = '.$database->quote($item).'
          ORDER BY id DESC
          LIMIT 1
        ';

        $database->setQuery($sql);
        $result = $database->loadObject();

        return $result;
    }

    public function getProduct($item, $lang){

        $database = $this->db;

        $sql = '
          SELECT product
          FROM #__shoppingoverview_items
          WHERE published = 1 AND trash = 0 AND alias_'.$lang.' = '.$database->quote($item).'
          ORDER BY id DESC
          LIMIT 1
        ';

        $database->setQuery($sql);
        $result = $database->loadObject();

        return $result;

    }

}
<?php

jimport('joomla.application.component.modellist');

class ShoppingoverviewModuleModelCategoriesfilter extends JModelList
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

    public function getListCategories(){

        $app = JFactory::getApplication();
        $cat_alias = $app->input->get('cat_alias', '', 'string');
        $cat_alias = str_replace(':','-',$cat_alias);

        $database = $this->db;

        $sql = '
          SELECT *
          FROM #__shoppingoverview_categories
          WHERE published = 1 AND alias = '.$database->quote($cat_alias).'
          ORDER BY id DESC
        ';

        $database->setQuery($sql);
        $result = $database->loadObject();

        return $result;
    }


}

class ModShoppingoverviewСategoriesfilterHelper {


    public static function getPerfixLang($lang='ru'){

        if($lang == "ru-ru"){
            $lang = "ru";
        }elseif($lang == "en-gb"){
            $lang = "en";
        }elseif($lang == "he-il"){
            $lang = "he";
        }

        return $lang;

    }

}
<?php

jimport('joomla.application.component.modellist');

class ShoppingoverviewModuleModelFavorites extends JModelList
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



    public function itemFavoriteCat($user){

        $database = $this->db;

        $amx = "
            SELECT
            cats.*,
            count(favs.id) AS countfavorite
            FROM #__shoppingoverview_categories AS cats
            LEFT JOIN #__shoppingoverview_items AS items ON (items.cat_id = cats.id)
            LEFT JOIN #__shoppingoverview_favorites AS favs ON (favs.post_id = items.id)
            WHERE cats.published = 1 AND items.published = 1 AND favs.user_id=".$database->quote($user->id)." AND favs.published = 1
            GROUP BY cats.id
            ORDER BY cats.id DESC
        ";

        $database->setQuery($amx);

        $result = $database->loadObjectList();

        return $result;
    }

}


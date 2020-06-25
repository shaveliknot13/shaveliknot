<?php

// No direct access
defined( '_JEXEC' ) or die;

/**
 * Model to see the current entries
 * @author Воропаев Валентин
 */
class ShoppingoverviewModelSitemap extends JModelList
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
        $this->db = parent::getDbo();
    }

    public function getCategories(){

        $database = $this->db;

        $database->setQuery('
          SELECT *
          FROM #__shoppingoverview_categories
          WHERE published = 1
        ');

        $result = $database->loadObjectList();

        return $result;
    }

    public function getItems(){

        $database = $this->db;

        $sql = '
          SELECT
            item.*,
            cat.alias AS cat_alias
          FROM #__shoppingoverview_items item
          LEFT JOIN #__shoppingoverview_categories cat ON (cat.id = item.cat_id)
          WHERE
            cat.published = 1
          AND
            item.published = 1
          AND
            item.trash = 0
          GROUP BY item.id
          ORDER BY item.id DESC
        ';

        $database->setQuery($sql);
        $result = $database->loadObjectList();

        return $result;
    }

    public function getTags(){
        $database = $this->db;

        $sql = '
          SELECT *
          FROM #__shoppingoverview_tags
          WHERE published = 1
          ORDER BY id DESC
        ';

        $database->setQuery($sql);
        $result = $database->loadObjectList();

        return $result;
    }

    public function getAuthors(){
        $database = JFactory::getDBO();

        $sql = '
          SELECT *
          FROM #__users
          WHERE block = 0
          ORDER BY id DESC
        ';

        $database->setQuery($sql);
        $result = $database->loadObjectList();

        return $result;
    }

}
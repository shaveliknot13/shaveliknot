<?php

// No direct access
defined( '_JEXEC' ) or die;

/**
 * @author Воропаев Валентин
 */

jimport('joomla.application.component.modellist');

class ShoppingoverviewModelSearch extends JModelList
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

    public function getListTags($search,$lang= 'en',$count = 0, $returnCount = false){
        $database = $this->db;

        $sql = '
          SELECT 
        ';
        if($returnCount == true) {
            $sql .= '
              SQL_CALC_FOUND_ROWS
            ';
        }
        $sql .= '
          *
          FROM #__shoppingoverview_tags
          WHERE
          (
          title LIKE '.$database->quote('%'.$search.'%').'
          OR
          title_'.$lang.' LIKE '.$database->quote('%'.$search.'%').'
          )
          AND published = 1
          ORDER BY id DESC
          LIMIT '.$count.', 10
        ';

        $database->setQuery($sql);
        $result = $database->loadObjectList();

        if($returnCount == true){
            $database->setQuery('SELECT FOUND_ROWS();');
            $result = $database->loadResult();
        }

        return $result;
    }

    public function getListTagsDop($search,$lang= 'en',$count = 0){
        $database = $this->db;

        $tags = $this->getListTags($search,$lang,$count);

        if(empty($tags)){
            return;
        }

        $tagsResult = array();

        foreach($tags as $item){
            $tagsResult[] = $item->id;
        }

        $ids = implode(',', $tagsResult);

        $database->setQuery('
          SELECT tags.id, tags.title, xref.post_id
          FROM #__shoppingoverview_tags_xref xref
          LEFT JOIN #__shoppingoverview_tags tags ON (xref.tag_id = tags.id)
          JOIN #__shoppingoverview_items items ON (items.id = xref.post_id AND items.published = 1 AND items.trash = 0)
          WHERE xref.tag_id IN ('.$ids.')
        ');

        $result = $database->loadObjectList();

        $itemsResult = array();

        foreach($result as $item){
            $itemsResult[] = $item->post_id;
        }

        $ids = implode(',', $itemsResult);

        return $ids;
    }

    public function getListUsers($search,$count = 0, $returnCount = false){
        $database = JFactory::getDBO();

        $sql = '
          SELECT 
        ';
        if($returnCount == true) {
            $sql .= '
              SQL_CALC_FOUND_ROWS
            ';
        }
        $sql .= ' *
          FROM #__users
          WHERE username LIKE '.$database->quote('%'.$search.'%').' AND block = 0
          ORDER BY id DESC
          LIMIT '.$count.', 10
        ';

        $database->setQuery($sql);
        $result = $database->loadObjectList();

        if($returnCount == true){
            $database->setQuery('SELECT FOUND_ROWS();');
            $result = $database->loadResult();
        }

        return $result;
    }

    public function getListUsersDop($search,$count = 0){

        $users = $this->getListUsers($search,$count);

        if(empty($users)){
            return;
        }

        $usersResult = array();

        foreach($users as $item){
            $usersResult[] = $item->id;
        }

        $ids = implode(',', $usersResult);

        $database = $this->db;

        $sql = '
          SELECT
            item.id
          FROM #__shoppingoverview_items item
          WHERE item.user_id IN ('.$ids.') AND item.published = 1 AND item.trash = 0
          GROUP BY item.user_id
          ORDER BY item.user_id DESC
        ';

        $database->setQuery($sql);
        $result = $database->loadObjectList();

        $itemsResult = array();

        foreach($result as $item){
            $itemsResult[] = $item->id;
        }

        $ids = implode(',', $itemsResult);

        return $ids;

    }

    public function getListTitles($search, $lang, $count = 0, $returnCount = false){
        $database = $this->db;

        $sql = '
          SELECT
        ';
        if($returnCount == true) {
            $sql .= '
              SQL_CALC_FOUND_ROWS
            ';
        }
        $sql .= 'item.*,
            cat.alias AS cat_alias
          FROM #__shoppingoverview_items item
          LEFT JOIN #__shoppingoverview_categories cat ON (cat.id = item.cat_id)
          WHERE CONCAT_WS(\' \',item.product,item.title_'.$lang.') LIKE '.$database->quote('%'.$search.'%').' AND item.published = 1 AND item.trash = 0
          ORDER BY item.id DESC
          LIMIT '.$count.', 10
        ';

        $database->setQuery($sql);
        $result = $database->loadObjectList();

        if($returnCount == true){
            $database->setQuery('SELECT FOUND_ROWS();');
            $result = $database->loadResult();
        }

        return $result;
    }

    public function getListTitlesDop($search, $lang, $count = 0){

        $titles = $this->getListTitles($search, $lang, $count);

        if(empty($titles)){
            return;
        }

        $titlesResult = array();

        foreach($titles as $item){
            $titlesResult[] = $item->id;
        }

        $ids = implode(',', $titlesResult);

        return $ids;
    }

    public function getItemsIds($ids)
    {

        if($ids == ""){
            return array();
        }

        $database = $this->db;

        $sql = '';
        $sql .= '
          SELECT
            items.*,
            cat.title_ru AS cattitle_ru,
            cat.title_en AS cattitle_en,
            cat.title_he AS cattitle_he,
            cat.alias AS cat_alias,
            del.title_ru AS deltitle_ru,
            del.title_en AS deltitle_en,
            del.title_he AS deltitle_he,
            COALESCE(SUM(lik.count), 0) AS countlike,
            COALESCE(SUM(com.count), 0) AS countcomment,
            count(fav.id) AS countfavorite
          FROM #__shoppingoverview_items items
          LEFT JOIN #__shoppingoverview_categories cat ON (cat.id = items.cat_id)
          LEFT JOIN #__shoppingoverview_deliverys del ON (del.id = items.delivery_id)
          LEFT JOIN #__shoppingoverview_likes lik ON (lik.post_id = items.id)
          LEFT JOIN #__shoppingoverview_comments com ON (com.post_id = items.id)
          LEFT JOIN #__shoppingoverview_favorites fav ON (fav.post_id = items.id AND fav.published = 1)
          WHERE
          items.published = 1
          AND
          items.trash = 0
          AND
          items.id IN ('.$ids.')
          GROUP BY items.id
          ORDER BY items.id DESC
        ';

        $database->setQuery($sql);

        $result = $database->loadObjectList();

        return $result;
    }



}
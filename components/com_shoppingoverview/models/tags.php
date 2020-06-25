<?php

// No direct access
defined( '_JEXEC' ) or die;

/**
 * @author Воропаев Валентин
 */

jimport('joomla.application.component.modellist');

class ShoppingoverviewModelTags extends JModelList
{

    const TABLE = '#__shoppingoverview_tags';
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

    public function getListItemsAjax($search,$lang,$limit = 7){


        $database = $this->db;

        $sql = '
          SELECT *
          FROM '.self::TABLE.'
          WHERE
          (
          title LIKE '.$database->quote('%'.$search.'%').'
          OR
          title_'.$lang.' LIKE '.$database->quote('%'.$search.'%').'
          )
          AND published = 1
          ORDER BY id DESC
          LIMIT '.$limit.'
        ';

        $database->setQuery($sql);
        $result = $database->loadObjectList();

        return $result;
    }

    public function getItemId($id=null){

        $database = $this->db;

        $database->setQuery('
          SELECT *
          FROM '.self::TABLE.'
          WHERE id = '.$database->quote($id).' AND published = 1
          LIMIT 1
        ');

        $result = $database->loadObject();

        return $result;
    }

    public function getItemsId($id=0,$count=0){

        $database = $this->db;

        $database->setQuery('
          SELECT tags.id, tags.title, xref.post_id
          FROM #__shoppingoverview_tags_xref xref
          LEFT JOIN '.self::TABLE.' tags ON (xref.tag_id = tags.id)
          JOIN #__shoppingoverview_items items ON (items.id = xref.post_id AND items.published = 1 AND items.trash = 0)
          WHERE xref.tag_id = '.$database->quote($id).'
          ORDER BY id DESC
          LIMIT '.$count.', 10
        ');

        $result = $database->loadObjectList();

        return $result;
    }

    public function getItemTitle($title=null){

        $database = $this->db;

        $database->setQuery('
          SELECT *
          FROM '.self::TABLE.'
          WHERE title = '.$database->quote($title).'
          LIMIT 1
        ');

        $result = $database->loadObject();

        return $result;
    }

    public function save($data){

        $database = $this->db;

        if(isset($data->id) && $data->id != ''){

            $database->setQuery('UPDATE '.self::TABLE.'
            SET
            title = '.$database->quote($data->title).',
            published = '.$database->quote($data->published).'
            WHERE id = '.$database->quote($data->id).'
            ');

        }else{

            $database->setQuery('INSERT INTO '.self::TABLE.'
            (
            `title`,
            `published`
            )
            VALUES
            (
            '.$database->quote($data->title).',
            '.$database->quote($data->published).'
            )
            ');

        }

        if($database->query()){
            if(isset($data->id) && $data->id != '') {
                return $data->id;
            }

            return $database->insertid();
        }else{
            return false;
        }

    }

    public function getCommunications($idItem){

        $database = $this->db;

        $sql = '
          SELECT tags.*
          FROM #__shoppingoverview_tags_xref xref
          LEFT JOIN '.self::TABLE.' tags ON (xref.tag_id = tags.id)
          WHERE xref.post_id = '.$database->quote($idItem).'
        ';

        $database->setQuery($sql);

        $result = $database->loadObjectList();

        return $result;

    }

    public function saveCommunications($idTag,$idItem){

        $database = $this->db;

        $database->setQuery('INSERT INTO #__shoppingoverview_tags_xref
            (
            `tag_id`,
            `post_id`
            )
            VALUES
            (
            '.$database->quote($idTag).',
            '.$database->quote($idItem).'
            )
            ');

        if($database->query()){
            return true;
        }else{
            return false;
        }

    }

    public function deleteCommunications($idItem){

        $database = $this->db;

        $sql = 'DELETE FROM #__shoppingoverview_tags_xref WHERE post_id = '.$database->quote($idItem);

        $database->setQuery($sql);

        if($database->query()){
            return true;
        }else{
            return false;
        }

    }

    // Сохраняем связь с обзорами и тегами
    function saveList($idItem,$argv,$allowed=false){

        $this->deleteCommunications($idItem);

        foreach($argv as $item){

            $getItemTitle = $this->getItemTitle($item);

            if($getItemTitle != null){
                $this->saveCommunications($getItemTitle->id,$idItem);
            }

            if($getItemTitle == null && $allowed==true){

                $data = new stdClass();
                $data->title = $item;
                $data->published = 1;

                $idTag = $this->save($data);

                $this->saveCommunications($idTag,$idItem);
            }

        }

        return;

    }



}
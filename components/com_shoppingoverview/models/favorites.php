<?php

// No direct access
defined( '_JEXEC' ) or die;

/**
 *@author Воропаев Валентин
 */
class ShoppingoverviewModelFavorites extends JModelLegacy
{

    const TABLE = '#__shoppingoverview_favorites';
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

    public function itemFavorite($id=null,$user){

        $database = $this->db;

        $database->setQuery(
            'SELECT * FROM '.self::TABLE.' WHERE post_id='.$database->quote($id).' AND user_id='.$database->quote($user->id)
        );

        $result = $database->loadObject();

        return $result;
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

    public function itemFavoriteUpdate($id=null,$published,$user){

        $database = $this->db;
        $amx = 'UPDATE '.self::TABLE.' SET published='.$database->quote($published).' WHERE post_id='.$database->quote($id)." AND user_id=".$user->id;
        $database->setQuery($amx);
        $database->query();

    }

    public function itemFavoriteInsert($id=null,$user){

        $database = $this->db;
        $amx = 'INSERT INTO '.self::TABLE.'
                        (`post_id`,
                        `user_id`,
                        `published`)
                        VALUES
                        ('.$database->quote($id).',
                        '.$database->quote($user->id).',
                        '.$database->quote('1').')';
        $database->setQuery($amx);
        $database->query();

    }

    public function displayFavoritesMini($id=null,$user)
    {

        if(!$user->guest && $id != null ) {

            $result = $this->itemFavorite($id,$user);

            if ($result != null) {

                if ($result->published == 1) {
                    $amq = ' favorites';
                } else {
                    $amq = '';
                }
            }
        }else{
            $amq = '';
        }

        return $amq;
    }

    public function getUserFavoritesDop($user, $count=0, $cat_id=0){

        $database = $this->db;

        if(empty($cat_id)){
            $sql = '
              SELECT post_id FROM '.self::TABLE.' AS favs
              WHERE favs.published = 1 AND favs.user_id='.$database->quote($user->id).'
              ORDER BY id DESC
              LIMIT '.$count.', 10
            ';
        }else{
            $sql = '
              SELECT favs.post_id FROM '.self::TABLE.' AS favs
              LEFT JOIN #__shoppingoverview_items AS items ON (items.id = favs.post_id)
              LEFT JOIN #__shoppingoverview_categories AS cats ON (cats.id = items.cat_id)
              WHERE favs.published = 1 AND favs.user_id='.$database->quote($user->id).' AND items.cat_id='.$database->quote($cat_id).'  AND items.published = 1 AND cats.published = 1
              ORDER BY favs.id DESC
              LIMIT '.$count.', 10
            ';
        }

        //var_dump($sql);
        //die();

        $database->setQuery($sql);

        $result = $database->loadObjectList();

        $titlesResult = array();

        foreach($result as $item){
            $titlesResult[] = $item->post_id;
        }

        $ids = implode(',', $titlesResult);

        return $ids;
    }

    public function getUserFavorites($ids){

        $database = $this->db;

        if($ids == ""){
            return array();
        }

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
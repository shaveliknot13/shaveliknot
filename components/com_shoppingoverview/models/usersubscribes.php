<?php

// No direct access
defined( '_JEXEC' ) or die;

/**
 * @author Воропаев Валентин
 */

jimport('joomla.application.component.modellist');

class ShoppingoverviewModelUsersubscribes extends JModelList
{

    const TABLE = '#__shoppingoverview_user_subscribes';
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

    public function userSubscribe($primary_user_id=null,$user_id){

        $database = $this->db;

        $database->setQuery(
            'SELECT * FROM '.self::TABLE.' WHERE primary_user_id='.$database->quote($primary_user_id).' AND user_id='.$database->quote($user_id)
        );

        $result = $database->loadObject();

        return $result;
    }

    public function userSubscribeUpdate($primary_user_id,$user_id,$published){

        $database = $this->db;
        $amx = 'UPDATE '.self::TABLE.' SET published='.$database->quote($published).' WHERE primary_user_id='.$database->quote($primary_user_id).' AND user_id='.$database->quote($user_id);
        $database->setQuery($amx);
        $database->query();

    }

    public function userSubscribeInsert($primary_user_id,$user_id){

        $database = $this->db;
        $amx = 'INSERT INTO '.self::TABLE.'
                        (`primary_user_id`,
                        `user_id`,
                        `published`)
                        VALUES
                        ('.$database->quote($primary_user_id).',
                        '.$database->quote($user_id).',
                        '.$database->quote('1').')';
        $database->setQuery($amx);
        $database->query();

    }

    public function displaySubscribe($primary_user_id=null,$user)
    {

        if(!$user->guest && $primary_user_id != null ) {

            $result = $this->userSubscribe($primary_user_id,$user->id);

            if ($result != null) {

                if ($result->published == 1) {
                    $amq = 'subscribe';
                } else {
                    $amq = '';
                }
            }
        }else{
            $amq = '';
        }

        return $amq;
    }

    public function getUserSubscribesDop($user_id=null){

        $database = $this->db;

        $sql = '
          SELECT
          primary_user_id FROM '.self::TABLE.'
          WHERE published = 1 AND user_id='.$database->quote($user_id).'
          ORDER BY id DESC
        ';

        $database->setQuery($sql);

        $result = $database->loadObjectList();

        $titlesResult = array();

        foreach($result as $item){
            $titlesResult[] = $item->primary_user_id;
        }

        $ids = implode(',', $titlesResult);

        return $ids;
    }

    public function getUserSubscribse($ids,$count=0, $cat_id=0)
    {
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
          items.user_id IN ('.$ids.')
        ';

        if(!empty($cat_id)){
            $sql .= '
                AND
                items.cat_id ='.$database->quote($cat_id);
        }

        $sql .= '  
          GROUP BY items.id
          ORDER BY items.id DESC
          LIMIT '.$count.', 10
        ';

        $database->setQuery($sql);

        $result = $database->loadObjectList();

        return $result;
    }

    public function itemSubscribseCat($user_id = null){

        $database = $this->db;

        $amx = "
            SELECT
            cats.*,
            count(subs.id) AS countSubscribes
            FROM #__shoppingoverview_categories AS cats
            LEFT JOIN #__shoppingoverview_items AS items ON (items.cat_id = cats.id)
            LEFT JOIN #__shoppingoverview_user_subscribes AS subs ON (subs.primary_user_id = items.user_id)
            WHERE cats.published = 1 AND items.published = 1 AND subs.user_id=".$database->quote($user_id)." AND subs.published = 1
            GROUP BY cats.id
            ORDER BY cats.id DESC
        ";

        $database->setQuery($amx);

        $result = $database->loadObjectList();

        return $result;
    }

}
<?php

// No direct access
defined( '_JEXEC' ) or die;

/**
 * @author Воропаев Валентин
 */

jimport('joomla.application.component.modellist');

class ShoppingoverviewModelHits extends JModelList
{

    const TABLE = '#__shoppingoverview_hits';
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

    public function updateHits($post_id=null)
    {

        if (!empty($_SERVER['HTTP_CLIENT_IP'])){
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else{
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        $database = $this->db;
        $user = JFactory::getUser();

        $amx = 'SELECT id,date FROM '.self::TABLE.' WHERE post_id='.$database->quote($post_id);

        if($user->get('guest') != 1){
            $amx .= " AND user_id=".$database->quote($user->id);
        }else{
            $amx .= " AND ip=".$database->quote($ip)." AND user_id=0";
        }
        $amx .= ' LIMIT 1';

        $database->setQuery($amx);
        $result = $database->loadObject();

        if(empty($result)){

            $amx = 'INSERT INTO '.self::TABLE.'
                        (`user_id`,
                        `post_id`,
                        `ip`,
                        `date`)
                        VALUES
                        ('.$database->quote($user->id).',
                        '.$database->quote($post_id).',
                        '.$database->quote($ip).',
                        NOW())';
            $database->setQuery($amx);
            $database->query();

            $amx = 'UPDATE #__shoppingoverview_items SET hits=hits+1 WHERE id='.$database->quote($post_id);
            $database->setQuery($amx);
            $database->query();

        }else{

            $curDate = new DateTime();
            $diffDate = new DateTime($result->date);

            if($curDate->diff($diffDate)->format("%d") > 0){

                $amx = 'UPDATE '.self::TABLE.' SET date="'.date("Y-m-d H:i:s").'" WHERE id='.$database->quote($result->id);
                $database->setQuery($amx);
                $database->query();

                $amx = 'UPDATE #__shoppingoverview_items SET hits=hits+1 WHERE id='.$database->quote($post_id);
                $database->setQuery($amx);
                $database->query();

            }

        }

        return;

    }

    public function getUserHitsDop($user_id=null){

        $database = $this->db;

        $sql = '
          SELECT post_id FROM '.self::TABLE.'
          WHERE user_id='.$database->quote($user_id).'
          ORDER BY date DESC
        ';

        $database->setQuery($sql);

        $result = $database->loadObjectList();

        $titlesResult = array();

        foreach($result as $item){
            $titlesResult[] = $item->post_id;
        }

        $ids = implode(',', $titlesResult);

        return $ids;
    }

    public function getUserHits($ids, $count=0, $cat_id=0){

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

    public function itemHitsCat($user_id = null){

        $database = $this->db;

        $amx = "
            SELECT
            cats.*,
            count(hits.id) AS countHits
            FROM #__shoppingoverview_categories AS cats
            LEFT JOIN #__shoppingoverview_items AS items ON (items.cat_id = cats.id)
            LEFT JOIN #__shoppingoverview_hits AS hits ON (hits.post_id = items.id)
            WHERE cats.published = 1 AND items.published = 1 AND hits.user_id=".$database->quote($user_id)."
            GROUP BY cats.id
            ORDER BY cats.id DESC
        ";

        $database->setQuery($amx);

        $result = $database->loadObjectList();

        return $result;
    }

}
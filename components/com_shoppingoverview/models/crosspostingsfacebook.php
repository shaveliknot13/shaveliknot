<?php

defined( '_JEXEC' ) or die;

jimport('joomla.application.component.modellist');

class ShoppingoverviewModelCrosspostingsfacebook extends JModelList
{

    const TABLE = '#__shoppingoverview_items';
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

    public function setItems(){

        $database = $this->db;

        require_once __DIR__ . '/crosspostings/Facebook/autoload.php';

        // Выборка за день ранее
        $date_after_q = new DateTime(date("Y-m-d 00:00:00"));
        $date_before_q = new DateTime(date("Y-m-d 23:59:59"));

        $date_after = $date_after_q->modify('-1 day')->format("Y-m-d 00:00:00");
        $date_before = $date_before_q->modify('-1 day')->format("Y-m-d 23:59:59");

        $sql = '
          SELECT
            item.*,
            cat.title_ru AS cattitle_ru,
            cat.title_en AS cattitle_en,
            cat.title_he AS cattitle_he,
            cat.alias AS cat_alias,
            del.title_ru AS deltitle_ru,
            del.title_en AS deltitle_en,
            del.title_he AS deltitle_he,
            COALESCE(SUM(lik.count), 0) AS countlike,
            COALESCE(SUM(com.count), 0) AS countcomment
          FROM #__shoppingoverview_items item
          LEFT JOIN #__shoppingoverview_categories cat ON (cat.id = item.cat_id)
          LEFT JOIN #__shoppingoverview_deliverys del ON (del.id = item.delivery_id)
          LEFT JOIN #__shoppingoverview_likes lik ON (lik.post_id = item.id)
          LEFT JOIN #__shoppingoverview_comments com ON (com.post_id = item.id)
          WHERE
          item.published = 1
          AND
          item.trash = 0
          AND
          (item.created BETWEEN '.$database->quote($date_after).' AND '.$database->quote($date_before).')
          GROUP BY item.id
          ORDER BY item.id DESC
        ';

        $database->setQuery($sql);
        $result = $database->loadObjectList();

        $app_id = '1658713200805550'; // ид приложения. берешь в настройках приложения (или копируешь с адресной строки)
        $app_secret = 'f6528fafa4ade18cad7a9ce6f7063adb'; // ключ приложения. берешь в настройках приложения
        $access_token = 'EAAXkl0MeRq4BAKZCfOUdJQEYnilZA7ZCzzr2q6MQZCDwRn4WdVF8qCe4QTZAXYtVZB3sg5ZBqUBEAJ6iWRAaR7cstZCiwfCsRxpLKIk98bW2CyGmUwx1JXZA5I6KMGnNizZBN6MplOh1b3BlsPZAoDUeSpDiGN0GxveFKQTLRJKOHFNnAZDZD'; // токен, который мы получили
        $page_id = '102471041150960'; // id группы

        $fb = new Facebook\Facebook(array(
            'app_id' => $app_id,
            'app_secret' => $app_secret,
            'default_graph_version' => 'v4.0',
        ));
        $fb->setDefaultAccessToken($access_token);

        $batch = array();

        foreach ($result as $item){

            $message = empty(!$item->mini_text_ru) ? $item->mini_text_ru :  $item->product.' '.$item->{'title_ru'};

            $batch[$item->id] = $fb->request('POST', "/{$page_id}/feed",
                array(
                    'link' => 'http://shaveliknot.co.il/'.JRoute::_( 'index.php?option=com_shoppingoverview&cat_alias='.$item->cat_alias.'&item_alias='.$item->{'alias_ru'}.'&Itemid=101' ),
                    //'link' => JRoute::_( 'index.php?option=com_shoppingoverview&cat_alias='.$item->cat_alias.'&item_alias='.$item->{'alias_ru'}.'&Itemid=101', true, 1 ),
                    'message' => $message,
                )
            );

        }

        $responses = $fb->sendBatchRequest($batch);

    }

}
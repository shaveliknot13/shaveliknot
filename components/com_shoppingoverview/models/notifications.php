<?php

defined( '_JEXEC' ) or die;

jimport('joomla.application.component.modellist');

class ShoppingoverviewModelNotifications extends JModelList
{

    const TABLE = '#__shoppingoverview_notifications';
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



    public function save($data){

        $database = $this->db;

        $sql = '
          SELECT * FROM #__shoppingoverview_user_notifications
          WHERE user_id = '.$database->quote($data->user_id).'
          GROUP BY id
          ORDER BY id DESC
        ';

        $database->setQuery($sql);
        $result = $database->loadObject();

        $notifications = clone $data;
        unset($notifications->user_id);
        $notifications = DopFunction::convertJSNO($notifications);

        if(!empty($result)){

            $database->setQuery('UPDATE #__shoppingoverview_user_notifications
            SET
            notifications = '.$database->quote($notifications).'
            WHERE
            user_id = '.$database->quote($data->user_id).'
            ');

        }else{

            $database->setQuery('INSERT INTO #__shoppingoverview_user_notifications
            (
            `user_id`,
            `notifications`
            )
            VALUES
            (
            '.$database->quote($data->user_id).',
            '.$database->quote($notifications).'
            )
            ');

        }

        $database->query();

        return true;

    }

    public function getListNotifications(){
        $database = $this->db;

        $sql = '
          SELECT
            notif.*
          FROM '.self::TABLE.' notif
          WHERE
            notif.type = '.$database->quote('template').'
          AND
             notif.published = 1
          GROUP BY notif.id
          ORDER BY notif.id DESC
        ';

        $database->setQuery($sql);
        $result = $database->loadObjectList();

        return $result;
    }

    public function getUserNotifications($user_id){
        $database = $this->db;

        $sql = '
          SELECT
            notif.*
          FROM #__shoppingoverview_user_notifications notif
          WHERE
            notif.user_id = '.$database->quote($user_id).'
          GROUP BY notif.id
          ORDER BY notif.id DESC
          LIMIT 1
        ';

        $database->setQuery($sql);
        $result = $database->loadObject();

        return $result;
    }

    public function notifications($template=null){

        if(empty($template)){
            return;
        }

        $this->modelImages = new ShoppingoverviewModelImages();
        $this->modelTags = new ShoppingoverviewModelTags();
        $this->modelAvertisings = new ShoppingoverviewModelAdvertisings();

        $database = $this->db;

        $sql = '
          SELECT
            notif.*
          FROM '.self::TABLE.' notif
          WHERE
            notif.template = '.$database->quote($template).'
          AND
            notif.published = 1
          GROUP BY notif.id
          ORDER BY notif.id DESC
          LIMIT 1
        ';

        $database->setQuery($sql);
        $templateResult = $database->loadObject();

        if(empty($templateResult)){
            return;
        }

        // Проверка на сушествования двух обязательных элементов
        $sql = '
          SELECT
            notif.*
          FROM '.self::TABLE.' notif
          WHERE
            (notif.template = '.$database->quote('base').' OR notif.template = '.$database->quote('item').')
          AND
            notif.published = 1
          GROUP BY notif.id
          ORDER BY notif.id DESC
        ';

        $database->setQuery($sql);
        $baseResult = $database->loadObjectList();

        if(empty($baseResult) || count($baseResult) != 2){
            return;
        }

        $class = get_class_methods($this);

        if(in_array('notifications_'.$template,$class)){

            $this->{'notifications_'.$template}($template);

        }

        return;

    }


    // Обязательный элемент
    public function notifications_base(){
        $database = $this->db;

        $sql = '
          SELECT
            notif.*
          FROM '.self::TABLE.' notif
          WHERE
            notif.template = '.$database->quote('base').'
          AND
             notif.published = 1
          GROUP BY notif.id
          ORDER BY notif.id DESC
          LIMIT 1
        ';

        $database->setQuery($sql);
        $result_base = $database->loadObject();

        return $result_base;
    }


    // Обязательный элемент
    public function notifications_item(){
        $database = $this->db;

        $sql = '
          SELECT
            notif.*
          FROM '.self::TABLE.' notif
          WHERE
            notif.template = '.$database->quote('item').'
          AND
             notif.published = 1
          GROUP BY notif.id
          ORDER BY notif.id DESC
          LIMIT 1
        ';

        $database->setQuery($sql);
        $result_base = $database->loadObject();

        return $result_base;
    }

    // Замена спец тегов
    public function notifications_item_replace($key,$item,$notif){

        $lang_def = JFactory::getUser($key)->getParam('language','en-GB');
        $lang = ShoppingoverviewSiteHelper::getPerfixLang(mb_strtolower($lang_def, 'UTF-8'));

        // картинка
        $img = DopFunction::explodeReg($item->{'text_'.$lang},$this->modelImages);
        foreach($img as $imgItem){
            $img = str_replace('/upload/','/upload/thumbs/',$imgItem->img);
            break;
        }
        preg_match('#src="(.*)"#isu',$img, $img);
        if(isset($img[1]) && !empty($img[1]) ){
            $img = $img[1];
            $img = JUri::base().ltrim($img, '/');
        }else{
            $img = JUri::base().'images/no-img.jpg';
        }
        $notif->{'content_'.$lang} = str_replace('[image]',$img,$notif->{'content_'.$lang});

        // Ссылка
        $url = JRoute::_( 'index.php?option=com_shoppingoverview&cat_alias='.$item->cat_alias.'&item_alias='.$item->{'alias_'.$lang}.'&Itemid=101&lang='.$lang );
        $url = JUri::base().ltrim($url, '/');
        $notif->{'content_'.$lang} = str_replace('[href]',$url,$notif->{'content_'.$lang});

        // Загаловок
        $title = $item->product.' - '.$item->{'title_'.$lang};
        $notif->{'content_'.$lang} = str_replace('[title]',$title,$notif->{'content_'.$lang});

        // ссылка на магазин
        $shop = $item->shop;
        $notif->{'content_'.$lang} = str_replace('[shop]', $shop, $notif->{'content_'.$lang});

        // Теги
        $explodeTags = $this->modelTags->getCommunications($item->id);
        ob_start();
        foreach($explodeTags as $itemTag){
            $tag_url = JRoute::_( 'index.php?option=com_shoppingoverview&controller=tags&task=tag&Itemid=101&id='.$itemTag->id.'&land='.$lang );
            $tag_url = JUri::base().ltrim($tag_url, '/');
            ?>
            <a style="color: #7e9cbc;font-size: 14px;text-align: justify;padding: 2px 5px;line-height: 22px;border: 1px solid #7e9cbc;margin-right: 3px;line-height: 18px;border-radius: 4px;display: inline-block;margin: 3px 0px;text-decoration: none;" href="<?=$tag_url;?>">
                <?php echo '#'.$itemTag->title; ?>
            </a>
        <?php
        }
        $tags = ob_get_clean();
        $notif->{'content_'.$lang} = str_replace('[tags]',$tags,$notif->{'content_'.$lang});

        // Просмотры
        $notif->{'content_'.$lang} = str_replace('[hits]',$item->hits,$notif->{'content_'.$lang});

        // Лайки
        $notif->{'content_'.$lang} = str_replace('[likes]',$item->countlike,$notif->{'content_'.$lang});

        // Коменты
        $notif->{'content_'.$lang} = str_replace('[coments]',$item->countcomment,$notif->{'content_'.$lang});

        // Аватарка
        $customFields = FieldsHelper::getFields('com_users.user', ['id'=> $item->user_id]);
        $avatar = JUri::base().ltrim($customFields[0]->value, '/');
        $notif->{'content_'.$lang} = str_replace('[avatar]',$avatar,$notif->{'content_'.$lang});

        // Автор урл
        $author_url = JRoute::_( 'index.php?option=com_shoppingoverview&controller=users&task=profile&Itemid=101&id='.$item->user_id.'&land='.$lang );
        $author_url = JUri::base().ltrim($author_url, '/');
        $notif->{'content_'.$lang} = str_replace('[author_url]',$author_url,$notif->{'content_'.$lang});

        // Автор
        $author = JFactory::getUser($item->user_id)->username;
        $notif->{'content_'.$lang} = str_replace('[author]',$author,$notif->{'content_'.$lang});

        // Дата публикации
        $created = DopFunction::showDate(strtotime($item->created),$lang_def);
        $notif->{'content_'.$lang} = str_replace('[created]',$created,$notif->{'content_'.$lang});

        return $notif;
    }


    // Новые обзоры от авторов
    public function notifications_news_overviews($template=null){

        if(empty($template)){
            return;
        }

        $database = $this->db;

        $sql = '
          SELECT
            notif.*
          FROM '.self::TABLE.' notif
          WHERE
            notif.template = '.$database->quote($template).' AND notif.type = '.$database->quote('template').'
          AND
             notif.published = 1
          GROUP BY notif.id
          ORDER BY notif.id DESC
          LIMIT 1
        ';

        $database->setQuery($sql);
        $result_notif = $database->loadObject();


        if(empty($result_notif)){
            return;
        }

        $result_base = $this->notifications_base();
        $result_item = $this->notifications_item();


        // Основная логика

        // Выборка за день ранее
        $date_after_q = new DateTime(date("Y-m-d 00:00:00"));
        $date_before_q = new DateTime(date("Y-m-d 23:59:59"));

        $date_after = $date_after_q->modify('-1 day')->format("Y-m-d 00:00:00");
        $date_before = $date_before_q->modify('-1 day')->format("Y-m-d 23:59:59");


        $sql = '
          SELECT
            subs.*
          FROM #__shoppingoverview_user_subscribes subs
          LEFT JOIN #__shoppingoverview_items item ON (subs.primary_user_id = item.user_id)
          LEFT JOIN #__shoppingoverview_user_notifications noti ON (subs.user_id = noti.user_id)
          WHERE
          noti.notifications  LIKE '.$database->quote('%"'.$result_notif->id.'":"1"%').'
          AND
          subs.published = 1
          AND
          item.published = 1
          AND
          item.trash = 0
          AND
          (item.created BETWEEN '.$database->quote($date_after).' AND '.$database->quote($date_before).')
          GROUP BY item.id
          ORDER BY item.id DESC
        ';

        $database->setQuery($sql);
        $result_pre_1 = $database->loadObjectList();
        $result_pre_11 = array();

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
            COALESCE(SUM(com.count), 0) AS countcomment,
            count(fav.id) AS countfavorite
          FROM #__shoppingoverview_items item
          LEFT JOIN #__shoppingoverview_categories cat ON (cat.id = item.cat_id)
          LEFT JOIN #__shoppingoverview_deliverys del ON (del.id = item.delivery_id)
          LEFT JOIN #__shoppingoverview_likes lik ON (lik.post_id = item.id)
          LEFT JOIN #__shoppingoverview_comments com ON (com.post_id = item.id)
          LEFT JOIN #__shoppingoverview_favorites fav ON (fav.post_id = item.id AND fav.published = 1)
          LEFT JOIN #__shoppingoverview_user_subscribes subs ON (subs.primary_user_id = item.user_id)
          WHERE
          subs.published = 1
          AND
          item.published = 1
          AND
          item.trash = 0
          AND
          (item.created BETWEEN '.$database->quote($date_after).' AND '.$database->quote($date_before).')
          GROUP BY item.id
          ORDER BY item.id DESC
        ';

        $database->setQuery($sql);
        $result_pre_2 = $database->loadObjectList();
        $result_pre_22 = array();

        foreach($result_pre_2 as $item){
            $result_pre_22[$item->user_id][$item->id] = $item;
        }

        foreach($result_pre_1 as $item){
            $result_pre_11[$item->user_id] = array();
            $result_pre_11[$item->user_id] = array_merge($result_pre_11[$item->user_id], $result_pre_22[$item->primary_user_id]);
        }

        foreach($result_pre_11 as $key=>$items){

            $lang = ShoppingoverviewSiteHelper::getPerfixLang(mb_strtolower(JFactory::getUser($key)->getParam('language','en-GB'), 'UTF-8'));

            $result_pre = '';

            //обзоры
            foreach($items as $item){

                $notif_item = $this->notifications_item_replace($key,$item,clone $result_item);
                $result_pre .= $notif_item->{'content_'.$lang};

            }

            $notif = clone $result_notif;
            $result_pre = str_replace('[items]',$result_pre,$notif->{'content_'.$lang});
            $result_pre = str_replace('[advertisings]',$this->modelAvertisings->advertisingsEmail(),$result_pre);


            $base = clone $result_base;
            $result_pre = str_replace('[template]',$result_pre,$base->{'content_'.$lang});

            // отправляем письмо
            $subject = $result_notif->{'title_'.$lang};
            $body = $result_pre;
            $to = JFactory::getUser($key)->email;

            $this->send_email($subject,$body,$to);

        }

    }

    function send_email($subject,$body,$to){
        // отправляем письмо
        $mailer = JFactory::getMailer();
        $config = JFactory::getApplication();

        $from = array($config->getCfg('mailfrom'), $config->getCfg('fromname'));

        $mailer->setSender($from);
        $mailer->addRecipient($to);
        $mailer->setSubject($subject);
        $mailer->setBody($body);
        $mailer->isHTML(true);

        $mailer->send();
    }



}
<?php

jimport('joomla.application.component.modellist');

class ShoppingoverviewModuleModelProduct extends JModelList
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

    public function getListItems($cat_alias='',$lang='en',$viewDefault = null,$count=5){

        $database = $this->db;

        $sql = '';
        $sql .= '
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
          WHERE
        ';

        if(!empty($cat_alias)) {
            $sql .= '
                cat.alias = ' . $database->quote($cat_alias) . '
                AND
            ';
        }

        $sql .= '
          item.title_'.$lang.' !=  ""
          AND
          item.text_'.$lang.' !=  ""
          AND
          item.published = 1
          AND
          item.trash = 0
        ';

        if(!empty($viewDefault)):
            if($viewDefault == 'latest'):
                $sql .= '
                  GROUP BY item.id
                  ORDER BY item.id DESC
                ';
            endif;
            if($viewDefault == 'discussed'):
                $sql .= '
                  GROUP BY item.id
                  ORDER BY countcomment DESC
                ';
            endif;
            if($viewDefault == 'likes'):
                $sql .= '
                  GROUP BY item.id
                  ORDER BY countlike DESC
                ';
            endif;
            if($viewDefault == 'popular'):
                $sql .= '
                  GROUP BY item.id
                  ORDER BY item.hits DESC
                ';
            endif;
        endif;

        $sql .= '
          LIMIT '.$count.'
        ';

        $database->setQuery($sql);

        $items = $database->loadObjectList();

        $modelImages = new ShoppingoverviewModelImages();
        $modelTags = new ShoppingoverviewModelTags();
        $modelFavorites = new ShoppingoverviewModelFavorites();

        ob_start();

        require_once dirname(__DIR__).'/mod_shoppingoverview_product/tmpl/list.php';

        $result = ob_get_contents();
        ob_end_clean();

        return $result;
    }

}

class ModShoppingoverviewProductHelper {

    public static  function getAjax (){

        require_once dirname(dirname(dirname(__FILE__))) . '/components/com_shoppingoverview/helpers/shoppingoverview.php';
        require_once dirname(dirname(dirname(__FILE__))) . '/components/com_shoppingoverview/helpers/secondaryfunctions.php';
        require_once dirname(dirname(dirname(__FILE__))) . '/components/com_shoppingoverview/models/images.php';
        require_once dirname(dirname(dirname(__FILE__))) . '/components/com_shoppingoverview/models/tags.php';
        require_once dirname(dirname(dirname(__FILE__))) . '/components/com_shoppingoverview/models/favorites.php';

        header('Content-Type: application/json');
        $result = array('error' => 0, 'result' => '');

        $app = JFactory::getApplication();
        $doc = JFactory::getDocument();

        $lang =  ModShoppingoverviewProductHelper::getPerfixLang($doc->getlanguage());

        $langYaz = JFactory::getLanguage();
        $langYaz->load('com_shoppingoverview');

        $module = new ShoppingoverviewModuleModelProduct();
        $modelImages = new ShoppingoverviewModelImages();
        $modelTags = new ShoppingoverviewModelTags();
        $modelFavorites = new ShoppingoverviewModelFavorites();

        $cat_alias = $app->input->getString('cat_alias', null);
        $cat_alias = str_replace(':','-',$cat_alias);
        $count = $app->input->getString('count', 2);
        $viewDefault = $app->input->getString('filter', 'latest');

        $result['result'] = $module->getListItems($cat_alias,$lang,$viewDefault,$count);

        echo json_encode($result);
        exit();
    }

    static function getPerfixLang($lang='ru'){

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


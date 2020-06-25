<?php

jimport('joomla.application.component.modellist');

class ShoppingoverviewModuleModelPublications extends JModelList
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


    public function getListCategories($params){

        $database = $this->db;

        $sql = '
          SELECT *
          FROM #__shoppingoverview_categories
          WHERE published = 1
          ORDER BY id DESC
        ';

        $database->setQuery($sql);
        $result = $database->loadObjectList();

        return $result;
    }

    public function getListItems($lang='en',$massArrFilter){

        $database = $this->db;

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
            count(fav.id) AS countfavorite,
            DATE(item.created) as dateday
          FROM #__shoppingoverview_items item
          LEFT JOIN #__shoppingoverview_categories cat ON (cat.id = item.cat_id)
          LEFT JOIN #__shoppingoverview_deliverys del ON (del.id = item.delivery_id)
          LEFT JOIN #__shoppingoverview_likes lik ON (lik.post_id = item.id)
          LEFT JOIN #__shoppingoverview_comments com ON (com.post_id = item.id)
          LEFT JOIN #__shoppingoverview_favorites fav ON (fav.post_id = item.id AND fav.published = 1)
          WHERE
          item.title_' . $lang . ' !=  ""
          AND
          item.text_' . $lang . ' !=  ""
          AND
          item.published = 1
          AND
          item.trash = 0
          AND
          DATE(item.created) >= (
            SELECT MIN(dt) FROM (
                SELECT DISTINCT DATE(created) dt
                FROM #__shoppingoverview_items
                ORDER BY 1 DESC
                LIMIT '.$massArrFilter->filterSoDay.'
            ) x
          )';


        if(!empty($massArrFilter->filterSoPrice1)):
            $sql .= ' AND item.price >= '.$database->quote($massArrFilter->filterSoPrice1);
        endif;

        if(!empty($massArrFilter->filterSoPrice2)):
            $sql .= ' AND item.price <= '.$database->quote($massArrFilter->filterSoPrice2);
        endif;


        if(!empty($massArrFilter->filterSoCat)):
        $sql .= '
          AND
          cat.id IN ('.$massArrFilter->filterSoCat.')
        ';
        endif;


        if(!empty($massArrFilter->filterSoDelivery)):
            $sql .= '
          AND
          item.delivery_id = '.$database->quote($massArrFilter->filterSoDelivery).'
        ';
        endif;


        if(!empty($massArrFilter->filterSoVideo)):
            if($massArrFilter->filterSoVideo == 1):
            $sql .= '
                AND
                item.youtube != ""
            ';
            endif;
            if($massArrFilter->filterSoVideo == 2):
                $sql .= '
                AND
                item.youtube = ""
            ';
            endif;
        endif;


        $sql .= '
          GROUP BY item.id
          ORDER BY dateday DESC
        ';

        $database->setQuery($sql);

        $result = $database->loadObjectList();

        return $result;
    }

}

class ModShoppingoverviewPublicationsHelper {


    public static function getAjax (){

        require_once dirname(dirname(dirname(__FILE__))) . '/components/com_shoppingoverview/helpers/shoppingoverview.php';
        require_once dirname(dirname(dirname(__FILE__))) . '/components/com_shoppingoverview/helpers/secondaryfunctions.php';
        require_once dirname(dirname(dirname(__FILE__))) . '/components/com_shoppingoverview/models/images.php';
        require_once dirname(dirname(dirname(__FILE__))) . '/components/com_shoppingoverview/models/tags.php';
        require_once dirname(dirname(dirname(__FILE__))) . '/components/com_shoppingoverview/models/favorites.php';
        require_once dirname(dirname(dirname(__FILE__))) . '/components/com_shoppingoverview/models/advertisings.php';

        header('Content-Type: application/json');
        $result = array('error' => 0, 'result' => '');

        $app = JFactory::getApplication();
        $doc = JFactory::getDocument();
        $session = JFactory::getSession();

        $langYaz = JFactory::getLanguage();
        $langYaz->load('com_shoppingoverview');

        $lang =  (new ModShoppingoverviewPublicationsHelper)->getPerfixLang($doc->getlanguage());

        $filterSoCat = $app->input->get('filterSoCat', 0, 'string');
        $filterSoCat = preg_replace('~\D+\,~','',$filterSoCat);
        $filterSoDay = $app->input->get('filterSoDay', 7, 'int');
        $filterSoPrice1 = $app->input->get('filterSoPrice1', 0, 'int');
        $filterSoPrice2 = $app->input->get('filterSoPrice2', 0, 'int');
        $filterSoDelivery = $app->input->get('filterSoDelivery', 0, 'int');
        $filterSoVideo = $app->input->get('filterSoVideo', 0, 'int');
        $filterSoOrdering = $app->input->get('ordering', 'latest', 'string');

        $massArrFilter = (object) array(
            "filterSoCat"       => $filterSoCat,
            "filterSoDay"       => $filterSoDay,
            "filterSoPrice1"     => $filterSoPrice1,
            "filterSoPrice2"     => $filterSoPrice2,
            "filterSoDelivery"  => $filterSoDelivery,
            "filterSoVideo"     => $filterSoVideo,
            "filterSoOrdering"  => $filterSoOrdering
        );

        $session->set('globalfilter', $massArrFilter);

        $modelImages = new ShoppingoverviewModelImages();
        $modelTags = new ShoppingoverviewModelTags();
        $module = new ShoppingoverviewModuleModelPublications();
        $modelFavorites = new ShoppingoverviewModelFavorites();
        $items = $module->getListItems($lang,$massArrFilter);
        $modelAvertisings = new ShoppingoverviewModelAdvertisings;

        ob_start();
        require_once dirname(__DIR__).'/mod_shoppingoverview_publications/tmpl/right_bar.php';
        $result['result'] = ob_get_contents();
        ob_end_clean();

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
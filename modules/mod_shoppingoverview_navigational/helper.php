<?php

jimport('joomla.application.component.modellist');

class ShoppingoverviewModuleModelNavigational extends JModelList
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

    public function formatTo($argr){

        $result = array();

        foreach($argr as $item){
            $result[$item->alfavit][] = $item;
        }

        return $result;
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

    public function getListItems($lang='en',$cat_id=null,$date=7){

        $database = $this->db;

        $sql = '
          SELECT
            item.*,
            LEFT(UPPER(item.product), 1) as alfavit,
            cat.alias AS cat_alias
          FROM #__shoppingoverview_items item
          LEFT JOIN #__shoppingoverview_categories cat ON (cat.id = item.cat_id)
          WHERE
          item.title_'.$lang.' !=  ""
          AND
          item.text_'.$lang.' !=  ""
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
                LIMIT '.$date.'
            ) x
          )
        ';
        if($cat_id != null){
            $sql .= '
                AND
                item.cat_id = '.$database->quote($cat_id).'
            ';
        }

        $sql .= '
          ORDER BY alfavit ASC
        ';

        $database->setQuery($sql);

        $result = $database->loadObjectList();

        $result = $this->formatTo($result);

        ob_start();

        require_once dirname(__DIR__).'/mod_shoppingoverview_navigational/tmpl/list.php';

        $result = ob_get_contents();
        ob_end_clean();

        return $result;
    }

}

class ModShoppingoverviewNavigationalHelper {

    public static  function getAjax (){
        header('Content-Type: application/json');
        $result = array('error' => 0, 'result' => '');

        $app = JFactory::getApplication();
        $doc = JFactory::getDocument();

        $lang =  ModShoppingoverviewNavigationalHelper::getPerfixLang($doc->getlanguage());

        $date = $app->input->get('date', 7, 'int');
        $cat_id = trim(strip_tags($app->input->get('cat_id', null, 'string')));

        $module = new ShoppingoverviewModuleModelNavigational();

        $result['result'] = $module->getListItems($lang,$cat_id,$date);

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


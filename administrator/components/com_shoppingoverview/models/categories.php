<?php

// No direct access
defined( '_JEXEC' ) or die;

/**
 * @author Воропаев Валентин
 */

jimport('joomla.application.component.modellist');

class ShoppingoverviewModelCategories extends JModelList
{

    const TABLE = '#__shoppingoverview_categories';
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

    public function getForm($data = array(), $loadData = true)
    {
        $form = $this->loadForm('com_shoppingoverview.categories', 'categories', array('control' => 'jform', 'load_data' => $loadData));
        if (empty($form)) {
            return false;
        }
        return $form;
    }

    public function getListAll(){

        $database = $this->db;

        $sql = '
          SELECT *
          FROM '.self::TABLE.'
          WHERE published = 1
          ORDER BY id DESC
        ';

        $database->setQuery($sql);
        $result = $database->loadObjectList();

        return $result;
    }

    public function getListItems($filter = null,$count=null){

        if($filter == null){
            $filter = new stdClass();
            $filter->search = '';
            $filter->ordering ='id DESC';
            $filter->limit = '10';
        }

        $database = $this->db;

        $sql = '';
        $sql .= '
          SELECT *
          FROM '.self::TABLE.'
        ';

        if($filter->search != ''){
        $sql .= '
          WHERE
          id LIKE '.$database->quote($filter->search).'
          OR
          title_ru LIKE '.$database->quote($filter->search).'
          OR
          title_en LIKE '.$database->quote($filter->search).'
          OR
          title_he LIKE '.$database->quote($filter->search).'
        ';
        }

        $sql .= '
          ORDER BY '.$filter->ordering.'
        ';

        if($filter->limit != 0){

        $sql .= '
          LIMIT
        ';

        if($count != null){

        $sql .= " ".$count.",";

        }

        $sql .= " ".$filter->limit;

        }


        $database->setQuery($sql);

        $result = $database->loadObjectList();

        return $result;
    }

    public function getItem($id=null){

        $database = $this->db;

        $database->setQuery('
          SELECT *
          FROM '.self::TABLE.'
          WHERE id = '.$database->quote($id).'
          LIMIT 1
        ');

        $result = $database->loadObject();

        return $result;
    }

    public function save($data){

        $data->created = date('Y-m-d H:i:s');
        $database = $this->db;

        if(empty($data->alias)){
            if( !empty($data->title_en) ){
                $data->alias = $data->title_en;
            }elseif( !empty($data->title_ru) ){
                $data->alias = $data->title_ru;
            }else{
                $data->alias = $data->title_he;
            }
        }

        $data->alias = $this->generationAlias($data->alias,$data->id);

        if(isset($data->id) && $data->id != ''){

            $database->setQuery('UPDATE '.self::TABLE.'
            SET
            icon = '.$database->quote($data->icon).',
            mini_title_ru = '.$database->quote($data->mini_title_ru).',
            mini_title_en = '.$database->quote($data->mini_title_en).',
            mini_title_he = '.$database->quote($data->mini_title_he).',
            title_ru = '.$database->quote($data->title_ru).',
            title_en = '.$database->quote($data->title_en).',
            title_he = '.$database->quote($data->title_he).',
            alias = '.$database->quote($data->alias).',
            text = '.$database->quote($data->text).',
            created = '.$database->quote($data->created).',
            published = '.$database->quote($data->published).'
            WHERE id = '.$database->quote($data->id).'
            ');

        }else{

            $database->setQuery('INSERT INTO '.self::TABLE.'
            (
            `icon`,
            `mini_title_ru`,
            `mini_title_en`,
            `mini_title_he`,
            `title_ru`,
            `title_en`,
            `title_he`,
            `alias`,
            `text`,
            `created`,
            `published`
            )
            VALUES
            (
            '.$database->quote($data->icon).',
            '.$database->quote($data->mini_title_ru).',
            '.$database->quote($data->mini_title_en).',
            '.$database->quote($data->mini_title_he).',
            '.$database->quote($data->title_ru).',
            '.$database->quote($data->title_en).',
            '.$database->quote($data->title_he).',
            '.$database->quote($data->alias).',
            '.$database->quote($data->text).',
            '.$database->quote($data->created).',
            '.$database->quote($data->published).'
            )
            ');

        }

        if($database->query()){
            if(isset($data->id) && $data->id != '') {
                return true;
            }

            return $database->insertid();
        }else{
            return false;
        }

    }

    function remove($data){

        $database = $this->db;
        $sql = 'DELETE FROM '.self::TABLE.'  WHERE ';
        $count = 0;

        foreach($data as $item){

            if($count > 0){
                $sql .= ' OR ';
            }

            $sql .= 'id = '.$database->quote($item).'';
            $count++;

        }

        $database->setQuery($sql);

        if($database->query()){
            return true;
        }else{
            return false;
        }

    }

    function publish($data){

        $database = $this->db;
        $sql = 'UPDATE '.self::TABLE.'  SET published = '.$database->quote('1').' WHERE ';
        $count = 0;

        foreach($data as $item){

            if($count > 0){
                $sql .= ' OR ';
            }

            $sql .= 'id = '.$database->quote($item).'';
            $count++;

        }

        $database->setQuery($sql);

        if($database->query()){
            return true;
        }else{
            return false;
        }

    }

    function unpublish($data){

        $database = $this->db;
        $sql = 'UPDATE '.self::TABLE.'  SET published = '.$database->quote('0').' WHERE ';
        $count = 0;

        foreach($data as $item){

            if($count > 0){
                $sql .= ' OR ';
            }

            $sql .= 'id = '.$database->quote($item).'';
            $count++;

        }

        $database->setQuery($sql);

        if($database->query()){
            return true;
        }else{
            return false;
        }

    }

    function duplicate($data){

        foreach($data as $item){

            $copy = $this->getItem($item);
            unset($copy->id);
            $this->save($copy);

        }

    }

    public function validate($data){

        $error = array();
        $error['text'] = "";
        $error['status'] = true;

        if(empty($data->title_ru) || empty($data->title_en) || empty($data->title_he)){
            $error['text'] .= "Название не заполнено<br/>";
            $error['status'] = false;
        }


        return $error;

    }

    public function isAliasExist($alias,$id=null){

        $database = $this->db;

        $sql = '
          SELECT COUNT(*)
          FROM '.self::TABLE.'
          WHERE alias = '.$database->quote($alias).'
        ';

        if(!empty($id)){
            $sql .= ' AND id !='.$database->quote($id);
        }

        $database->setQuery($sql);

        return ($database->loadResult() ? true : false);

    }

    public function generationAlias($text="",$id=null){

        $text = trim(strip_tags($text));

        $alias = JFilterOutput::stringURLSafe($text);

        if(empty($alias)){
            $alias = "categories";
        }

        $alias_ini = $alias;

        for ($i = 2; $this->isAliasExist($alias,$id); $i++) {
            $alias = $alias_ini . '-' . $i;
        }

        return $alias;
    }

}
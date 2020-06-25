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

    public function getForm($data = array(), $loadData = true)
    {
        $form = $this->loadForm('com_shoppingoverview.tags', 'tags', array('control' => 'jform', 'load_data' => $loadData));
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

    public function getListItemsAjax($search){
        $database = $this->db;

        $sql = '
          SELECT title
          FROM '.self::TABLE.'
          WHERE title LIKE '.$database->quote('%'.$search.'%').' AND published = 1
          ORDER BY id DESC
          LIMIT 7
        ';

        $database->setQuery($sql);
        $result = $database->loadObjectList();

        return $result;
    }

    public function getListItems($filter = null,$count=null){

        if($filter == null){
            $filter = new stdClass();
            $filter->search = '';
            $filter->ordering ='qwe.id DESC';
            $filter->limit = '10';
        }

        $database = $this->db;

        $sql = '';
        $sql .= '
          SELECT qwe.*
          FROM '.self::TABLE.' qwe
        ';

        if($filter->search != ''){
        $sql .= '
          WHERE
          qwe.title LIKE '.$database->quote($filter->search).'
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
            title_ru = '.$database->quote($data->title_ru).',
            title_en = '.$database->quote($data->title_en).',
            title_he = '.$database->quote($data->title_he).',
            published = '.$database->quote($data->published).'
            WHERE id = '.$database->quote($data->id).'
            ');

        }else{

            $database->setQuery('INSERT INTO '.self::TABLE.'
            (
            `title`,
            `title_ru`,
            `title_en`,
            `title_he`,
            `published`
            )
            VALUES
            (
            '.$database->quote($data->title).',
            '.$database->quote($data->title_ru).',
            '.$database->quote($data->title_en).',
            '.$database->quote($data->title_he).',
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

    public function validate($data){

        $error = array();
        $error['text'] = "";
        $error['status'] = true;

        if(empty($data->title)){
            $error['text'] .= "Название не заполнено<br/>";
            $error['status'] = false;
        }


        return $error;

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
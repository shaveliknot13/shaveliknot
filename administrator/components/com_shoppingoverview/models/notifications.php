<?php

// No direct access
defined( '_JEXEC' ) or die;

/**
 * @author Воропаев Валентин
 */

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
        $this->db = parent::getDbo();;
    }

    public function getForm($data = array(), $loadData = true)
    {
        $form = $this->loadForm('com_shoppingoverview.notifications', 'notifications', array('control' => 'jform', 'load_data' => $loadData));
        if (empty($form)) {
            return false;
        }
        return $form;
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

        if(isset($data->id) && $data->id != ''){

            $database->setQuery('UPDATE '.self::TABLE.'
            SET
            title = '.$database->quote($data->title).',
            title_ru = '.$database->quote($data->title_ru).',
            title_en = '.$database->quote($data->title_en).',
            title_he = '.$database->quote($data->title_he).',
            content_ru = '.$database->quote($data->content_ru).',
            content_en = '.$database->quote($data->content_en).',
            content_he = '.$database->quote($data->content_he).',
            template = '.$database->quote($data->template).',
            type = '.$database->quote($data->type).',
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
            `content_ru`,
            `content_en`,
            `content_he`,
            `template`,
            `type`,
            `published`
            )
            VALUES
            (
            '.$database->quote($data->title).',
            '.$database->quote($data->title_ru).',
            '.$database->quote($data->title_en).',
            '.$database->quote($data->title_he).',
            '.$database->quote($data->content_ru).',
            '.$database->quote($data->content_en).',
            '.$database->quote($data->content_he).',
            '.$database->quote($data->template).',
            '.$database->quote($data->type).',
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

    public function validate($data){

        $error = array();
        $error['text'] = "";
        $error['status'] = true;

        if(empty($data->title)){
            $error['text'] .= "Название не заполнено<br/>";
            $error['status'] = false;
        }

        if(empty($data->title_ru) || empty($data->title_en) || empty($data->title_he)){
            $error['text'] .= "Заголовок не заполнен<br/>";
            $error['status'] = false;
        }

        if(empty($data->content_ru) || empty($data->content_en) || empty($data->content_he)){
            $error['text'] .= "HTML не заполнен<br/>";
            $error['status'] = false;
        }

        if(empty($data->template)){
            $error['text'] .= "Шаблон не заполнен<br/>";
            $error['status'] = false;
        }

        if(empty($data->type)){
            $error['text'] .= "Тип не заполнено<br/>";
            $error['status'] = false;
        }

        if(empty($data->published)){
            $error['text'] .= "Публикация не заполнена<br/>";
            $error['status'] = false;
        }

        return $error;

    }

}
<?php

// No direct access
defined( '_JEXEC' ) or die;

/**
 * @author Воропаев Валентин
 */

jimport('joomla.application.component.modellist');

class ShoppingoverviewModelAdvertisings extends JModelList
{

    const TABLE = '#__shoppingoverview_advertisings';
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
        $form = $this->loadForm('com_shoppingoverview.advertisings', 'advertisings', array('control' => 'jform', 'load_data' => $loadData));
        if (empty($form)) {
            return false;
        }
        return $form;
    }


    public function getAdvertisings(){


        $argv = array();

        $database = $this->db;

        $sql = '
          SELECT
            *
          FROM #__shoppingoverview_advertisings_position
        ';

        $database->setQuery($sql);
        $result = $database->loadObjectList();

        foreach($result as $item){
            $argv[$item->alias] = $item->title;
        }

        return $argv;

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
            content = '.$database->quote($data->content).',
            type_js_php = '.$database->quote($data->type_js_php).',
            type_mod_com = '.$database->quote($data->type_mod_com).',
            position = '.$database->quote($data->position).',
            mod_id = '.$database->quote($data->mod_id).',
            hits_constraints = '.$database->quote($data->hits_constraints).',
            hits = '.$database->quote($data->hits).',
            published = '.$database->quote($data->published).'
            WHERE id = '.$database->quote($data->id).'
            ');

        }else{

            $database->setQuery('INSERT INTO '.self::TABLE.'
            (
            `title`,
            `content`,
            `type_js_php`,
            `type_mod_com`,
            `position`,
            `mod_id`,
            `hits_constraints`,
            `hits`,
            `published`
            )
            VALUES
            (
            '.$database->quote($data->title).',
            '.$database->quote($data->content).',
            '.$database->quote($data->type_js_php).',
            '.$database->quote($data->type_mod_com).',
            '.$database->quote($data->position).',
            '.$database->quote($data->mod_id).',
            '.$database->quote($data->hits_constraints).',
            '.$database->quote($data->hits).',
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

        if(empty($data->type_js_php)){
            $error['text'] .= "Тип js или php не заполнено<br/>";
            $error['status'] = false;
        }

        if(empty($data->type_mod_com)){
            $error['text'] .= "Тип module или component не заполнено<br/>";
            $error['status'] = false;
        }

        if($data->type_mod_com == 'module' && empty($data->mod_id)){
            $error['text'] .= "Id модуля не заполнено<br/>";
            $error['status'] = false;
        }

        if($data->type_mod_com == 'component' && empty($data->position)){
            $error['text'] .= "Позиция не заполнено<br/>";
            $error['status'] = false;
        }

        return $error;

    }

}
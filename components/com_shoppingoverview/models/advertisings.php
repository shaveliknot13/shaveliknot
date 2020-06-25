<?php

// No direct access
defined( '_JEXEC' ) or die;

/**
 *@author Воропаев Валентин
 */
jimport('joomla.application.component.modellist');

class ShoppingoverviewModelAdvertisings extends JModelList
{

    const TABLE = '#__shoppingoverview_advertisings';
    public $db, $count_advertisings;


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

        $this->count_advertisings = $params->get('advertising_queue');
    }


    public function getPosition(){

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

    public function advertisingsEmail(){

        $database = $this->db;

        $sql = '
          SELECT
            ad.*
          FROM '.self::TABLE.' ad
          WHERE
            ad.content != ""
          AND
            ad.type_mod_com = "email"
          AND
            (ad.hits < ad.hits_constraints OR ad.hits_constraints = 0)
          AND
             ad.published = 1
          GROUP BY ad.id
          ORDER BY ad.id DESC
        ';

        $database->setQuery($sql);
        $result = $database->loadObjectList();

        if(empty($result)){
            return;
        }

        $max_rand = count($result);
        $rand = rand ( 1 , $max_rand )-1;

        ob_start();

        if($result[$rand]->type_js_php == "js"){
            echo $result[$rand]->content;
        }else{
            eval($result[$rand]->content);
        }

        $reklama = ob_get_contents();
        ob_end_clean();

        $database->setQuery('UPDATE '.self::TABLE.'
            SET
            hits=hits+1
            WHERE
            id = '.$database->quote($result[$rand]->id).'
            ');
        $database->query();

        return $reklama;

    }

    public function advertisings($position=null){

        if(empty($position)){
            return;
        }

        if(!array_key_exists($position,$this->getPosition())){
            return;
        }

        $database = $this->db;

        $sql = '
          SELECT
            ad.*
          FROM '.self::TABLE.' ad
          WHERE
            ad.content != ""
          AND
            ad.type_mod_com = "component"
          AND
            ad.position = '.$database->quote($position).'
          AND
            (ad.hits < ad.hits_constraints OR ad.hits_constraints = 0)
          AND
             ad.published = 1
          GROUP BY ad.id
          ORDER BY ad.id DESC
        ';

        $database->setQuery($sql);
        $result = $database->loadObjectList();

        if(empty($result)){
            return;
        }

        $max_rand = count($result);
        $rand = rand ( 1 , $max_rand )-1;

        ob_start();
        echo "<div class='advertisings'>";
        if($result[$rand]->type_js_php == "js"){
            echo $result[$rand]->content;
        }else{
            eval($result[$rand]->content);
        }
        echo "</div>";

        $reklama = ob_get_contents();
        ob_end_clean();

        $database->setQuery('UPDATE '.self::TABLE.'
            SET
            hits=hits+1
            WHERE
            id = '.$database->quote($result[$rand]->id).'
            ');
        $database->query();

        return $reklama;

    }

    public function advertisingsItem(){

        $session = JFactory::getSession();


        $massArrFilter = $session->get('advertisings', false);
        if($massArrFilter == false){
            $massArrFilter = 0;
            $session->set('advertisings', $massArrFilter);
        }
        $massArrFilter++;
        $session->set('advertisings', $massArrFilter);

        if($massArrFilter%$this->count_advertisings != 0){
            return;
        }


        $database = $this->db;

        $sql = '
          SELECT
            ad.*
          FROM '.self::TABLE.' ad
          WHERE
            ad.content != ""
          AND
            ad.type_mod_com = "item"
          AND
            (ad.hits < ad.hits_constraints OR ad.hits_constraints = 0)
          AND
             ad.published = 1
          GROUP BY ad.id
          ORDER BY ad.id DESC
        ';

        $database->setQuery($sql);
        $result = $database->loadObjectList();

        if(empty($result)){
            return;
        }

        $max_rand = count($result);
        $rand = rand ( 1 , $max_rand )-1;

        ob_start();
        echo "<div class=\"shoppingoverview-page-item shoppingoverview-page-item-advertisings\">";
        echo "<div class=\"shoppingoverview-page-item-advertisings-add\">";
        if($result[$rand]->type_js_php == "js"){
            echo $result[$rand]->content;
        }else{
            eval($result[$rand]->content);
        }
        ?>
        <?php
        echo "</div></div>";

        $reklama = ob_get_contents();
        ob_end_clean();

        $database->setQuery('UPDATE '.self::TABLE.'
            SET
            hits=hits+1
            WHERE
            id = '.$database->quote($result[$rand]->id).'
            ');
        $database->query();

        return $reklama;

    }

}
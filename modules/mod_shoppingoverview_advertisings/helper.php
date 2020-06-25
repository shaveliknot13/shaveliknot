<?php

jimport('joomla.application.component.modellist');

class ShoppingoverviewModuleModelAdvertisings extends JModelList
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



    public function advertisings($mod_id=null){

        if(empty($mod_id)){
            return;
        }

        $database = $this->db;

        $sql = '
          SELECT
            ad.*
          FROM #__shoppingoverview_advertisings ad
          WHERE
            ad.content != ""
          AND
            ad.type_mod_com = "module"
          AND
            ad.mod_id = '.$database->quote($mod_id).'
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

        $database->setQuery('UPDATE #__shoppingoverview_advertisings
            SET
            hits=hits+1
            WHERE
            id = '.$database->quote($result[$rand]->id).'
            ');
        $database->query();

        return $reklama;

    }

}



<?php

// No direct access
defined( '_JEXEC' ) or die;

/**
 * @author Воропаев Валентин
 */

jimport('joomla.application.component.modellist');

class ShoppingoverviewModelLikes extends JModelList
{

    const TABLE = '#__shoppingoverview_likes';
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

    public function countLikes($id=null,$resultArr)
    {

        if(isset($resultArr->error)){
            return 0;
        }else{

            $database = $this->db;
            $amx = 'SELECT id,count FROM '.self::TABLE.' WHERE post_id='.$database->quote($id);
            $database->setQuery($amx);
            $result = $database->loadObject();

            if($result != null){

                $amx = 'UPDATE '.self::TABLE.' SET count='.$database->quote($resultArr->engagement->reaction_count).' WHERE id='.$database->quote($result->id);
                $database->setQuery($amx);
                $database->query();

            }else{

                $amx = 'INSERT INTO '.self::TABLE.'
                        (`post_id`,
                        `count`)
                        VALUES
                        ('.$database->quote($id).',
                        '.$database->quote($resultArr->engagement->reaction_count).')';
                $database->setQuery($amx);
                $database->query();

            }

            return $resultArr->engagement->reaction_count;
        }
    }


}
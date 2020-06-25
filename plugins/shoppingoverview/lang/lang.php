<?php

defined('_JEXEC') or die;
jimport( 'joomla.language.language' );

class PlgShoppingoverviewLang extends JPlugin
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

        $this->db = $db;

    }



	public function onShoppingoverviewLang($list)
	{

        if(count($list) != 3){
            return $list;
        }
        if($list[0]->lang_code != 'he-IL' || $list[1]->lang_code != 'ru-RU' || $list[2]->lang_code != 'en-GB'){
            return $list;
        }

        $app = JFactory::getApplication();
        $doc = & JFactory::getDocument();
        $lang =  $this->getPerfixLang($doc->getlanguage());
        $option = $app->input->get('option', null, 'string');
        $controller = $app->input->get('controller', null, 'string');
        $task = $app->input->get('task', null, 'string');
        $cat_alias = $app->input->getString('cat_alias', null, 'string');
        $cat_alias = str_replace(':','-',$cat_alias);
        $item_alias = $app->input->getString('item_alias', null, 'string');
        $item_alias = str_replace(':','-',$item_alias);

        $user = JFactory::getUser();
        if($user->guest != 1){
            $userLang = $user->getParam('language', null);
            if(empty($userLang)){
                $user->setParam('language', $this->getAltPerfixLang($lang));
                $user->save();
            }
        }


        if($option == 'com_shoppingoverview'){

            if(($controller == 'items' || $controller == null) && $task == 'show'){

                $row = $this->getItem($cat_alias,$item_alias,$lang);

                if(empty($row)){
                    return $list;
                }

                $list[0]->link = '/he/'.$row->cat_alias.'/'.$row->item_alias_he;
                $list[1]->link = '/ru/'.$row->cat_alias.'/'.$row->item_alias_ru;
                $list[2]->link = '/en/'.$row->cat_alias.'/'.$row->item_alias_en;

                return $list;

            }

            if($lang == 'ru'){
                $url = $list[1]->link;
            }elseif($lang == 'he'){
                $url = $list[0]->link;
            }elseif($lang == 'en'){
                $url = $list[2]->link;
            }else{
                return $list;
            }

            $list[0]->link = str_replace('/'.$lang.'/','/he/',$url);
            $list[1]->link = str_replace('/'.$lang.'/','/ru/',$url);
            $list[2]->link = str_replace('/'.$lang.'/','/en/',$url);

            return $list;

        }

		return $list;
	}

    public function getPerfixLang($lang='ru'){

        if($lang == "ru-ru"){
            $lang = "ru";
        }elseif($lang == "en-gb"){
            $lang = "en";
        }elseif($lang == "he-il"){
            $lang = "he";
        }

        return $lang;
    }

    public function getAltPerfixLang($lang='en-GB'){

        if($lang == "ru"){
            $lang = "ru-RU";
        }elseif($lang == "en"){
            $lang = "en-GB";
        }elseif($lang == "he"){
            $lang = "he-IL";
        }

        return $lang;
    }

    public function getItem($cat_alias,$item_alias,$lang='ru'){

        $database = $this->db;
        $user   = JFactory::getUser();

        $sql = '';
        $sql .= '
          SELECT
            item.alias_ru AS item_alias_ru,
            item.alias_en AS item_alias_en,
            item.alias_he AS item_alias_he,
            cat.alias AS cat_alias
          FROM #__shoppingoverview_items item
          LEFT JOIN #__shoppingoverview_categories cat ON (cat.id = item.cat_id)
          WHERE
          item.alias_'.$lang.' = '.$database->quote($item_alias).'
          AND
          item.title_'.$lang.' !=  ""
          AND
          item.text_'.$lang.' !=  ""
          AND
          cat.alias = '.$database->quote($cat_alias).'
          AND
          item.trash = 0
          GROUP BY item.id
          ORDER BY item.id DESC
          LIMIT 1
        ';

        $database->setQuery($sql);

        $result = $database->loadObject();

        return $result;
    }




}

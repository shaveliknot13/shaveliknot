<?php

// No direct access
defined( '_JEXEC' ) or die;

/**
 * @author Воропаев Валентин
 */

jimport('joomla.application.component.modellist');

class ShoppingoverviewModelItems extends JModelAdmin
{

    const TABLE = '#__shoppingoverview_items';
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
        $this->db = parent::getDbo();
    }

    public function getForm( $data = array(), $loadData = true )
    {
        $form = $this->loadForm( 'com_shoppingoverview.items', 'items', array( 'control' => 'jform', 'load_data' => $loadData ) );
        if ( empty( $form ) ) {
            return false;
        }
        return $form;
    }

    public function getListItems($cat_alias,$lang='en',$massArrFilter=array(),$count=0){

        $database = $this->db;

        $sql = '';
        $sql .= '
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
            count(fav.id) AS countfavorite
          FROM '.self::TABLE.' item
          LEFT JOIN #__shoppingoverview_categories cat ON (cat.id = item.cat_id)
          LEFT JOIN #__shoppingoverview_deliverys del ON (del.id = item.delivery_id)
          LEFT JOIN #__shoppingoverview_likes lik ON (lik.post_id = item.id)
          LEFT JOIN #__shoppingoverview_comments com ON (com.post_id = item.id)
          LEFT JOIN #__shoppingoverview_favorites fav ON (fav.post_id = item.id AND fav.published = 1)
          WHERE
          cat.alias = '.$database->quote($cat_alias).'
          AND
          item.title_'.$lang.' !=  ""
          AND
          item.text_'.$lang.' !=  ""
          AND
          item.published = 1
          AND
          item.trash = 0
        ';


        if(!empty($massArrFilter->filterSoPrice1)):
            $sql .= ' AND item.price >= '.$database->quote($massArrFilter->filterSoPrice1);
        endif;

        if(!empty($massArrFilter->filterSoPrice2)):
            $sql .= ' AND item.price <= '.$database->quote($massArrFilter->filterSoPrice2);
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

        if(!empty($massArrFilter->filterSoOrdering)):
            if($massArrFilter->filterSoOrdering == 'latest'):
                $sql .= '
                  GROUP BY item.id
                  ORDER BY item.id DESC
                ';
            endif;
            if($massArrFilter->filterSoOrdering == 'discussed'):
                $sql .= '
                  GROUP BY item.id
                  ORDER BY countcomment DESC
                ';
            endif;
            if($massArrFilter->filterSoOrdering == 'likes'):
                $sql .= '
                  GROUP BY item.id
                  ORDER BY countlike DESC
                ';
            endif;
            if($massArrFilter->filterSoOrdering == 'popular'):
                $sql .= '
                  GROUP BY item.id
                  ORDER BY item.hits DESC
                ';
            endif;
        endif;

        $sql .= '
          LIMIT '.$count.', 10
        ';

        $database->setQuery($sql);

        $result = $database->loadObjectList();

        return $result;
    }

    public function getItem($cat_alias,$item_alias,$lang='en'){

        $database = $this->db;
        $user   = JFactory::getUser();

        $sql = '';
        $sql .= '
          SELECT
            item.*,
            cat.title_ru AS cattitle_ru,
            cat.title_en AS cattitle_en,
            cat.title_he AS cattitle_he,
            cat.alias AS cat_alias,
            cat.icon AS cat_icon,
            del.title_ru AS deltitle_ru,
            del.title_en AS deltitle_en,
            del.title_he AS deltitle_he,
            COALESCE(SUM(lik.count), 0) AS countlike,
            COALESCE(SUM(com.count), 0) AS countcomment,
            count(fav.id) AS countfavorite
          FROM '.self::TABLE.' item
          LEFT JOIN #__shoppingoverview_categories cat ON (cat.id = item.cat_id)
          LEFT JOIN #__shoppingoverview_deliverys del ON (del.id = item.delivery_id)
          LEFT JOIN #__shoppingoverview_likes lik ON (lik.post_id = item.id)
          LEFT JOIN #__shoppingoverview_comments com ON (com.post_id = item.id)
          LEFT JOIN #__shoppingoverview_favorites fav ON (fav.post_id = item.id AND fav.published = 1)
          WHERE
          item.alias_'.$lang.' = '.$database->quote($item_alias).'
          AND
          item.title_'.$lang.' !=  ""
          AND
          item.text_'.$lang.' !=  ""
          AND
          cat.alias = '.$database->quote($cat_alias).'
          AND
          (item.published = 1 OR item.user_id = '.$database->quote($user->id).')
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

    public function getItemId($id=null,$user_id=null){

        $database = $this->db;
        $user   = JFactory::getUser();

        $sql = '';
        $sql .= '
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
            count(fav.id) AS countfavorite
          FROM '.self::TABLE.' item
          LEFT JOIN #__shoppingoverview_categories cat ON (cat.id = item.cat_id)
          LEFT JOIN #__shoppingoverview_deliverys del ON (del.id = item.delivery_id)
          LEFT JOIN #__shoppingoverview_likes lik ON (lik.post_id = item.id)
          LEFT JOIN #__shoppingoverview_comments com ON (com.post_id = item.id)
          LEFT JOIN #__shoppingoverview_favorites fav ON (fav.post_id = item.id AND fav.published = 1)
          WHERE
          item.id = '.$database->quote($id).'
          AND
          (item.published = 1 OR item.user_id = '.$database->quote($user->id).')
          AND
          item.trash = 0
          AND
          item.user_id = '.$database->quote($user_id).'
          GROUP BY item.id
          ORDER BY item.id DESC
          LIMIT 1
        ';

        $database->setQuery($sql);

        $result = $database->loadObject();

        return $result;
    }

    public function getUserItems($user_id=null,$count=0, $cat_id=0){

        $database = $this->db;
        $user   = JFactory::getUser();

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
            count(fav.id) AS countfavorite
          FROM '.self::TABLE.' item
          LEFT JOIN #__shoppingoverview_categories cat ON (cat.id = item.cat_id)
          LEFT JOIN #__shoppingoverview_deliverys del ON (del.id = item.delivery_id)
          LEFT JOIN #__shoppingoverview_likes lik ON (lik.post_id = item.id)
          LEFT JOIN #__shoppingoverview_comments com ON (com.post_id = item.id)
          LEFT JOIN #__shoppingoverview_favorites fav ON (fav.post_id = item.id AND fav.published = 1)
          WHERE
          item.user_id = '.$database->quote($user_id).' AND
          (item.published = 1 OR item.user_id = '.$database->quote($user->id).')
          AND
          item.trash = 0
        ';

        if(!empty($cat_id)){
            $sql .= '
                AND
                item.cat_id ='.$database->quote($cat_id);
        }

        $sql .= ' 
          GROUP BY item.id
          ORDER BY item.id DESC
          LIMIT '.$count.', 10
        ';

        $database->setQuery($sql);
        $result = $database->loadObjectList();

        return $result;
    }

    public function save($data,$privilege=array()){

        $data->created = date('Y-m-d H:i:s');
        $data->modified = date('Y-m-d H:i:s');
        $data->published = 0;
        $database = $this->db;

        if(empty($data->alias_ru)){
            $data->alias_ru = $data->product.' '.$data->title_ru;
        }

        if(empty($data->alias_en)){
            $data->alias_en = $data->product.' '.$data->title_en;
        }

        if(empty($data->alias_he)){
            $data->alias_he = $data->product.' '.$data->title_he;
        }

        $data->alias_ru = $this->generationAlias('ru',$data->alias_ru,$data->id);
        $data->alias_en = $this->generationAlias('en',$data->alias_en,$data->id);
        $data->alias_he = $this->generationAlias('he',$data->alias_he,$data->id);

        if(in_array("publication_without_verification",$privilege)){
            $data->published = 1;
        }

        if(isset($data->id) && $data->id != ''){

            $database->setQuery('UPDATE '.self::TABLE.'
            SET
            cat_id = '.$database->quote($data->cat_id).',
            product = '.$database->quote($data->product).',
            title_ru = '.$database->quote($data->title_ru).',
            title_en = '.$database->quote($data->title_en).',
            title_he = '.$database->quote($data->title_he).',
            alias_ru = '.$database->quote($data->alias_ru).',
            alias_en = '.$database->quote($data->alias_en).',
            alias_he = '.$database->quote($data->alias_he).',
            hwp_text_ru = '.$database->quote($data->hwp_text_ru).',
            hwp_text_en = '.$database->quote($data->hwp_text_en).',
            hwp_text_he = '.$database->quote($data->hwp_text_he).',
            mini_text_ru = '.$database->quote($data->mini_text_ru).',
            mini_text_en = '.$database->quote($data->mini_text_en).',
            mini_text_he = '.$database->quote($data->mini_text_he).',
            text_ru = '.$database->quote($data->text_ru).',
            text_en = '.$database->quote($data->text_en).',
            text_he = '.$database->quote($data->text_he).',
            price = '.$database->quote($data->price).',
            delivery_id = '.$database->quote($data->delivery_id).',
            shop_name = '.$database->quote($data->shop_name).',
            shop = '.$database->quote($data->shop).',
            youtube = '.$database->quote($data->youtube).',
            youtube_begin_end = '.$database->quote($data->youtube_begin_end).',
            modified = '.$database->quote($data->modified).',
            modified_user_id = '.$database->quote($data->modified_user_id).',
            published = '.$database->quote($data->published).'
            WHERE
            user_id = '.$database->quote($data->user_id).'
            AND
            id = '.$database->quote($data->id).'
            ');
        }else{

            $database->setQuery('INSERT INTO '.self::TABLE.'
            (
            `user_id`,
            `cat_id`,
            `product`,
            `title_ru`,
            `title_en`,
            `title_he`,
            `alias_ru`,
            `alias_en`,
            `alias_he`,
            `hwp_text_ru`,
            `hwp_text_en`,
            `hwp_text_he`,
            `mini_text_ru`,
            `mini_text_en`,
            `mini_text_he`,
            `text_ru`,
            `text_en`,
            `text_he`,
            `price`,
            `delivery_id`,
            `shop_name`,
            `shop`,
            `youtube`,
            `youtube_begin_end`,
            `modified`,
            `modified_user_id`,
            `created`
            )
            VALUES
            (
            '.$database->quote($data->user_id).',
            '.$database->quote($data->cat_id).',
            '.$database->quote($data->product).',
            '.$database->quote($data->title_ru).',
            '.$database->quote($data->title_en).',
            '.$database->quote($data->title_he).',
            '.$database->quote($data->alias_ru).',
            '.$database->quote($data->alias_en).',
            '.$database->quote($data->alias_he).',
            '.$database->quote($data->hwp_text_ru).',
            '.$database->quote($data->hwp_text_en).',
            '.$database->quote($data->hwp_text_he).',
            '.$database->quote($data->mini_text_ru).',
            '.$database->quote($data->mini_text_en).',
            '.$database->quote($data->mini_text_he).',
            '.$database->quote($data->text_ru).',
            '.$database->quote($data->text_en).',
            '.$database->quote($data->text_he).',
            '.$database->quote($data->price).',
            '.$database->quote($data->delivery_id).',
            '.$database->quote($data->shop_name).',
            '.$database->quote($data->shop).',
            '.$database->quote($data->youtube).',
            '.$database->quote($data->youtube_begin_end).',
            '.$database->quote($data->modified).',
            '.$database->quote($data->modified_user_id).',
            '.$database->quote($data->created).'
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

    function delete($id=null,$user_id=null){

        $database = $this->db;

        $sql = 'UPDATE '.self::TABLE.' SET trash = '.$database->quote('1').' WHERE id = '.$database->quote($id).' AND user_id = '.$database->quote($user_id).'';

        $database->setQuery($sql);

        if($database->query()){
            return true;
        }else{
            return false;
        }

    }

    function up_date($id=null){

        $data = date('Y-m-d H:i:s');

        $database = $this->db;

        $sql = 'UPDATE '.self::TABLE.' SET up_date = '.$database->quote($data).' WHERE id = '.$database->quote($id);

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

        if(empty($data->user_id)){
            $error['text'] .= JText::_('COM_SHOPPINGOVERVIEW_USER_IS_NOT_FOUND')."<br/>";
            $error['status'] = false;
        }

        if(empty($data->product)){
            $error['text'] .= JText::_('COM_SHOPPINGOVERVIEW_PRODUCT_IS_EMPTY')."<br/>";
            $error['status'] = false;
        }

        if(empty($data->price)){
            $error['text'] .= JText::_('COM_SHOPPINGOVERVIEW_PRICE_IS_NOT_FILLED')."<br/>";
            $error['status'] = false;
        }

        if(empty($data->delivery_id)){
            $error['text'] .= JText::_('COM_SHOPPINGOVERVIEW_PAYMENT_NOT_COMPLETED')."<br/>";
            $error['status'] = false;
        }

        if(empty($data->shop_name)){
            $error['text'] .= JText::_('COM_SHOPPINGOVERVIEW_STORE_NAME_IS_NOT_FILLED')."<br/>";
            $error['status'] = false;
        }

        if(empty($data->shop)){
            $error['text'] .= JText::_('COM_SHOPPINGOVERVIEW_STORE_LINK_IS_EMPTY')."<br/>";
            $error['status'] = false;
        }

        /*
        if(empty($data->youtube)){
            $error['text'] .= JText::_('COM_SHOPPINGOVERVIEW_THE_LINK_TO_THE_YOUTUBE_IS_NOT_FILLED')."<br/>";
            $error['status'] = false;
        }
        */

        if(empty($data->title_ru) || empty($data->title_en) || empty($data->title_he)){
            $error['text'] .= JText::_('COM_SHOPPINGOVERVIEW_HEADERS_ARE_NOT_FILLED')."<br/>";
            $error['status'] = false;
        }

        if(empty($data->hwp_text_ru) || empty($data->hwp_text_en) || empty($data->hwp_text_he)){
            $error['text'] .= JText::_('COM_SHOPPINGOVERVIEW_MINI_TEXTS_ARE_NOT_FILLED')."<br/>";
            $error['status'] = false;
        }

        if(empty($data->mini_text_ru) || empty($data->mini_text_en) || empty($data->mini_text_he)){
            $error['text'] .= JText::_('COM_SHOPPINGOVERVIEW_MINI_TEXTS_ARE_NOT_FILLED')."<br/>";
            $error['status'] = false;
        }

        if(empty($data->text_ru) || empty($data->text_en) || empty($data->text_he)){
            $error['text'] .= JText::_('COM_SHOPPINGOVERVIEW_TEXTS_ARE_NOT_FILLED')."<br/>";
            $error['status'] = false;
        }

        return $error;

    }

    function formating($data,$modelImages){

        $content_ru = '';
        $content_en = '';
        $content_he = '';
        $regex = "@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@";

        for($i=0;$i<=9;$i++){

            $img = $modelImages->getItem($data->images_ru[$i]);
            if($img != null){
                $content_ru .= '<img src="/images/upload/'.$img->src.'"/>';
            }

            $content_ru .= preg_replace($regex, '', strip_tags($data->text_ru[$i]));

            $img = $modelImages->getItem($data->images_en[$i]);
            if($img != null){
                $content_en .= '<img src="/images/upload/'.$img->src.'"/>';
            }

            $content_en .= preg_replace($regex, '', strip_tags($data->text_en[$i]));


            $img = $modelImages->getItem($data->images_he[$i]);
            if($img != null){
                $content_he .= '<img src="/images/upload/'.$img->src.'"/>';
            }

            $content_he .= preg_replace($regex, '', strip_tags($data->text_he[$i]));

        }

        $result['content_ru'] = $content_ru;
        $result['content_en'] = $content_en;
        $result['content_he'] = $content_he;

        return $result;

    }

    public function isAliasExist($lang,$alias,$id=null){

        $database = $this->db;

        $sql = '
          SELECT COUNT(*)
          FROM '.self::TABLE.'
          WHERE alias_'.$lang.' = '.$database->quote($alias).'
        ';

        if(!empty($id)){
            $sql .= ' AND id !='.$database->quote($id);
        }

        $database->setQuery($sql);

        return ($database->loadResult() ? true : false);

    }

    public function generationAlias($lang,$text="",$id=null){

        $text = trim(strip_tags($text));

        $alias = JFilterOutput::stringURLSafe($text);

        if(empty($alias)){
            $alias = "product";
        }

        $alias_ini = $alias;

        for ($i = 2; $this->isAliasExist($lang,$alias,$id); $i++) {
            $alias = $alias_ini . '-' . $i;
        }

        return $alias;
    }

    public function itemCat($user_id = null){

        $database = $this->db;

        $amx = "
            SELECT
            cats.*,
            count(items.id) AS count
            FROM #__shoppingoverview_categories AS cats
            LEFT JOIN #__shoppingoverview_items AS items ON (items.cat_id = cats.id)
            WHERE cats.published = 1 AND items.published = 1 AND items.user_id=".$database->quote($user_id)."
            GROUP BY cats.id
            ORDER BY cats.id DESC
        ";

        $database->setQuery($amx);

        $result = $database->loadObjectList();

        return $result;
    }

}
<?php

// No direct access
defined( '_JEXEC' ) or die;

/**
 * @author Воропаев Валентин
 */

jimport('joomla.application.component.modellist');

class ShoppingoverviewModelItems extends JModelList
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
        $this->db = parent::getDbo();;
    }

    public function getForm($data = array(), $loadData = true)
    {
        $form = $this->loadForm('com_shoppingoverview.items', 'items', array('control' => 'jform', 'load_data' => $loadData));
        if (empty($form)) {
            return false;
        }
        return $form;
    }

    public function getListItems($filter = null,$count=null){

        if($filter == null){
            $filter = new stdClass();
            $filter->published = '0';
            $filter->trash = '0';
            $filter->search = '';
            $filter->ordering ='id DESC';
            $filter->limit = '10';
        }

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
          WHERE item.id != ""
        ';

        if($filter->search != ''){
            $sql .= '
                AND item.id LIKE '.$database->quote($filter->search).'
            ';
        }

        if(!empty($filter->trash)){
            $sql .= '
                AND item.trash = '.$database->quote($this->yasOrNo($filter->trash)).'
            ';
        }

        if(!empty($filter->published)){
            $sql .= '
                AND item.published = '.$database->quote($this->yasOrNo($filter->published)).'
            ';
        }

        $sql .= '
          GROUP BY item.id
        ';

        $sql .= '
          ORDER BY item.'.$filter->ordering
        ;

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
          SELECT item.*
          FROM '.self::TABLE.' AS item
          WHERE item.id = '.$database->quote($id).'
          LIMIT 1
        ');

        $result = $database->loadObject();

        return $result;
    }

    public function save($data){

        $user   = JFactory::getUser();

        $data->modified_user_id = $user->id;

        $data->created = date('Y-m-d H:i:s');
        $data->modified = date('Y-m-d H:i:s');
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

        if(isset($data->id) && $data->id != ''){

            $database->setQuery('UPDATE '.self::TABLE.'
            SET
            user_id = '.$database->quote($data->user_id).',
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
            published = '.$database->quote($data->published).',
            modified = '.$database->quote($data->modified).',
            modified_user_id = '.$database->quote($data->modified_user_id).',
            trash = '.$database->quote($data->trash).'
            WHERE id = '.$database->quote($data->id).'
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
            `created`,
            `modified`,
            `modified_user_id`,
            `published`,
            `trash`
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
            '.$database->quote($data->created).',
            '.$database->quote($data->modified).',
            '.$database->quote($data->modified_user_id).',
            '.$database->quote($data->published).',
            '.$database->quote($data->trash).'
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

    function duplicate($data){

        foreach($data as $item){

            $copy = $this->getItem($item);
            unset($copy->id);
            unset($copy->cat_id);
            unset($copy->published);
            $this->save($copy);

        }

    }

    public function validate($data){

        $error = array();
        $error['text'] = "";
        $error['status'] = true;

        if(empty($data->user_id)){
            $error['text'] .= "Пользователь не заполнено<br/>";
            $error['status'] = false;
        }

        if(empty($data->product)){
            $error['text'] .= "Продукт не заполнено<br/>";
            $error['status'] = false;
        }

        if(empty($data->price)){
            $error['text'] .= "Цена не заполнено<br/>";
            $error['status'] = false;
        }

        if(empty($data->delivery_id)){
            $error['text'] .= "Оплата не заполнено<br/>";
            $error['status'] = false;
        }

        if(empty($data->shop_name)){
            $error['text'] .= "Название магазина не заполнено<br/>";
            $error['status'] = false;
        }

        if(empty($data->shop)){
            $error['text'] .= "Ссылка на магазин не заполнено<br/>";
            $error['status'] = false;
        }

        if(empty($data->title_ru) && empty($data->title_en) && empty($data->title_he)){
            $error['text'] .= "Заголовок не заполнено<br/>";
            $error['status'] = false;
        }

        if(empty($data->text_ru) && empty($data->text_en) && empty($data->text_he)){
            $error['text'] .= "Текст не заполнено<br/>";
            $error['status'] = false;
        }

        return $error;

    }

    function formating($data,$modelImages){

        $content_ru = '';
        $content_en = '';
        $content_he = '';

        for($i=0;$i<=9;$i++){

            $img = $modelImages->getItem($data->images_ru[$i]);
            if($img != null){
                $content_ru .= '<img src="/images/upload/'.$img->src.'"/>';
            }
            $content_ru .= $data->text_ru[$i];


            $img = $modelImages->getItem($data->images_en[$i]);
            if($img != null){
                $content_en .= '<img src="/images/upload/'.$img->src.'"/>';
            }
            $content_en .= $data->text_en[$i];


            $img = $modelImages->getItem($data->images_he[$i]);
            if($img != null){
                $content_he .= '<img src="/images/upload/'.$img->src.'"/>';
            }
            $content_he .= $data->text_he[$i];

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

    public function yasOrNo($num){

        if($num == 2){
            $num = 0;
        }else{
            $num = 1;
        }

        return $num;
    }

}
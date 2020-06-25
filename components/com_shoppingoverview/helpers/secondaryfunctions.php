<?php

defined( '_JEXEC' ) or die;


class DopFunction
{

    public static function convertJSNO($data,$convert=true){


        if($convert == true){

            $result = json_encode($data);

        }else{

            $result = json_decode($data);

        }

        return $result;

    }

    public static function getRoutPosition($params){
        $app = JFactory::getApplication();
        $option          = $app->input->get('option', '', 'string');
        $controller      = $app->input->get('controller', '', 'string');
        $task            = $app->input->get('task', '', 'string');
        $cat_alias       = $app->input->get('cat_alias', '', 'string');
        $item_alias      = $app->input->get('item_alias', '', 'string');
        $getRoutPosition = $params->get('getRoutPosition');

        $opacity = false;

        if(empty($getRoutPosition)){
            return false;
        }

        // это все страницы
        if(in_array('all',$getRoutPosition)){
            $opacity = true;
        }

        // это главная
        if($option == 'com_shoppingoverview' && empty($controller) && empty($task) && empty($cat_alias) && empty($item_alias) && in_array('home',$getRoutPosition)){
            $opacity = true;
        }

        // это категории
        if($option == 'com_shoppingoverview' && empty($controller) && $task == 'categories' && !empty($cat_alias) && empty($item_alias) && in_array('categories',$getRoutPosition)){
            $opacity = true;
        }

        // это обзор
        if($option == 'com_shoppingoverview' && empty($controller) && $task == 'show' && !empty($cat_alias) && !empty($item_alias) && in_array('item',$getRoutPosition)){
            $opacity = true;
        }

        // это поиск
        if($option == 'com_shoppingoverview' && $controller == 'search' && empty($task) && empty($cat_alias) && empty($item_alias) && in_array('search',$getRoutPosition)){
            $opacity = true;
        }

        // это Добовление/Редактирование
        if($option == 'com_shoppingoverview' && empty($controller) && $task == 'edit' && empty($cat_alias) && empty($item_alias) && in_array('edit',$getRoutPosition)){
            $opacity = true;
        }

        // это Мои обзоры
        if($option == 'com_shoppingoverview' && $controller == 'users' && $task == 'useritems' && empty($cat_alias) && empty($item_alias) && in_array('useritems',$getRoutPosition)){
            $opacity = true;
        }

        // это Моё избранное
        if($option == 'com_shoppingoverview' && $controller == 'users' && $task == 'userfavorites' && empty($cat_alias) && empty($item_alias) && in_array('userfavorites',$getRoutPosition)){
            $opacity = true;
        }

        // это Мои подписки
        if($option == 'com_shoppingoverview' && $controller == 'users' && $task == 'usersubscribes' && empty($cat_alias) && empty($item_alias) && in_array('usersubscribes',$getRoutPosition)){
            $opacity = true;
        }

        // это История просмотров
        if($option == 'com_shoppingoverview' && $controller == 'users' && $task == 'userhits' && empty($cat_alias) && empty($item_alias) && in_array('userhits',$getRoutPosition)){
            $opacity = true;
        }

        // это Редактировать профиль
        if($option == 'com_users' && empty($controller) && empty($task) && empty($cat_alias) && empty($item_alias) && in_array('editprofile',$getRoutPosition)){
            $opacity = true;
        }

        // это Редактировать социальные аккаунты
        if($option == 'com_slogin' && empty($controller) && empty($task) && empty($cat_alias) && empty($item_alias) && in_array('editsocialprofile',$getRoutPosition)){
            $opacity = true;
        }

        return $opacity;

    }

    public static function viewPublish($item){
        if($item == 1){
            return 'Да';
        }else{
            return 'Нет';
        }
    }

    public static function getInfoFacebook(){

        $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $resultArr = file_get_contents('https://graph.facebook.com/v3.3/?fields=engagement&access_token=1658713200805550|f6528fafa4ade18cad7a9ce6f7063adb&id='.urlencode($url));
        $resultArr = json_decode($resultArr);
        return $resultArr;

    }

    public static function getIdYoutube ($url){

        if ( strripos($url, 'youtube.com') ) {
            preg_match('/[?&]v=(.+)[&]*/',$url,$matches);
            if ($matches[1]) { $id = $matches[1]; } else {
                return false;
            }
        } else {
            preg_match('/be\/(.+)[?&]*/',$url,$matches);
            if ($matches[1]) { $id = $matches[1]; } else {
                return false;
            }
        }

        return $id;

    }

    // получаем Тег <img> и возврашаем его ширину и высоту
    public static function getWidthAndHeightImg($img){
        $baseUrl = JUri::base();
        $imgAgr = new stdClass();
        $imgAgr->width = 0;
        $imgAgr->height = 0;

        preg_match('#src="(.*)"#isu',$img, $resultSrc);

        if( isset($resultSrc[1]) && !empty($resultSrc[1]) ){
            $getimagesize = new JImage( JPATH_SITE.$resultSrc[1] );
            $imgAgr->width = $getimagesize->getWidth();
            $imgAgr->height = $getimagesize->getHeight();
        }

        return $imgAgr;
    }

    public static function getUrlImg($img){
        $imgAgr = "";
        preg_match('#src="(.*)"#isu',$img, $resultSrc);
        if( isset($resultSrc[1]) && !empty($resultSrc[1]) ){
            $imgAgr = $resultSrc[1];
        }
        return $imgAgr;
    }

    // массив в обэкт
    public static function arrayToObjects($arr){
        $object = new stdClass();
        foreach ($arr as $key => $value) {
            $object->{$key} = $value;
        }
        return $object;
    }

    public static function textToMini($text,$count=200){
        $text = strip_tags($text);
        $text = mb_substr($text, 0, $count);
        $text = $text.'..';
        return $text;
    }

    public static function imgToMini($img){
        return str_replace('/upload/','/upload/thumbs/',$img);
    }

    // предоставляет возможность переводить текст
    public static function translate($source,$target,$text){

        $trans = new GoogleTranslate();
        $result = $trans->translate($source, $target, $text);
        return $result;

    }

    public static function replaceThreeZeros($numbers){

        if ($numbers >= 1000000){
            $numbers = round($numbers * 0.000001, 1);
            $numbers .= 'M';
        }

        if ($numbers >= 1000){
            $numbers = round($numbers * 0.001, 1);
            $numbers .= 'k';
        }

        return $numbers;
    }

    // удобный вывод даты
    public static function showDate( $date, $lang = null ) // $date --> время в формате Unix time
    {

        if(!empty($lang)){
            $language = JFactory::getLanguage();
            $language->load('com_shoppingoverview', JPATH_SITE, $lang, true);
            //$language->load('com_shoppingoverview', JPATH_SITE, null, true);
        }

        $stf      = 0;
        $cur_time = time();
        $diff     = $cur_time - $date;

        $seconds = array( JText::_('COM_SHOPPINGOVERVIEW_TEXT_4'), JText::_('COM_SHOPPINGOVERVIEW_TEXT_5'), JText::_('COM_SHOPPINGOVERVIEW_TEXT_6') );
        $minutes = array( JText::_('COM_SHOPPINGOVERVIEW_TEXT_7'), JText::_('COM_SHOPPINGOVERVIEW_TEXT_8'), JText::_('COM_SHOPPINGOVERVIEW_TEXT_9') );
        $hours   = array( JText::_('COM_SHOPPINGOVERVIEW_TEXT_10'), JText::_('COM_SHOPPINGOVERVIEW_TEXT_11'), JText::_('COM_SHOPPINGOVERVIEW_TEXT_12') );
        $days    = array( JText::_('COM_SHOPPINGOVERVIEW_TEXT_13'), JText::_('COM_SHOPPINGOVERVIEW_TEXT_14'), JText::_('COM_SHOPPINGOVERVIEW_TEXT_15') );
        $weeks   = array( JText::_('COM_SHOPPINGOVERVIEW_TEXT_16'), JText::_('COM_SHOPPINGOVERVIEW_TEXT_17'), JText::_('COM_SHOPPINGOVERVIEW_TEXT_18') );
        $months  = array( JText::_('COM_SHOPPINGOVERVIEW_TEXT_19'), JText::_('COM_SHOPPINGOVERVIEW_TEXT_20'), JText::_('COM_SHOPPINGOVERVIEW_TEXT_21') );
        $years   = array( JText::_('COM_SHOPPINGOVERVIEW_TEXT_22'), JText::_('COM_SHOPPINGOVERVIEW_TEXT_23'), JText::_('COM_SHOPPINGOVERVIEW_TEXT_24') );
        $decades = array( JText::_('COM_SHOPPINGOVERVIEW_TEXT_25'), JText::_('COM_SHOPPINGOVERVIEW_TEXT_26'), JText::_('COM_SHOPPINGOVERVIEW_TEXT_27') );

        $phrase = array( $seconds, $minutes, $hours, $days, $weeks, $months, $years, $decades );
        $length = array( 1, 60, 3600, 86400, 604800, 2630880, 31570560, 315705600 );

        for ( $i = sizeof( $length ) - 1; ( $i >= 0 ) && ( ( $no = $diff / $length[ $i ] ) <= 1 ); $i -- ) {
            ;
        }
        if ( $i < 0 ) {
            $i = 0;
        }
        $_time = $cur_time - ( $diff % $length[ $i ] );
        $no    = floor( $no );

        $cases = array( 2, 0, 1, 1, 1, 2 );
        $getPhrase = $phrase[ $i ][ ( $no % 100 > 4 && $no % 100 < 20 ) ? 2 : $cases[ min( $no % 10, 5 ) ] ];

        $value = sprintf( "%d %s ", $no, $getPhrase );

        if ( ( $stf == 1 ) && ( $i >= 1 ) && ( ( $cur_time - $_time ) > 0 ) ) {
            $value .= time_ago( $_time );
        }

        if(!empty($lang)){
            return JText::_('COM_SHOPPINGOVERVIEW_TEXT_2').' '.$value . ' '.JText::_('COM_SHOPPINGOVERVIEW_TEXT_3');
        }else{
            return $value . ' '.JText::_('COM_SHOPPINGOVERVIEW_TEXT_3');
        }

    }


    // функция разбивает на блоки весь текст
    public static function explodeReg($text,$model){

        preg_match_all('#(^[^<]+)|(<img[^>]+>)|((?<=>).+?(?=<i))|((?<=>).+?$)#isu',$text, $resultImg);

        if(isset($resultImg[0])){

            $i = 1;
            $result = array();

            $objReturn = new stdClass();
            $objReturn->img = '';
            $objReturn->imgId = '';
            $objReturn->text = '';
            $otmetka = 0;

            foreach($resultImg[0] as $item){

                preg_match('#<img[^>]+>#isu',$item, $resultText);

                if(!empty($resultText)){

                    if($otmetka == 1){

                        $i++;
                        $objReturn = new stdClass();
                        $objReturn->img = '';
                        $objReturn->imgId = '';
                        $objReturn->text = '';
                        $otmetka = 0;

                    }

                    preg_match('#src="(.*)"#isu',$item, $resultImgId);

                    $resultImgId = str_replace('/images/upload/','',$resultImgId[1]);
                    $imgId = $model->getItemSrc($resultImgId);

                    $objReturn->img = $item;
                    $objReturn->imgId = $imgId->id;

                    $result[$i] = $objReturn;

                    $otmetka = 1;

                }else{

                    $objReturn->text = $item;

                    $result[$i] = $objReturn;

                    $i++;
                    $objReturn = new stdClass();
                    $objReturn->img = '';
                    $objReturn->imgId = '';
                    $objReturn->text = '';
                    $otmetka = 0;

                }

            }

            return $result;

        }else{

            return false;

        }

    }

}
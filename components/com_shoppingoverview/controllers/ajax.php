<?php

// No direct access
defined( '_JEXEC' ) or die;
jimport('joomla.filesystem.file');

class ShoppingoverviewControllerAjax extends JControllerLegacy
{

    function __construct( $config = array() )
    {
        $app = JFactory::getApplication();
        $task = $app->input->get('task','display');
        $user = JFactory::getUser();
        $needcheck = 0;

        switch ($task) {
            case 'ajaxGetTitle':
                $needcheck = 1;
                break;
            case 'ajaxGetText':
                $needcheck = 1;
                break;
            case 'crops':
                $needcheck = 1;
                break;
            case 'ajaxUploadAvatar':
                $needcheck = 1;
                break;
            case 'ajaxUpload':
                $needcheck = 1;
                break;
        }

        if($needcheck == 1 && $user->get('guest') == 1){
            $app->enqueueMessage(JText::_('COM_SHOPPINGOVERVIEW_LOG_IN_TO_THE_SITE'), 'warning');
            $app->Redirect('/');
        }

        parent::__construct( $config );
    }

    function display( $cachable = false, $urlparams = array() ){
        $app = JFactory::getApplication();
        $app->Redirect('/');
    }

    function siteListingImgMiniAjax(){
        header('Content-Type: application/json');

        $session = JFactory::getSession();

        $massArrFilter = $session->get('listingImgMini', false);

        if($massArrFilter == false){
            $session->set('listingImgMini', true);
            $result['result'] = true;
        }

        exit();
    }

    function termsAgreementAjax(){

        header('Content-Type: application/json');

        $session = JFactory::getSession();

        $massArrFilter = $session->get('termsAgreement', false);

        if($massArrFilter == false){
            $session->set('termsAgreement', true);
            $result['result'] = true;
        }

        exit();
    }

    // Перевод заголовка
    function ajaxGetTitle(){
        header('Content-Type: application/json');
        $result = array('error' => 0, 'title_ru' => '', 'title_en' => '', 'title_he' => '');

        $app = JFactory::getApplication();

        $title_ru = trim(strip_tags($app->input->get('title_ru', '', 'string')));
        $title_en = trim(strip_tags($app->input->get('title_en', '', 'string')));
        $title_he = trim(strip_tags($app->input->get('title_he', '', 'string')));


        if(strlen($title_ru) == 0 && strlen($title_en) == 0 && strlen($title_he) == 0){

            $result['error'] = 1;
            echo json_encode($result);
            exit();

        }

        if(strlen($title_ru) > 0 && strlen($title_en) > 0 && strlen($title_he) > 0){

            $result['error'] = 1;
            echo json_encode($result);
            exit();

        }

        $langs = array();

        if($title_en != ''){
            if($title_ru == ''){
                $langs['en'][] = 'ru';
            }
            if($title_he == ''){
                $langs['en'][] = 'he';
            }
        }elseif($title_ru != ''){
            if($title_en == ''){
                $langs['ru'][] = 'en';
            }
            if($title_he == ''){
                $langs['ru'][] = 'he';
            }
        }elseif($title_he != ''){
            if($title_en == ''){
                $langs['he'][] = 'en';
            }
            if($title_ru == ''){
                $langs['he'][] = 'ru';
            }
        }

        if(count($langs) > 0){
            foreach($langs as $key => $value) {
                foreach($value as $item) {
                    $title_in = 'title_' . $item;
                    $title_out = 'title_' . $key;
                    $result[$title_in] = DopFunction::translate($key,$item,$$title_out);
                }
            }
        }

        echo json_encode($result);
        exit();
    }

    // Перевод текста и перенос картинок на другой язык
    function ajaxGetText(){

        header('Content-Type: application/json');
        $result = array(
            'error' => 0,
            'text_ru' => '',
            'text_en' => '',
            'text_he' => '',
            'mini_text_ru' => '',
            'mini_text_en' => '',
            'mini_text_he' => '',
            'hwp_text_ru' => '',
            'hwp_text_en' => '',
            'hwp_text_he' => '',
        );

        // символ разделения
        $sQs = '~';

        $app = JFactory::getApplication();
        $argv = $app->input->get('jform', array(), 'array');

        if(!isset($argv['myFieldset']['text_ru']) || !isset($argv['myFieldset']['text_en']) || !isset($argv['myFieldset']['text_he'])){
            $result['error'] = JText::_('COM_SHOPPINGOVERVIEW_DATA_NOT_SENT');
            echo json_encode($result);
            exit();
        }

        if(!isset($argv['myFieldset']['mini_text_ru']) || !isset($argv['myFieldset']['mini_text_en']) || !isset($argv['myFieldset']['mini_text_he'])){
            $result['error'] = JText::_('COM_SHOPPINGOVERVIEW_DATA_NOT_SENT');
            echo json_encode($result);
            exit();
        }

        if(!isset($argv['myFieldset']['hwp_text_ru']) || !isset($argv['myFieldset']['hwp_text_en']) || !isset($argv['myFieldset']['hwp_text_he'])){
            $result['error'] = JText::_('COM_SHOPPINGOVERVIEW_DATA_NOT_SENT');
            echo json_encode($result);
            exit();
        }


        $text_ru = '';
        $text_en = '';
        $text_he = '';

        $mini_text_ru = trim(strip_tags($argv['myFieldset']['mini_text_ru']));
        $mini_text_en = trim(strip_tags($argv['myFieldset']['mini_text_en']));
        $mini_text_he = trim(strip_tags($argv['myFieldset']['mini_text_he']));

        $hwp_text_ru = trim(strip_tags($argv['myFieldset']['hwp_text_ru']));
        $hwp_text_en = trim(strip_tags($argv['myFieldset']['hwp_text_en']));
        $hwp_text_he = trim(strip_tags($argv['myFieldset']['hwp_text_he']));

        for($i=0;$i<=9;$i++){

            $qw_ru = trim(strip_tags($argv['myFieldset']['text_ru'][$i]));
            $qw_en = trim(strip_tags($argv['myFieldset']['text_en'][$i]));
            $qw_he = trim(strip_tags($argv['myFieldset']['text_he'][$i]));

            $qw_ru = str_replace($sQs,'',$qw_ru);
            $qw_en = str_replace($sQs,'',$qw_en);
            $qw_he = str_replace($sQs,'',$qw_he);

            $text_ru .= $qw_ru.$sQs;
            $text_en .= $qw_en.$sQs;
            $text_he .= $qw_he.$sQs;

        }

        $langs = array();
        $mini_langs = array();
        $promejutok_ru = $text_ru;
        $promejutok_en = $text_en;
        $promejutok_he = $text_he;
        $text_ru = str_replace($sQs,'',$text_ru);
        $text_en = str_replace($sQs,'',$text_en);
        $text_he = str_replace($sQs,'',$text_he);

        //var_dump($text_ru);
        //var_dump($text_en);
        //var_dump($text_he);

        if($text_en != ''){
                $langs['en'][] = 'ru';
                $langs['en'][] = 'he';
        }elseif($text_ru != ''){
                $langs['ru'][] = 'en';
                $langs['ru'][] = 'he';
        }elseif($text_he != ''){
                $langs['he'][] = 'en';
                $langs['he'][] = 'ru';
        }

        if($mini_text_en != ''){
            $mini_langs['en'][] = 'ru';
            $mini_langs['en'][] = 'he';
        }elseif($mini_text_ru != ''){
            $mini_langs['ru'][] = 'en';
            $mini_langs['ru'][] = 'he';
        }elseif($mini_text_he != ''){
            $mini_langs['he'][] = 'en';
            $mini_langs['he'][] = 'ru';
        }

        if($hwp_text_en != ''){
            $hwp_langs['en'][] = 'ru';
            $hwp_langs['en'][] = 'he';
        }elseif($hwp_text_ru != ''){
            $hwp_langs['ru'][] = 'en';
            $hwp_langs['ru'][] = 'he';
        }elseif($hwp_text_he != ''){
            $hwp_langs['he'][] = 'en';
            $hwp_langs['he'][] = 'ru';
        }

        //print_r($langs);

        $text_ru = $promejutok_ru;
        $text_en = $promejutok_en;
        $text_he = $promejutok_he;

        // Проверяем не слишком ли много символов

        if(mb_strlen($hwp_text_ru, 'UTF-8') >= 10000){
            $result['error'] = JText::_('COM_SHOPPINGOVERVIEW_CAN_NOT_TRANSLATE_1');
            echo json_encode($result);
            exit();
        }
        if(mb_strlen($hwp_text_en, 'UTF-8') >= 10000){
            $result['error'] = JText::_('COM_SHOPPINGOVERVIEW_CAN_NOT_TRANSLATE_3');
            echo json_encode($result);
            exit();
        }
        if(mb_strlen($hwp_text_he, 'UTF-8') >= 10000){
            $result['error'] = JText::_('COM_SHOPPINGOVERVIEW_CAN_NOT_TRANSLATE_5');
            echo json_encode($result);
            exit();
        }

        if(mb_strlen($mini_text_ru, 'UTF-8') >= 10000){
            $result['error'] = JText::_('COM_SHOPPINGOVERVIEW_CAN_NOT_TRANSLATE_1');
            echo json_encode($result);
            exit();
        }
        if(mb_strlen($mini_text_en, 'UTF-8') >= 10000){
            $result['error'] = JText::_('COM_SHOPPINGOVERVIEW_CAN_NOT_TRANSLATE_3');
            echo json_encode($result);
            exit();
        }
        if(mb_strlen($mini_text_he, 'UTF-8') >= 10000){
            $result['error'] = JText::_('COM_SHOPPINGOVERVIEW_CAN_NOT_TRANSLATE_5');
            echo json_encode($result);
            exit();
        }
        if(mb_strlen($text_ru, 'UTF-8') >= 50000){
            $result['error'] = JText::_('COM_SHOPPINGOVERVIEW_CAN_NOT_TRANSLATE_2');
            echo json_encode($result);
            exit();
        }
        if(mb_strlen($text_en, 'UTF-8') >= 50000){
            $result['error'] = JText::_('COM_SHOPPINGOVERVIEW_CAN_NOT_TRANSLATE_4');
            echo json_encode($result);
            exit();
        }
        if(mb_strlen($text_he, 'UTF-8') >= 50000){
            $result['error'] = JText::_('COM_SHOPPINGOVERVIEW_CAN_NOT_TRANSLATE_6');
            echo json_encode($result);
            exit();
        }

        //print_r($text_ru);
        //print_r($text_en);
        //print_r($text_he);

        if(count($langs) > 0){
            foreach($langs as $key => $value) {
                foreach($value as $item) {
                    $text_in = 'text_' . $item;
                    $text_out = 'text_' . $key;
                    $$text_in = DopFunction::translate($key,$item,$$text_out);
                    $$text_in = explode($sQs,$$text_in);
                }
            }
        }


        if(count($mini_langs) > 0){
            foreach($mini_langs as $key => $value) {
                foreach($value as $item) {
                    $mini_text_in = 'mini_text_' . $item;
                    $mini_text_out = 'mini_text_' . $key;
                    $$mini_text_in = DopFunction::translate($key,$item,$$mini_text_out);
                }
            }
        }

        if(count($hwp_langs) > 0){
            foreach($hwp_langs as $key => $value) {
                foreach($value as $item) {
                    $hwp_text_in = 'hwp_text_' . $item;
                    $hwp_text_out = 'hwp_text_' . $key;
                    $$hwp_text_in = DopFunction::translate($key,$item,$$hwp_text_out);
                }
            }
        }

        //print_r($text_ru);
        //print_r($text_en);
        //print_r($text_he);

        if(is_array($text_ru)){
            $result['text_ru'] = $text_ru;
        }

        if(is_array($text_en)){
            $result['text_en'] = $text_en;
        }

        if(is_array($text_he)){
            $result['text_he'] = $text_he;
        }

        $result['mini_text_ru'] = $mini_text_ru;
        $result['mini_text_en'] = $mini_text_en;
        $result['mini_text_he'] = $mini_text_he;

        $result['hwp_text_ru'] = $hwp_text_ru;
        $result['hwp_text_en'] = $hwp_text_en;
        $result['hwp_text_he'] = $hwp_text_he;

        echo json_encode($result);
        exit();
    }

    function ajaxUpload(){
        header('Content-Type: application/json');
        $params = &JComponentHelper::getParams('com_shoppingoverview');
        $result = array('error' => 0, 'img' => '', 'id' => 0);

        $user_id = JFactory::getUser()->id;

        $app = JFactory::getApplication();
        $file = $app->input->files->get('file');
        $size = $file['size']/1000/1000;
        $allowed_ext = array('image/jpeg','image/png');
        $getimagesize = getimagesize($file['tmp_name']);
        $width = $getimagesize[0];
        $height = $getimagesize[1];

        if( $file['error'] != 0 ){
            $result['error'] = JText::_('COM_SHOPPINGOVERVIEW_SOMETHING_IS_WRONG_WITH_THE_FILE');
        }elseif( $size > $params->get('img_size') ){
            $result['error'] = JText::sprintf( 'COM_SHOPPINGOVERVIEW_DO_NOT_UPLOAD_PHOTOS_MORE_MEGABYTES', $params->get('img_size') );
        }elseif( !in_array($file['type'],$allowed_ext) ){
            $result['error'] = JText::_('COM_SHOPPINGOVERVIEW_YOU_CAN_DOWNLOAD_THE_FOLLOWING_FORMATS');
        }elseif( $width < $params->get('img_size_min_width') || $height < $params->get('img_size_min_height') ){
            $result['error'] = JText::sprintf( 'COM_SHOPPINGOVERVIEW_MINIMUM_RESOLUTION_IN_HEIGHT_AND_WIDTH', $params->get('img_size_min_width'), $params->get('img_size_min_height') );
        }

        if($result['error'] !== 0){
            echo json_encode($result);
            exit();
        }

        if('image/jpeg' == $file['type']){
            $type = '.jpg';
        }elseif('image/png' == $file['type']){
            $type = '.png';
        }else{
            $type = '.jpg';
        }

        $unic = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
        $filename = $unic.$type;

        // Нужно поправаить так как путь не правельный
        if(file_exists($unic.$type)){
            $filename = $unic.$filename;
        }

        $src  = $file['tmp_name'];
        $big_img = JPATH_SITE . '/images/upload/' . $filename;
        $min_img = JPATH_SITE . '/images/upload/thumbs/' . $filename;

        $image = new JImage( $src );

        if ( $image->isLoaded() ) {

            // обрезаем большую картинку
            if( $image->getWidth() > $params->get('img_size_max_width') || $image->getHeight() > $params->get('img_size_max_height') ){

                if($image->getWidth() > $image->getHeight() ){
                    $image->resize($params->get('img_size_max_width'), $params->get('img_size_max_height'), false, JImage::SCALE_INSIDE );
                }else{
                    $image->resize($params->get('img_size_max_width'), $params->get('img_size_max_height'), false, JImage::SCALE_OUTSIDE );
                }

            }

            $image->toFile( $big_img );

            $image = new JImage( $big_img );

            /*
            // Создает миниатюру
            if($image->getWidth() < $image->getHeight() ){
                $image->resize($params->get('img_size_min_width'), $params->get('img_size_min_height'), false, JImage::SCALE_INSIDE );
            }else{
                $image->resize($params->get('img_size_min_width'), $params->get('img_size_min_height'), false, JImage::SCALE_OUTSIDE );
            }


            // обрезаем по цетру для миниатюр одинакового размера
            //$image->cropResize( $params->get('img_size_min_width'), $params->get('img_size_min_height'), false );

            $image->toFile( $min_img );
            */


            $model = $this->getModel('images');

            $result['img'] = $filename;
            $result['id'] = $model->save($filename,$user_id);
            $result['imgWidth'] = $image->getWidth();
            $result['imgHeight'] = $image->getHeight();

        }else {
            $result['error'] = JText::_('COM_SHOPPINGOVERVIEW_COULD_NOT_UPLOAD_FILE');
        }

        echo json_encode($result);
        exit();

    }


    function ajaxUploadAvatar(){
        header('Content-Type: application/json');
        $params = &JComponentHelper::getParams('com_shoppingoverview');
        $result = array('error' => 0, 'img' => '');

        $app = JFactory::getApplication();
        $file = $app->input->files->get('file');
        $size = $file['size']/1000/1000;
        $allowed_ext = array('image/jpeg','image/png');
        $getimagesize = getimagesize($file['tmp_name']);
        $width = $getimagesize[0];
        $height = $getimagesize[1];

        if( $file['error'] != 0 ){
            $result['error'] = JText::_('COM_SHOPPINGOVERVIEW_SOMETHING_IS_WRONG_WITH_THE_FILE');
        }elseif( $size > $params->get('img_size') ){
            $result['error'] = JText::sprintf( 'COM_SHOPPINGOVERVIEW_DO_NOT_UPLOAD_PHOTOS_MORE_MEGABYTES', $params->get('img_size') );
        }elseif( !in_array($file['type'],$allowed_ext) ){
            $result['error'] = JText::_('COM_SHOPPINGOVERVIEW_YOU_CAN_DOWNLOAD_THE_FOLLOWING_FORMATS');
        }elseif( $width < $params->get('img_size_min_width') || $height < $params->get('img_size_min_height') ){
            $result['error'] = JText::sprintf( 'COM_SHOPPINGOVERVIEW_MINIMUM_RESOLUTION_IN_HEIGHT_AND_WIDTH', $params->get('img_size_min_width'), $params->get('img_size_min_height') );
        }

        if($result['error'] !== 0){
            echo json_encode($result);
            exit();
        }

        if('image/jpeg' == $file['type']){
            $type = '.jpg';
        }elseif('image/png' == $file['type']){
            $type = '.png';
        }else{
            $type = '.jpg';
        }

        $unic = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
        $filename = $unic.$type;

        if(file_exists($unic.$type)){
            $filename = $unic.$filename;
        }

        $src  = $file['tmp_name'];
        $big_img = JPATH_SITE . '/images/avatar/' . $filename;

        $image = new JImage( $src );

        if ( $image->isLoaded() ) {

            // обрезаем большую картинку
            if( $image->getWidth() > $params->get('img_size_max_width') || $image->getHeight() > $params->get('img_size_max_height') ){

                if($image->getWidth() > $image->getHeight() ){
                    $image->resize($params->get('img_size_max_width'), $params->get('img_size_max_height'), false, JImage::SCALE_INSIDE );
                }else{
                    $image->resize($params->get('img_size_max_width'), $params->get('img_size_max_height'), false, JImage::SCALE_OUTSIDE );
                }

            }

            $image->toFile( $big_img );

            $image = new JImage( $big_img );

            $result['img'] = $filename;
            $result['imgWidth'] = $image->getWidth();
            $result['imgHeight'] = $image->getHeight();

        }else {
            $result['error'] = JText::_('COM_SHOPPINGOVERVIEW_COULD_NOT_UPLOAD_FILE');
        }

        echo json_encode($result);
        exit();

    }

    // обрезаем фото и создаем миниатюру
    public function crops(){

        header('Content-Type: application/json');
        $params = &JComponentHelper::getParams('com_shoppingoverview');
        $result = array('error' => 0, 'img' => '');

        $app = JFactory::getApplication();
        $img = $app->input->getString('qqimg', 0);
        $imgCoordinates = array();
        $imgCoordinates['coordinates_x1'] = $app->input->getString('qqx1', 0);
        $imgCoordinates['coordinates_y1'] = $app->input->getString('qqy1', 0);
        $imgCoordinates['coordinates_width'] = $app->input->getString('qqwidth', 0);
        $imgCoordinates['coordinates_height'] = $app->input->getString('qqheight', 0);


        $big_img = JPATH_SITE . $img;

        if (!file_exists($big_img)) {
            $result['error'] = JText::_('COM_SHOPPINGOVERVIEW_FILE_NOT_FOUND');
            echo json_encode($result);
            exit();
        }

        $image = new JImage( $big_img );

        $getimagesize = getimagesize($big_img);

        if('image/jpeg' == $getimagesize['mime']){
            $type = '.jpg';
        }elseif('image/png' == $getimagesize['mime']){
            $type = '.png';
        }else{
            $type = '.jpg';
        }

        $unic = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
        $filename = $unic.$type;

        if(file_exists($unic.$type)){
            $filename = $unic.$filename;
        }

        $big_img = JPATH_SITE . '/images/avatar/' . $filename;


        // обрезка неможет быть меньше минимальных параметров которые указаны в настройках
        if( $imgCoordinates['coordinates_width'] !=0 && $imgCoordinates['coordinates_width'] < 200 ){
            $imgCoordinates['coordinates_width'] = 200;
        }
        if( $imgCoordinates['coordinates_height'] !=0 && $imgCoordinates['coordinates_height'] < 200 ){
            $imgCoordinates['coordinates_height'] = 200;
        }

        // если стороны не одинаковые делаем их одинакововыми, орентир высота
        if( $imgCoordinates['coordinates_width'] != $imgCoordinates['coordinates_height'] ){
            $imgCoordinates['coordinates_width'] = $imgCoordinates['coordinates_height'];
        }

        if( $imgCoordinates['coordinates_width'] == 0 || $imgCoordinates['coordinates_height'] == 0 ){
            $image->cropResize( 200, 200, false );
            $image->toFile( $big_img );
        }else{
            $image->crop( $imgCoordinates['coordinates_width'], $imgCoordinates['coordinates_height'], $imgCoordinates['coordinates_x1'], $imgCoordinates['coordinates_y1'], false );
            $image->toFile( $big_img );
        }


        $image = new JImage( $big_img );
        $result['img'] = $filename;
        $result['imgWidth'] = $image->getWidth();
        $result['imgHeight'] = $image->getHeight();


        echo json_encode($result);
        exit();

    }



}
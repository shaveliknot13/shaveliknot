<?php

// No direct access
defined( '_JEXEC' ) or die;
jimport('joomla.filesystem.file');

class ShoppingoverviewControllersAjax extends JControllerLegacy
{

    function display( $cachable = false, $urlparams = array() ){
        $app = JFactory::getApplication();
        $app->Redirect('index.php?option=com_shoppingoverview');
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
                    sleep(1);

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
            'images_ru' => '',
            'images_en' => '',
            'images_he' => '',
        );

        $sQs = '~';

        $app = JFactory::getApplication();
        $argv = $app->input->get('jform', array(), 'array');

        if(!isset($argv['myFieldset']['text_ru']) || !isset($argv['myFieldset']['text_en']) || !isset($argv['myFieldset']['text_he'])){
            $result['error'] = 'Данные не переданы';
            echo json_encode($result);
            exit();
        }

        if(!isset($argv['myFieldset']['images_ru']) || !isset($argv['myFieldset']['images_en']) || !isset($argv['myFieldset']['images_he'])){
            $result['error'] = 'Данные не переданы';
            echo json_encode($result);
            exit();
        }

        $text_ru = '';
        $text_en = '';
        $text_he = '';
        $images_ru = array();
        $images_en = array();
        $images_he = array();

        for($i=0;$i<=9;$i++){

            $images_ru[$i] = trim(strip_tags($argv['myFieldset']['images_ru'][$i]));
            $images_en[$i] = trim(strip_tags($argv['myFieldset']['images_en'][$i]));
            $images_he[$i] = trim(strip_tags($argv['myFieldset']['images_he'][$i]));

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
            if($text_ru == ''){
                $langs['en'][] = 'ru';
            }
            if($text_he == ''){
                $langs['en'][] = 'he';
            }
        }elseif($text_ru != ''){
            if($text_en == ''){
                $langs['ru'][] = 'en';
            }
            if($text_he == ''){
                $langs['ru'][] = 'he';
            }
        }elseif($text_he != ''){
            if($text_en == ''){
                $langs['he'][] = 'en';
            }
            if($text_ru == ''){
                $langs['he'][] = 'ru';
            }
        }

        //print_r($langs);

        $text_ru = $promejutok_ru;
        $text_en = $promejutok_en;
        $text_he = $promejutok_he;

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
                    sleep(1);

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

        $result['images_ru'] = $images_ru;
        $result['images_en'] = $images_en;
        $result['images_he'] = $images_he;


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
            $result['error'] = 'Что то не так с файлом';
        }elseif( $size > $params->get('img_size') ){
            $result['error'] = 'Не загружайте фото больше '.$params->get('img_size').' мегабайт';
        }elseif( !in_array($file['type'],$allowed_ext) ){
            $result['error'] = 'Разрешена загрузка следующих форматов: jpg, jpeg и png';
        }elseif( $width < $params->get('img_size_min_width') || $height < $params->get('img_size_min_height') ){
            $result['error'] = 'Минимальное разрешение по высоте и ширине: '.$params->get('img_size_min_width').' х '.$params->get('img_size_min_height').' пикселей';
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
            $result['error'] = 'Не смог загрузить((';
        }

        echo json_encode($result);
        exit();

    }



}
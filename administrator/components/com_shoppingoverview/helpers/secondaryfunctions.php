<?php

defined( '_JEXEC' ) or die;


class DopFunction
{

    public static function siteLink($urlLink,$lang){
        $live_site = substr(JURI::root(), 0, -1);
        $app    = JApplication::getInstance('site');
        $router = &$app->getRouter();
        $url = $router->build($live_site.$urlLink);
        $url= $url->toString();
        $eventLink = str_replace($live_site .'/administrator', $live_site, $url);

        $eventLink = str_replace(array('/ru/','/en/','/he/'),'/'.$lang.'/',$eventLink);

        return $eventLink;
    }

    public static function viewPublish($item){
        if($item == 1){
            return 'Да';
        }else{
            return 'Нет';
        }
    }

    public static function viewType($item){
        if($item == 'base'){
            return 'Базовая деталь';
        }elseif($item == 'template'){
            return 'Шаблон письма';
        }
        return false;
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
<?php

// No direct access
defined( '_JEXEC' ) or die;

/**
 * @author Воропаев Валентин
 */

jimport('joomla.application.component.modellist');

class ShoppingoverviewModelImages extends JModelList
{

    const TABLE = '#__shoppingoverview_images';
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


    public function getItem($id=null){

        $database = $this->db;

        $database->setQuery('
          SELECT *
          FROM '.self::TABLE.'
          WHERE id = '.$database->quote($id).'
          LIMIT 1
        ');

        $result = $database->loadObject();

        return $result;
    }

    public function getItemSrc($src=null){

        $database = $this->db;

        $database->setQuery('
          SELECT *
          FROM '.self::TABLE.'
          WHERE src = '.$database->quote($src).'
          LIMIT 1
        ');

        $result = $database->loadObject();

        return $result;
    }

    public function save($src=null,$user_id=null){

        $database = $this->db;

        $database->setQuery('INSERT INTO '.self::TABLE.'
            (
            `user_id`,
            `src`
            )
            VALUES
            (
            '.$database->quote($user_id).',
            '.$database->quote($src).'
            )
            ');

        $new_id = $database->query();

        if($new_id){
            return $database->insertid();
        }else{
            return false;
        }

    }

    // обрезаем фото и создаем миниатюру
    public function crops($imgCoordinates){

        $params = &JComponentHelper::getParams('com_shoppingoverview');

        //var_dump($imgCoordinates);
        //die();

        foreach($imgCoordinates as $item){

            $imgObj = $this->getItem($item['id']);
            $big_img = JPATH_SITE . '/images/upload/' . $imgObj->src;
            $min_img = JPATH_SITE . '/images/upload/thumbs/' . $imgObj->src;
            $image = new JImage( $big_img );


            // обрезка неможет быть меньше минимальных параметров которые указаны в настройках
            if( $item['coordinates_width'] !=0 && $item['coordinates_width'] < $params->get('img_size_min_width') ){
                $item['coordinates_width'] = $params->get('img_size_min_width');
            }
            if( $item['coordinates_height'] !=0 && $item['coordinates_height'] < $params->get('img_size_min_height') ){
                $item['coordinates_height'] = $params->get('img_size_min_height');
            }

            // если стороны не одинаковые делаем их одинакововыми, орентир высота
            if( $item['coordinates_width'] != $item['coordinates_height'] ){
                $item['coordinates_width'] = $item['coordinates_height'];
            }

            // если не указаны кординаты обрезаем стороны один к одному
            if( $item['coordinates_width'] == 0 || $item['coordinates_height'] == 0 ){

                // выбераем в меньшую сторону если стороны не одинаковые
                if( $image->getWidth() != $image->getHeight() ){
                    if( $image->getWidth() < $image->getHeight() ){
                        $width_height = $image->getWidth();
                    }else{
                        $width_height = $image->getHeight();
                    }

                    $image->cropResize( $width_height, $width_height, false );
                    $image->toFile( $big_img );

                }

                $image->cropResize( $params->get('img_size_min_width'), $params->get('img_size_min_height'), false );
                $image->toFile( $min_img );

            }else{

                $image->crop( $item['coordinates_width'], $item['coordinates_height'], $item['coordinates_x1'], $item['coordinates_y1'], false );
                $image->toFile( $big_img );

                $image->cropResize( $params->get('img_size_min_width'), $params->get('img_size_min_height'), false );
                $image->toFile( $min_img );

            }

        }

    }

    public function validate($imgCoordinates){

        $user = JFactory::getUser();

        foreach($imgCoordinates as $item){

            if( ($this->getItem($item['id'])->user_id != $user->id) && $user->groups[0] == 8){
                return false;
            }

        }

        return true;

    }


    public function formating($data){

        $result = array();
        $imgArrRu = array();
        $imgArrEn = array();
        $imgArrHe = array();

        for($i=0;$i<=9;$i++){

            $img = $this->getItem($data->images_ru[$i]);
            if($img != null){

                if( isset($imgArrRu[$data->images_ru[$i]]) ){
                    if( empty($imgArrRu[$data->images_ru[$i]]['coordinates_width']) && empty($imgArrRu[$data->images_ru[$i]]['coordinates_height']) ){
                        $imgArrRu[$data->images_ru[$i]]['id'] = $data->images_ru[$i];
                        $imgArrRu[$data->images_ru[$i]]['coordinates_x1'] = $data->coordinates_ru_x1[$i];
                        $imgArrRu[$data->images_ru[$i]]['coordinates_x2'] = $data->coordinates_ru_x2[$i];
                        $imgArrRu[$data->images_ru[$i]]['coordinates_y1'] = $data->coordinates_ru_y1[$i];
                        $imgArrRu[$data->images_ru[$i]]['coordinates_y2'] = $data->coordinates_ru_y2[$i];
                        $imgArrRu[$data->images_ru[$i]]['coordinates_width'] = $data->coordinates_ru_width[$i];
                        $imgArrRu[$data->images_ru[$i]]['coordinates_height'] = $data->coordinates_ru_height[$i];
                    }
                }else{
                    $imgArrRu[$data->images_ru[$i]]['id'] = $data->images_ru[$i];
                    $imgArrRu[$data->images_ru[$i]]['coordinates_x1'] = $data->coordinates_ru_x1[$i];
                    $imgArrRu[$data->images_ru[$i]]['coordinates_x2'] = $data->coordinates_ru_x2[$i];
                    $imgArrRu[$data->images_ru[$i]]['coordinates_y1'] = $data->coordinates_ru_y1[$i];
                    $imgArrRu[$data->images_ru[$i]]['coordinates_y2'] = $data->coordinates_ru_y2[$i];
                    $imgArrRu[$data->images_ru[$i]]['coordinates_width'] = $data->coordinates_ru_width[$i];
                    $imgArrRu[$data->images_ru[$i]]['coordinates_height'] = $data->coordinates_ru_height[$i];
                }

            }

            $img = $this->getItem($data->images_en[$i]);
            if($img != null){

                if( isset($imgArrEn[$data->images_en[$i]]) ){
                    if( empty($imgArrEn[$data->images_en[$i]]['coordinates_width']) && empty($imgArrEn[$data->images_en[$i]]['coordinates_height']) ){
                        $imgArrEn[$data->images_en[$i]]['id'] = $data->images_en[$i];
                        $imgArrEn[$data->images_en[$i]]['coordinates_x1'] = $data->coordinates_en_x1[$i];
                        $imgArrEn[$data->images_en[$i]]['coordinates_x2'] = $data->coordinates_en_x2[$i];
                        $imgArrEn[$data->images_en[$i]]['coordinates_y1'] = $data->coordinates_en_y1[$i];
                        $imgArrEn[$data->images_en[$i]]['coordinates_y2'] = $data->coordinates_en_y2[$i];
                        $imgArrEn[$data->images_en[$i]]['coordinates_width'] = $data->coordinates_en_width[$i];
                        $imgArrEn[$data->images_en[$i]]['coordinates_height'] = $data->coordinates_en_height[$i];
                    }
                }else{
                    $imgArrEn[$data->images_en[$i]]['id'] = $data->images_en[$i];
                    $imgArrEn[$data->images_en[$i]]['coordinates_x1'] = $data->coordinates_en_x1[$i];
                    $imgArrEn[$data->images_en[$i]]['coordinates_x2'] = $data->coordinates_en_x2[$i];
                    $imgArrEn[$data->images_en[$i]]['coordinates_y1'] = $data->coordinates_en_y1[$i];
                    $imgArrEn[$data->images_en[$i]]['coordinates_y2'] = $data->coordinates_en_y2[$i];
                    $imgArrEn[$data->images_en[$i]]['coordinates_width'] = $data->coordinates_en_width[$i];
                    $imgArrEn[$data->images_en[$i]]['coordinates_height'] = $data->coordinates_en_height[$i];
                }

            }

            $img = $this->getItem($data->images_he[$i]);
            if($img != null){

                if( isset($imgArrHe[$data->images_he[$i]]) ){
                    if( empty($imgArrHe[$data->images_he[$i]]['coordinates_width']) && empty($imgArrHe[$data->images_he[$i]]['coordinates_height']) ){
                        $imgArrHe[$data->images_he[$i]]['id'] = $data->images_he[$i];
                        $imgArrHe[$data->images_he[$i]]['coordinates_x1'] = $data->coordinates_he_x1[$i];
                        $imgArrHe[$data->images_he[$i]]['coordinates_x2'] = $data->coordinates_he_x2[$i];
                        $imgArrHe[$data->images_he[$i]]['coordinates_y1'] = $data->coordinates_he_y1[$i];
                        $imgArrHe[$data->images_he[$i]]['coordinates_y2'] = $data->coordinates_he_y2[$i];
                        $imgArrHe[$data->images_he[$i]]['coordinates_width'] = $data->coordinates_he_width[$i];
                        $imgArrHe[$data->images_he[$i]]['coordinates_height'] = $data->coordinates_he_height[$i];
                    }
                }else{
                    $imgArrHe[$data->images_he[$i]]['id'] = $data->images_he[$i];
                    $imgArrHe[$data->images_he[$i]]['coordinates_x1'] = $data->coordinates_he_x1[$i];
                    $imgArrHe[$data->images_he[$i]]['coordinates_x2'] = $data->coordinates_he_x2[$i];
                    $imgArrHe[$data->images_he[$i]]['coordinates_y1'] = $data->coordinates_he_y1[$i];
                    $imgArrHe[$data->images_he[$i]]['coordinates_y2'] = $data->coordinates_he_y2[$i];
                    $imgArrHe[$data->images_he[$i]]['coordinates_width'] = $data->coordinates_he_width[$i];
                    $imgArrHe[$data->images_he[$i]]['coordinates_height'] = $data->coordinates_he_height[$i];
                }

            }

        }

        $imgArr = array_merge($imgArrRu,$imgArrEn,$imgArrHe);

        foreach($imgArr as $item){

            if( isset($result[$item['id']]) ){
                if( empty($result[$item['id']]['coordinates_width']) && empty($result[$item['id']]['coordinates_height']) ){
                    $result[$item['id']] = $item;
                }
            }else{
                $result[$item['id']] = $item;
            }

        }

        return $result;

    }

}
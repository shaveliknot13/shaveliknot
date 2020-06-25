<?php

// No direct access
defined( '_JEXEC' ) or die;

/**
 * @author Воропаев Валентин
 */

jimport('joomla.application.component.modellist');

class ShoppingoverviewModelYoutube extends JModelAdmin
{

    public function getForm( $data = array(), $loadData = true )
    {
        $form = $this->loadForm( 'com_shoppingoverview.youtube', 'items', array( 'control' => 'jform', 'load_data' => $loadData ) );
        if ( empty( $form ) ) {
            return false;
        }
        return $form;
    }

    public function video_exists ($id) {
        $headers = get_headers('https://www.youtube.com/oembed?format=json&url=http://www.youtube.com/watch?v='.$id);
        //$headers[0] = false; // нужно убрать так как на сайте ютуб работает а у меня нет((((
        if (substr($headers[0], 9, 3) == "200") {
            return true;
        } else {
            return false;
        }
    }

    public function getId ($url){

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

}
<?php

// No direct access
defined( '_JEXEC' ) or die;

/**
 * Component helper
 * @author Воропаев Валентин
 */
class ShoppingoverviewSiteHelper
{
	/**
	* @var array $menuIds  List Id depending of view component
	*/
	static $menuIds = array();
	
	/**
	* Create sef links
	* @param $option string
	* @param $view string
	* @param $query string
	* @return string link
	* @throws Exception
	*/
	static function getRoute( $option, $view, $query = '' )
	{
		if ( empty( self::$menuIds[$option . '.' . $view] ) ) {
			$items = JMenuSite::getInstance( 'site' )->getItems( 'component', $option );
			foreach ( $items as $item ) {
				if ( isset( $item->query['view'] ) && $item->query['view'] === $view ) {
					self::$menuIds[$option . '.' . $view] = $item->id;
				}
			}
		}
		return JRoute::_( 'index.php?view=' . $view . $query . '&Itemid=' . self::$menuIds[$option . '.' . $view] );
	}

	/**
	 * set meta tags
	 * @param string $title
	 * @param string $metaDesc
	 * @param string $metaKey
	 * @throws Exception
	 */
	static function setDocument( $title = '', $metaDesc = '', $metaKey = '', $og = null )
	{

        JText::script('COM_SHOPPINGOVERVIEW_SHOW_MORE');
        JText::script('COM_SHOPPINGOVERVIEW_CAN_NOT_TRANSLATE');
        JText::script('COM_SHOPPINGOVERVIEW_LOADING');
        JText::script('COM_SHOPPINGOVERVIEW_EDIT_FILD_18');
        JText::script('COM_SHOPPINGOVERVIEW_EDIT_FILD_22');
        JText::script('COM_SHOPPINGOVERVIEW_EDIT_FILD_24');
        JText::script('COM_SHOPPINGOVERVIEW_DO_NOT_UPLOAD_PHOTOS_MORE_10_MEGABYTES');
        JText::script('COM_SHOPPINGOVERVIEW_NO_MORE_THAN_35_CHARACTERS_AND_NEMESIS_1');
        JText::script('COM_SHOPPINGOVERVIEW_ALREADY_ADDED');
        JText::script('COM_SHOPPINGOVERVIEW_10_TAGS_MAXIMUM');
        JText::script('COM_SHOPPINGOVERVIEW_CAN_NOT_TRANSLATE_1');
        JText::script('COM_SHOPPINGOVERVIEW_CAN_NOT_TRANSLATE_2');
        JText::script('COM_SHOPPINGOVERVIEW_CAN_NOT_TRANSLATE_3');
        JText::script('COM_SHOPPINGOVERVIEW_CAN_NOT_TRANSLATE_4');
        JText::script('COM_SHOPPINGOVERVIEW_CAN_NOT_TRANSLATE_5');
        JText::script('COM_SHOPPINGOVERVIEW_CAN_NOT_TRANSLATE_6');

		$baseUrl = JUri::base();
		$doc = JFactory::getDocument();
        JHtml::_('jquery.framework');
		$doc
            ->addScript( $baseUrl . 'components/com_shoppingoverview/assets/js/jquery.imgareaselect.pack.js' )
            ->addScript( $baseUrl . 'components/com_shoppingoverview/assets/js/shoppingoverview.js' )
            ->addScript( $baseUrl . 'components/com_shoppingoverview/assets/js/jquery.fancybox.min.js' )
            ->addStyleSheet( $baseUrl . 'components/com_shoppingoverview/assets/css/imgareaselect-default.css' )
			->addStyleSheet( $baseUrl . 'components/com_shoppingoverview/assets/css/shoppingoverview.css' )
            ->addStyleSheet( $baseUrl . 'components/com_shoppingoverview/assets/css/jquery.fancybox.min.css' );

		$app = JFactory::getApplication();
		if ( empty( $title ) ) {
			$title = $app->get( 'sitename' );
		}
		elseif ( $app->get( 'sitename_pagetitles', 0 ) == 1 ) {
			$title = JText::sprintf( 'JPAGETITLE', $app->get( 'sitename' ), $title );
		}
		elseif ( $app->get( 'sitename_pagetitles', 0 ) == 2 ) {
			$title = JText::sprintf( 'JPAGETITLE', $title, $app->get( 'sitename' ) );
		}
		$doc->setTitle( $title );
		if ( trim( $metaDesc ) ) {
			$doc->setDescription( $metaDesc );
		}
		if ( trim( $metaKey ) ) {
			$doc->setMetaData( 'keywords', $metaKey );
		}

		if(!empty($og)){
		    if(!empty($og->locale)){
                $doc->setMetaData( 'og:locale', $og->locale, 'property' );
            }
            if(!empty($og->type)){
                $doc->setMetaData( 'og:type', $og->type, 'property' );
            }
            if(!empty($og->title)){
                $doc->setMetaData( 'og:title', $og->title, 'property' );
                $doc->setMetaData( 'twitter:title', $og->title, 'name' );
            }
            if(!empty($og->description)){
                $doc->setMetaData( 'og:description', $og->description, 'property' );
                $doc->setMetaData( 'twitter:description', $og->description, 'name' );
            }
            if(!empty($og->site_name)){
                $doc->setMetaData( 'og:site_name', $og->site_name, 'property' );
                $doc->setMetaData( 'twitter:site', '@'.$og->site_name, 'name' );
                $doc->setMetaData( 'twitter:creator', '@Auto'.$og->site_name, 'name' );
            }
            if(!empty($og->image)){
                $doc->setMetaData( 'og:image', $og->image, 'property' );
                $doc->setMetaData( 'twitter:image', $og->image, 'name' );
                $doc->setMetaData( 'twitter:card',  'summary_large_image', 'name' );
            }
            if(!empty($og->app_id)){
                $doc->setMetaData( 'fb:app_id', $og->app_id, 'property' );
            }
            if(!empty($og->url)){
                $doc->setMetaData( 'og:url', $og->url, 'property' );
            }
        }

	}

    static function getPerfixLang($lang='ru'){

        if($lang == "ru-ru"){
            $lang = "ru";
        }elseif($lang == "en-gb"){
            $lang = "en";
        }elseif($lang == "he-il"){
            $lang = "he";
        }

        return $lang;

    }





}
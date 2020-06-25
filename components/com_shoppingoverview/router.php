<?php
defined( '_JEXEC' ) or die; // No direct access

function ShoppingoverviewBuildRoute( &$query )
{
	$segments = array();

    if ( isset($query['controller']) && in_array($query['controller'], array('tags','users','notifications','search','asks','langs')) ) {

        $segments[] = $query['controller'];
        unset( $query['controller'] );

        if ( isset( $query['task'] ) ) {
            $segments[] = $query['task'];
            unset( $query['task'] );
        }

        if ( isset( $query['id'] ) ) {
            $segments[] = $query['id'];
            unset( $query['id'] );
        }

    }else{

        if ( isset( $query['cat_alias'] ) ) {
            $segments[] = $query['cat_alias'];
            unset( $query['cat_alias'] );
        }

        if ( isset( $query['item_alias'] ) ) {
            $segments[] = $query['item_alias'];
            unset( $query['item_alias'] );
        }

    }

	return $segments;
}

function ShoppingoverviewParseRoute( $segments )
{
	$vars = array();

    // добавляем список контролеров которые нужно обрабатывать
    if( in_array($segments[0], array('tags','users','notifications','search','asks','langs')) ){

            $vars['controller'] = $segments[0];
            $vars['task'] = $segments[1];
            $vars['id'] = $segments[2];

    }else{

        if( isset($segments[0]) && $segments[1] ){
            $vars['cat_alias'] = $segments[0];
            $vars['item_alias'] = $segments[1];
            $vars['task'] = 'show';
        }elseif( isset($segments[0]) ){
            $vars['cat_alias'] = $segments[0];
            $vars['task'] = 'categories';
        }

    }

	return $vars;
}
<?php
defined( '_JEXEC' ) or die; // No direct access
/**
 * Component shoppingoverview
 * @author Воропаев Валентин
 */
/*
require_once JPATH_COMPONENT.'/helpers/shoppingoverview.php';
$controller = JControllerLegacy::getInstance( 'shoppingoverview' );
$controller->execute( JFactory::getApplication()->input->get( 'task','display' ) );
$controller->redirect();
*/

if (PHP_MAJOR_VERSION >= 7) {
    set_error_handler(function ($errno, $errstr) {
        return strpos($errstr, 'Declaration of') === 0;
    }, E_WARNING);
}

JLoader::register('GoogleTranslate', JPATH_ADMINISTRATOR . '/components/com_shoppingoverview/class/GoogleTranslate.php');
JLoader::register('ShoppingoverviewSiteHelper', JPATH_SITE . '/components/com_shoppingoverview/helpers/shoppingoverview.php');
JLoader::register('DopFunction', JPATH_SITE . '/components/com_shoppingoverview/helpers/secondaryfunctions.php');

$app = JFactory::getApplication();

$controller = $app->input->get('controller','items');

$classname  = 'ShoppingoverviewController'.ucwords($controller);

$filename = __DIR__.'/controllers/'.$controller.'.php';

if (file_exists($filename)) {
    require $filename;
} else {
    require __DIR__.'/controllers/items.php';
}

$controller = new $classname();

$controller->execute($app->input->get('task','display'));

$controller->redirect();
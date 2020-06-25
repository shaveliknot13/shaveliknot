<?php
defined( '_JEXEC' ) or die; // No direct access
/**
 * Component shoppingoverview
 * @author Воропаев Валентин
 */

JLoader::register('GoogleTranslate', JPATH_ADMINISTRATOR . '/components/com_shoppingoverview/class/GoogleTranslate.php');
JLoader::register('ShoppingoverviewHelper', JPATH_ADMINISTRATOR . '/components/com_shoppingoverview/helpers/shoppingoverview.php');
JLoader::register('DopFunction', JPATH_ADMINISTRATOR . '/components/com_shoppingoverview/helpers/secondaryfunctions.php');

$app = JFactory::getApplication();

$controller = $app->input->get('controller','categories');

$classname  = 'ShoppingoverviewControllers'.ucwords($controller);

$filename = __DIR__.'/controllers/'.$controller.'.php';

if (file_exists($filename)) {
    require $filename;
} else {
    require __DIR__.'/controllers/categories.php';
}

$controller = new $classname();

$controller->execute($app->input->get('task','display'));
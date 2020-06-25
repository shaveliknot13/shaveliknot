<?php

defined('_JEXEC') or die;
$app = JFactory::getApplication();
$controller = $app->input->get('controller', null, 'string');
$task = $app->input->get('task', null, 'string');

if($controller != "asks") {

    $render = function () use ($params) {

        if (!$app = @include(JPATH_ADMINISTRATOR . '/components/com_widgetkit/widgetkit-app.php')) {
            return;
        }

        $output = $app->renderWidget(json_decode($params->get('widgetkit', '[]'), true));
        echo $output === false ? $app['translator']->trans('Could not load widget') : $output;
    };

    return $render();
}
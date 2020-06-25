<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.shoppingoverview
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/** @var JDocumentError $this */

$app  = JFactory::getApplication();
$user = JFactory::getUser();

// Getting params from template
$params = $app->getTemplate(true)->params;

// Detecting Active Variables
$option   = $app->input->getCmd('option', '');
$view     = $app->input->getCmd('view', '');
$layout   = $app->input->getCmd('layout', '');
$task     = $app->input->getCmd('task', '');
$itemid   = $app->input->getCmd('Itemid', '');
$sitename = $app->get('sitename');

if ($task === 'edit' || $layout === 'form')
{
	$fullWidth = 1;
}
else
{
	$fullWidth = 0;
}

// Add JavaScript Frameworks
JHtml::_('bootstrap.framework');

// Logo file or site title param
if ($params->get('logoFile'))
{
	$logo = '<img src="' . JUri::root() . $params->get('logoFile') . '" alt="' . $sitename . '" />';
}
elseif ($params->get('sitetitle'))
{
	$logo = '<span class="site-title" title="' . $sitename . '">' . htmlspecialchars($params->get('sitetitle')) . '</span>';
}
else
{
	$logo = '<span class="site-title" title="' . $sitename . '">' . $sitename . '</span>';
}
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<meta charset="utf-8" />
	<title><?php echo $this->title; ?> <?php echo htmlspecialchars($this->error->getMessage(), ENT_QUOTES, 'UTF-8'); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php // Use of Google Font ?>
	<?php if ($params->get('googleFont')) : ?>
		<link href="https://fonts.googleapis.com/css?family=<?php echo $params->get('googleFontName'); ?>" rel="stylesheet" />
		<style>
			h1, h2, h3, h4, h5, h6, .site-title {
				font-family: '<?php echo str_replace('+', ' ', $params->get('googleFontName')); ?>', sans-serif;
			}
		</style>
	<?php endif; ?>
	<link href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/template.css" rel="stylesheet" />
    <link href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/error.css" rel="stylesheet" />
	<?php // If Right-to-Left ?>
	<?php if ($this->direction === 'rtl') : ?>
		<link href="<?php echo JUri::root(true); ?>/media/jui/css/bootstrap-rtl.css" rel="stylesheet" />
	<?php endif; ?>
	<link href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />
	<?php // Template color ?>
	<?php if ($params->get('templateColor')) : ?>
		<style>
			body.site {
				border-top: 3px solid <?php echo $params->get('templateColor'); ?>;
				background-color: <?php echo $params->get('templateBackgroundColor'); ?>
			}
			a {
				color: <?php echo $params->get('templateColor'); ?>;
			}
			.navbar-inner, .nav-list > .active > a, .nav-list > .active > a:hover, .dropdown-menu li > a:hover, .dropdown-menu .active > a, .dropdown-menu .active > a:hover, .nav-pills > .active > a, .nav-pills > .active > a:hover {
				background: <?php echo $params->get('templateColor'); ?>;
			}
			.navbar-inner {
				-moz-box-shadow: 0 1px 3px rgba(0, 0, 0, .25), inset 0 -1px 0 rgba(0, 0, 0, .1), inset 0 30px 10px rgba(0, 0, 0, .2);
				-webkit-box-shadow: 0 1px 3px rgba(0, 0, 0, .25), inset 0 -1px 0 rgba(0, 0, 0, .1), inset 0 30px 10px rgba(0, 0, 0, .2);
				box-shadow: 0 1px 3px rgba(0, 0, 0, .25), inset 0 -1px 0 rgba(0, 0, 0, .1), inset 0 30px 10px rgba(0, 0, 0, .2);
			}
		</style>
	<?php endif; ?>
	<!--[if lt IE 9]><script src="<?php echo JUri::root(true); ?>/media/jui/js/html5.js"></script><![endif]-->
</head>
<body>
    <section id="wrapper" class="container-fluid">
        <div class="error-box">
            <div class="error-body text-center">
                <h1 class="text-danger"><?php echo $this->error->getCode(); ?></h1>
                <h3><?php echo htmlspecialchars($this->error->getMessage(), ENT_QUOTES, 'UTF-8');?></h3>
                <a href="/" class="button-block-success-xs">Back to home</a> </div>
        </div>
    </section>
</body>
</html>

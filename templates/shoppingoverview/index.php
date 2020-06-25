<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.protostar
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/** @var JDocumentHtml $this */

$app  = JFactory::getApplication();
$user = JFactory::getUser();

unset(
    //$this->_scripts[$this->baseurl.'/media/system/js/core.js'],
    $this->_scripts[$this->baseurl.'/media/system/js/caption.js'],
    $this->_scripts[$this->baseurl.'/media/system/js/mootools-core.js'],
    $this->_scripts[$this->baseurl.'/media/system/js/mootools-more.js']
);

$config  = new JConfig();
$robots   = $config->robots;

$this->setGenerator(null);
$this->setMetaData('robots',$robots);
// Output as HTML5
$this->setHtml5(true);

// Getting params from template
$params = $app->getTemplate(true)->params;

// Detecting Active Variables
$option   = $app->input->getCmd('option', '');
$view     = $app->input->getCmd('view', '');
$layout   = $app->input->getCmd('layout', '');
$task     = $app->input->getCmd('task', '');
$itemid   = $app->input->getCmd('Itemid', '');

$sitename = $app->get('sitename');
JText::script('COM_SHOPPINGOVERVIEW_LOG_IN_TO_THE_SITE');
JText::script('COM_SHOPPINGOVERVIEW_LOG_IN_TO_THE_SITE_1');
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

// Add template js
//JHtml::_('script', 'jquery.touchwipe.js', array('version' => 'auto', 'relative' => true));

JHtml::_('script', 'template.js', array('version' => 'auto', 'relative' => true));

JHtml::_('script', 'template-base.js', array('version' => 'auto', 'relative' => true));

JHtml::_('script', 'bootstrap-tab.js', array('version' => 'auto', 'relative' => true));

// Add html5 shiv
JHtml::_('script', 'jui/html5.js', array('version' => 'auto', 'relative' => true, 'conditional' => 'lt IE 9'));

// Add Stylesheets
JHtml::_('stylesheet', 'template.css', array('version' => 'auto', 'relative' => true));

// Use of Google Font
if ($this->params->get('googleFont'))
{
	JHtml::_('stylesheet', '//fonts.googleapis.com/css?family=' . $this->params->get('googleFontName'));
	$this->addStyleDeclaration("
	h1, h2, h3, h4, h5, h6, .site-title {
		font-family: '" . str_replace('+', ' ', $this->params->get('googleFontName')) . "', sans-serif;
	}");
}

// Template color
if ($this->params->get('templateColor'))
{
	$this->addStyleDeclaration('
	body.site {
		border-top: 3px solid ' . $this->params->get('templateColor') . ';
		background-color: ' . $this->params->get('templateBackgroundColor') . ';
	}
	a {
		color: ' . $this->params->get('templateColor') . ';
	}
	.nav-list > .active > a,
	.nav-list > .active > a:hover,
	.dropdown-menu li > a:hover,
	.dropdown-menu .active > a,
	.dropdown-menu .active > a:hover,
	.nav-pills > .active > a,
	.nav-pills > .active > a:hover,
	.btn-primary {
		background: ' . $this->params->get('templateColor') . ';
	}');
}

// Check for a custom CSS file
JHtml::_('stylesheet', 'user.css', array('version' => 'auto', 'relative' => true));

// Check for a custom js file
JHtml::_('script', 'user.js', array('version' => 'auto', 'relative' => true));

// Load optional RTL Bootstrap CSS
JHtml::_('bootstrap.loadCss', false, $this->direction);

// Adjusting content width
$position7ModuleCount = $this->countModules('position-7');
$position7ModuleBuffer = $this->getBuffer('modules','position-7');

$position8ModuleCount = $this->countModules('position-8');
$position8ModuleBuffer = $this->getBuffer('modules','position-8');

if (($position7ModuleCount && $position7ModuleBuffer != '') && ($position8ModuleCount && $position8ModuleBuffer != ''))
{
	$span = 'span6';
}
elseif ($position7ModuleCount && $position7ModuleBuffer != '')
{
	$span = 'span9';
}
elseif ($position8ModuleCount && $position8ModuleBuffer != '')
{
	$span = 'span9';
}
else
{
	$span = 'span12';
}

// Logo file or site title param
if ($this->params->get('logoFile'))
{
	$logo = '<img src="' . JUri::root() . $this->params->get('logoFile') . '" alt="' . $sitename . '" />';
}
elseif ($this->params->get('sitetitle'))
{
	$logo = '<span class="site-title" title="' . $sitename . '">' . htmlspecialchars($this->params->get('sitetitle'), ENT_COMPAT, 'UTF-8') . '</span>';
}
else
{
	$logo = '<span class="site-title" title="' . $sitename . '">' . $sitename . '</span>';
}

$session = JFactory::getSession();
$listingImgMini = $session->get('listingImgMini', false);
$termsAgreement = $session->get('termsAgreement', false);

if($termsAgreement == true){
    $this->addScriptDeclaration("termsAgreement = true;");
}else{
    $this->addScriptDeclaration("termsAgreement = false;");
}

if($listingImgMini == true){
    $this->addScriptDeclaration("listArrowItem = true;");
    $this->addStyleDeclaration('
	.shoppingoverview-page-item-imgs .arrow-left-nav,
	.shoppingoverview-page-item-imgs .arrow-right-nav
	{
		opacity: 0;
	}

	.shoppingoverview-page-item-imgs .arrow-left-nav:hover,
	.shoppingoverview-page-item-imgs .arrow-right-nav:hover
	{
		opacity: 0.4;
	}
	');
    //$session->set('listingImgMini', false);
}else{
    $this->addScriptDeclaration("listArrowItem = false;");
}

?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<jdoc:include type="head" />
    <link rel="stylesheet" href="/templates/shoppingoverview/css/all.css">

    <link rel="apple-touch-icon" sizes="180x180" href="/templates/shoppingoverview/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/templates/shoppingoverview/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/templates/shoppingoverview/favicon/android-chrome-192x192.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/templates/shoppingoverview/favicon/favicon-16x16.png">
    <link rel="manifest" href="/templates/shoppingoverview/favicon/site.webmanifest">
    <link rel="mask-icon" href="/templates/shoppingoverview/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="/templates/shoppingoverview/favicon/favicon.ico">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-TileImage" content="/templates/shoppingoverview/favicon/mstile-144x144.png">
    <meta name="msapplication-config" content="/templates/shoppingoverview/favicon/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">

    <?php
    if($this->language == 'he-il'):
    ?>
    <link rel="stylesheet" href="/templates/shoppingoverview/css/template_he.css">
    <?php
    endif;
    ?>

    <script>
        jQuery(document).ready(function(){
            jQuery('.item-page-show-linephoto').owlCarousel({
                <?php
                if($this->language == 'he-il'):
                ?>
                rtl:true,
                <?php
                endif;
                ?>
                loop: false,
                margin: 15,
                nav: true,
                dots:false,
                autoWidth:false,
                items:5,
                navText: [
                    '<i class="fal fa-chevron-left"></i>',
                    '<i class="fal fa-chevron-right"></i>'
                ],
                responsive : {
                    0 : {
                        items:3,
                        autoWidth:false,
                    },
                    500 : {
                        items:4,
                        autoWidth:false,
                    },
                    600 : {
                        loop: false,
                        margin: 15,
                        nav: true,
                        dots:false,
                        autoWidth:false,
                        items:5,
                        navText: [
                            '<i class="fal fa-chevron-left"></i>',
                            '<i class="fal fa-chevron-right"></i>'
                        ],
                    },
                    980 : {
                        items:4,
                        autoWidth:false,
                    },
                    1200 : {
                        loop: false,
                        margin: 15,
                        nav: true,
                        dots:false,
                        autoWidth:false,
                        items:5,
                        navText: [
                            '<i class="fal fa-chevron-left"></i>',
                            '<i class="fal fa-chevron-right"></i>'
                        ],
                    }
                }
            });



            jQuery('.mod_shoppingoverview_categories').owlCarousel({
                <?php
                if($this->language == 'he-il'):
                ?>
                rtl:true,
                <?php
                endif;
                ?>
                loop: false,
                margin: 20,
                nav: true,
                dots:false,
                autoWidth:true,
                items:1,
                navText: [
                    '<i class="fal fa-chevron-left"></i>',
                    '<i class="fal fa-chevron-right"></i>'
                ],
                responsive : {
                    0 : {
                        dots:true,
                        items:4,
                        autoWidth:false,
                    },
                    500 : {
                        dots:true,
                        items:5,
                        autoWidth:false,
                    },
                    600 : {
                        loop: false,
                        margin: 20,
                        nav: true,
                        dots:false,
                        autoWidth:true,
                        items:1,
                        navText: [
                            '<i class="fal fa-chevron-left"></i>',
                            '<i class="fal fa-chevron-right"></i>'
                        ],
                    }
                }
            });

        });
    </script>

    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({
            google_ad_client: "ca-pub-7601531065622510",
            enable_page_level_ads: true
        });
    </script>
</head>
<body class="site <?php echo $option
	. ' view-' . $view
	. ($layout ? ' layout-' . $layout : ' no-layout')
	. ($task ? ' task-' . $task : ' no-task')
	. ($itemid ? ' itemid-' . $itemid : '')
	. ($params->get('fluidContainer') ? ' fluid' : '');
	echo ($this->direction === 'rtl' ? ' rtl' : '');
?>">
	<!-- Body -->
	<div class="body" id="top">
        <div class="top-border">
            <div class="container" style="padding: 13px 0px;">
                <div class="top-border-logo"><jdoc:include type="modules" name="top-border-logo" style="none" /></div>
                <div class="top-border-search"><jdoc:include type="modules" name="top-border-search" style="none" /></div>
                <div class="top-border-addpost"><a href="<?php echo JRoute::_( 'index.php?option=com_shoppingoverview&controller=asks&task=edit&Itemid=101'); ?>" class="top-border-addpost-input"><?php echo JText::_('COM_SHOPPINGOVERVIEW_TEXT_54'); ?></a></div>
                <div class="top-border-login"><jdoc:include type="modules" name="top-border-login" style="none" /></div>
                <div class="top-border-lang"><jdoc:include type="modules" name="top-border-lang" style="none" /></div>
                <div class="top-border-icon-mobile">
                    <a href="<?php echo JRoute::_( 'index.php?option=com_shoppingoverview&controller=search&task=search&Itemid=101'); ?>"><i class="far fa-search"></i></a>
                    <a href="/users/login"><i class="fal fa-user"></i></a>
                    <a href="<?php echo JRoute::_( 'index.php?option=com_shoppingoverview&controller=langs&task=display&Itemid=101'); ?>"><i class="fal fa-globe"></i></a>
                </div>
            </div>
        </div>
        <div class="top-header" role="banner">
            <div class="container">
                <jdoc:include type="modules" name="position-0" style="none" />
            </div>
        </div>
		<div class="container<?php echo ($params->get('fluidContainer') ? '-fluid' : ''); ?>">
			<?php if ($this->countModules('position-1')) : ?>
                <jdoc:include type="modules" name="position-1" style="none" />
			<?php endif; ?>
			<jdoc:include type="modules" name="banner" style="xhtml" />

            <?php
                $hideModule = '';
                if($option == 'com_shoppingoverview' && ($task == 'show' || $task == 'edit' )){
                    $hideModule = 'hideModule';
                }
            ?>

			<div class="row-fluid <?=$hideModule?>">
				<?php if ($position8ModuleCount && $position8ModuleBuffer != '') : ?>
					<!-- Begin Sidebar -->
					<div id="sidebar" class="span3">
						<div class="sidebar-nav">

                            <div class="close-mobile-sidebar"><?php echo JText::_('COM_SHOPPINGOVERVIEW_TEXT_73'); ?> <i class="fas fa-times"></i></div>

							<jdoc:include type="modules" name="position-8" style="xhtml" />
						</div>
					</div>
					<!-- End Sidebar -->
				<?php endif; ?>

				<main id="content" role="main" class="<?php echo $span; ?>">
					<!-- Begin Content -->
					<jdoc:include type="modules" name="position-3" style="xhtml" />
					<jdoc:include type="message" />
                    <?php
                    if ($this->countModules('mod_shoppingoverview_publications') && $this->getBuffer('modules','mod_shoppingoverview_publications') != '') :
                    ?>
                        <jdoc:include type="modules" name="mod_shoppingoverview_publications" style="xhtml" />
                    <?php
                    endif;
                    ?>
					<jdoc:include type="component" />
					<div class="clearfix"></div>
					<jdoc:include type="modules" name="position-2" style="none" />
					<!-- End Content -->
				</main>
				<?php if ($position7ModuleCount && $position7ModuleBuffer != '') : ?>
					<div id="aside" class="span3">
						<!-- Begin Right Sidebar -->
                        <div class="close-mobile-sidebar"><?php echo JText::_('COM_SHOPPINGOVERVIEW_TEXT_73'); ?> <i class="fas fa-times"></i></div>
						<jdoc:include type="modules" name="position-7" style="well" />
						<!-- End Right Sidebar -->
					</div>
				<?php endif; ?>

			</div>
		</div>
	</div>
	<!-- Footer -->
	<footer class="footer" role="contentinfo">
        <div class="go-top"></div>
		<div class="container<?php echo ($params->get('fluidContainer') ? '-fluid' : ''); ?>">
            <div class="row-fluid">
                <div class="span6 footer-mod-1">
                    <a href="/">ShaveLiknot.co.il</a> &copy; Copyright 2018-<?php echo date('Y'); ?> Konstantin Pasternak.
                </div>
                <div class="span6 footer-mod-2">
                    <jdoc:include type="modules" name="footer" style="none" />
                </div>
                <div class="span12 footer-mod-3">
                    <?php

                    if($this->language == 'en-gb'):
                    ?>
                    All rights reserved. Logo is a trademark.
                    ShaveLiknot® is a registered trademark.
                    *Disclaimer: Disclaimer and fulfillment of obligations - YOU AGREE THAT YOU USE THE SITE OR PARTICIPATE IN ANY PROGRAM AT YOUR OWN RISK. <a href="/terms-of-use"> Learn more </a>
                    <?php
                    endif;
                    ?>

                    <?php
                    if($this->language == 'ru-ru'):
                    ?>
                    Все права защищены. Логотип является товарным знаком.
                    ShaveLiknot® является зарегистрированным товарным знаком.
                    *Дисклеймер: Отказ от ответственности и исполнения обязательств - ВЫ СОГЛАШАЕТЕСЬ, ЧТО ИСПОЛЬЗУЕТЕ САЙТ ИЛИ УЧАСТВУЕТЕ В ЛЮБОЙ ПРОГРАММЕ НА СВОЙ СТРАХ И РИСК. <a href="/usloviya-ispolzovaniya">Подробнее</a>
                    <?php
                    endif;
                    ?>

                    <?php
                    if($this->language == 'he-il'):
                    ?>
כל הזכויות שמורות. לוגו הוא סימן מסחרי.
ShaveLiknot® הוא סימן מסחרי רשום.
* כתב ויתור: כתב ויתור והשלמה של התחייבויות - הנך מאשר שאתה משתמש באתר או משתתף בתוכנית כלשהי בסיכון שלך. <a href="/terms-of-use-he"> למידע נוסף </a>
                    <?php
                    endif;
                    ?>

                </div>
            </div>
		</div>
	</footer>
	<jdoc:include type="modules" name="debug" style="none" />


    <div class="modal jviewport-width30 fade" style="display: none" id="login-text">
        <div class="modal-header">
            <a class="close" data-dismiss="modal">×</a>
            <h3><?php echo JText::_('TPL_PROTOSTAR_AMX1'); ?></h3>
        </div>
        <div class="modal-body" style="padding: 10px 20px;">
            <iframe style="width: 95%" src="<?php echo JText::_('TPL_PROTOSTAR_LINK'); ?>"></iframe>
        </div>
        <div class="modal-footer">
            <label class="checkbox" style="float: left;padding-top: 5px;">
                <input  class="amx3_1" style="margin-top: 3px;" type="checkbox"> <?php echo JText::_('TPL_PROTOSTAR_AMX3_1'); ?>
            </label>
            <div style="clear: both"></div>
            <label class="checkbox" style="float: left;padding-top: 5px;">
                <input class="amx3" style="margin-top: 3px;" type="checkbox"> <?php echo JText::_('TPL_PROTOSTAR_AMX3'); ?>
            </label>
            <a data-dismiss="modal" class="btn"><?php echo JText::_('TPL_PROTOSTAR_AMX2'); ?></a>
            <a data-dismiss="modal" class="btn btn-primary termsAgreement"><?php echo JText::_('TPL_PROTOSTAR_AMX6'); ?></a>
        </div>
    </div>

    <div class="click_left_bar">
        <i class="fal fa-filter"></i> <?php echo JText::_('COM_SHOPPINGOVERVIEW_TEXT_71'); ?>
    </div>
    <div class="click_right_bar">
        <i class="far fa-align-justify"></i> <?php echo JText::_('COM_SHOPPINGOVERVIEW_TEXT_72'); ?>
    </div>


</body>
</html>

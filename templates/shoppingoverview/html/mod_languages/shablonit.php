<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_languages
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('stylesheet', 'mod_languages/template.css', array('version' => 'auto', 'relative' => true));

if ($params->get('dropdown', 1) && !$params->get('dropdownimage', 0))
{
	JHtml::_('formbehavior.chosen');
}

// Это для плагина который формирует ссылки при переключение
JPluginHelper::importPlugin('shoppingoverview');
$dispatcher	= JDispatcher::getInstance();
$list = $dispatcher->trigger('onShoppingoverviewLang',array($list));
$list = $list[0];

?>

	<div class="btn-group">
		<?php foreach ($list as $language) : ?>
            <?php
                $language->title_native = str_replace('Russian (Russia)','RU',$language->title_native);
                $language->title_native = str_replace('Hebrew','HE',$language->title_native);
                $language->title_native = str_replace('English (United Kingdom)','EN',$language->title_native);
            ?>
			<?php if ($language->active) : ?>
				<a href="#" data-toggle="dropdown" class="btn dropdown-toggle">
					<?php echo $language->title_native; ?>
                    <span class="caret"></span>
				</a>
			<?php endif; ?>
		<?php endforeach; ?>
		<ul class="<?php echo $params->get('lineheight', 1) ? 'lang-block' : 'lang-inline'; ?> dropdown-menu" dir="<?php echo JFactory::getLanguage()->isRtl() ? 'rtl' : 'ltr'; ?>">
		<?php foreach ($list as $language) : ?>
			<?php if (!$language->active || $params->get('show_active', 0)) : ?>
				<li<?php echo $language->active ? ' class="lang-active"' : ''; ?>>
				<a href="<?php echo $language->link; ?>">
					<?php if ($language->image) : ?>
						<?php echo JHtml::_('image', 'mod_languages/' . $language->image . '.gif', '', null, true); ?>
					<?php endif; ?>
					<?php echo $language->title_native; ?>
				</a>
				</li>
			<?php endif; ?>
		<?php endforeach; ?>
		</ul>
	</div>


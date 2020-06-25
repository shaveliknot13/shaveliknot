<?php
/**
 * Social Login
 *
 * @version 	1.7
 * @author		SmokerMan, Arkadiy, Joomline
 * @copyright	© 2012. All rights reserved.
 * @license 	GNU/GPL v.3 or later.
 */

// No direct access.
defined('_JEXEC') or die('(@)|(@)');

JLoader::register('ShoppingoverviewSiteHelper', JPATH_SITE . '/components/com_shoppingoverview/helpers/shoppingoverview.php');
JLoader::register('DopFunction', JPATH_SITE . '/components/com_shoppingoverview/helpers/secondaryfunctions.php');

$doc = & JFactory::getDocument();
$langYaz = JFactory::getLanguage();
$lang =  shoppingoverviewSiteHelper::getPerfixLang($doc->getlanguage());
$langYaz->load('com_shoppingoverview');


?>
<noindex>
<div class="jlslogin">
<?php if ($type == 'logout') : ?>

<div class="logout-cabinet"><?php echo JText::_('COM_SHOPPINGOVERVIEW_TEXT_61')?></div>
<div class="logout-cabinet-base">
    <form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post" id="login-form" style="margin-top: 0px;padding-top: 0px">
        <div class="login-greeting">
            <div class="shoppingoverview-page-item-avatar row-fluid">
                <?php
                $customFields = FieldsHelper::getFields('com_users.user', ['id'=> $user->id]);
                ?>
                <div class="span3 shoppingoverview-page-item-avatar-mod-1" style="width: 50px!important;">
                    <img src="<?=$customFields[0]->value?>"/>
                </div>
                <div class="shoppingoverview-page-item-avatar-mod-2" style="width: 118px!important;padding-left:5px;">
                    <div style="height: 50px!important;line-height: 50px!important;">
                        <a href="<?=JRoute::_( 'index.php?option=com_shoppingoverview&controller=users&task=profile&Itemid=101&id='.$user->id );?>"><?=JFactory::getUser($user->id)->username?></a>
                    </div>
                </div>
            </div>

        </div>
            <ul class="ul-jlslogin">
                <li><a href="<?php echo JRoute::_('index.php?option=com_shoppingoverview&task=edit'); ?>"><?php echo JText::_('COM_SHOPPINGOVERVIEW_ADD_REVIEW'); ?></a></li>
                <li><a href="<?php echo JRoute::_('index.php?option=com_shoppingoverview&controller=users&task=useritems'); ?>"><?php echo JText::_('COM_SHOPPINGOVERVIEW_MY_REVIEWS'); ?></a></li>
                <li><a href="<?php echo JRoute::_('index.php?option=com_shoppingoverview&controller=users&task=userfavorites'); ?>"><?php echo JText::_('COM_SHOPPINGOVERVIEW_MY_FAVORITES'); ?></a></li>
                <li><a href="<?php echo JRoute::_('index.php?option=com_shoppingoverview&controller=users&task=usersubscribes'); ?>"><?php echo JText::_('COM_SHOPPINGOVERVIEW_MY_SUBSCRIPTIONS'); ?></a></li>
                <li><a href="<?php echo JRoute::_('index.php?option=com_shoppingoverview&controller=users&task=userhits'); ?>"><?php echo JText::_('COM_SHOPPINGOVERVIEW_WATCH_HISTORY'); ?></a></li>
                <li><a href="<?php echo JRoute::_('index.php?option=com_shoppingoverview&controller=notifications'); ?>"><?php echo JText::_('COM_SHOPPINGOVERVIEW_TEXT_47'); ?></a></li>
                <?php	if ($params->get('slogin_link_auch_edit', 1) == 1) {?>
                    <li><a href="<?php echo JRoute::_('index.php?option=com_users&view=profile&layout=edit'); ?>"><?php echo JText::_('COM_SHOPPINGOVERVIEW_TEXT_58'); ?></a></li>
                <?php }	?>


            </ul>
        <div class="logout-button">
            <input type="submit" name="Submit" class="button" value="<?php echo JText::_('JLOGOUT'); ?>" />
            <input type="hidden" name="option" value="com_users" />
            <input type="hidden" name="task" value="user.logout" />
            <input type="hidden" name="return" value="<?php echo $return; ?>" />
            <?php echo JHtml::_('form.token'); ?>
        </div>
    </form>
</div>
<?php else : ?>

    <div id="slogin-buttons" class="slogin-buttons slogin-compact">
        <a href="<?php echo JRoute::_('index.php?option=com_shoppingoverview&controller=users&task=login'); ?>"><?php echo JText::_('COM_SHOPPINGOVERVIEW_TEXT_60'); ?></a>
    </div>

<?php endif; ?>
</div>
</noindex>
<?php

defined( '_JEXEC' ) or die; // No direct access
$user = JFactory::getUser();
$session = JFactory::getSession();
$listingImgMini = $session->get('listingImgMini', false);
$termsAgreement = $session->get('termsAgreement', false);
$userToken = JSession::getFormToken();
?>



<div class="shoppingoverview-users-login" <?php if($termsAgreement == false && $user->guest ): ?> data-toggle="modal" href="#login-text"<?php endif; ?>>
    <?php if($user->guest ): ?>
    <h1><?php echo JText::_('COM_SHOPPINGOVERVIEW_TEXT_55'); ?></h1>
    <a class="facebook" href="/component/slogin/provider/facebook/auth"><i class="fab fa-facebook-f"></i> <?php echo JText::_('COM_SHOPPINGOVERVIEW_TEXT_56'); ?></a>
    <a class="google" href="/component/slogin/provider/google/auth"><i class="fab fa-google"></i> <?php echo JText::_('COM_SHOPPINGOVERVIEW_TEXT_57'); ?></a>
    <?php else: ?>
        <div class="shoppingoverview-users-login-cabinet">
        <?php
        $customFields = FieldsHelper::getFields('com_users.user', ['id'=> $user->id]);
        ?>
            <img src="<?=$customFields[0]->value?>"/>
            <div class="shoppingoverview-users-login-cabinet-name"><?=$user->username?></div>
            <ul>
                <li><a href="<?php echo JRoute::_('index.php?option=com_shoppingoverview&task=edit'); ?>"><?php echo JText::_('COM_SHOPPINGOVERVIEW_ADD_REVIEW'); ?></a></li>
                <li><a href="<?php echo JRoute::_('index.php?option=com_shoppingoverview&controller=users&task=useritems'); ?>"><?php echo JText::_('COM_SHOPPINGOVERVIEW_MY_REVIEWS'); ?></a></li>
                <li><a href="<?php echo JRoute::_('index.php?option=com_shoppingoverview&controller=users&task=userfavorites'); ?>"><?php echo JText::_('COM_SHOPPINGOVERVIEW_MY_FAVORITES'); ?></a></li>
                <li><a href="<?php echo JRoute::_('index.php?option=com_shoppingoverview&controller=users&task=usersubscribes'); ?>"><?php echo JText::_('COM_SHOPPINGOVERVIEW_MY_SUBSCRIPTIONS'); ?></a></li>
                <li><a href="<?php echo JRoute::_('index.php?option=com_shoppingoverview&controller=users&task=userhits'); ?>"><?php echo JText::_('COM_SHOPPINGOVERVIEW_WATCH_HISTORY'); ?></a></li>
                <li><a href="<?php echo JRoute::_('index.php?option=com_shoppingoverview&controller=notifications'); ?>"><?php echo JText::_('COM_SHOPPINGOVERVIEW_TEXT_47'); ?></a></li>
                <li><a href="<?php echo JRoute::_('index.php?option=com_users&view=profile&layout=edit'); ?>"><?php echo JText::_('COM_SHOPPINGOVERVIEW_TEXT_58'); ?></a></li>
                <li><a href="/index.php?option=com_users&task=user.logout&<?=$userToken?>=1"><?php echo JText::_('COM_SHOPPINGOVERVIEW_TEXT_59'); ?></a></li>
            </ul>


        </div>
    <?php endif; ?>

</div>
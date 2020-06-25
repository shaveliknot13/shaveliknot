<?php

defined('_JEXEC') or die;

JHtml::_('behavior.formvalidator');
JHtml::_('behavior.keepalive');

?>

<?php foreach($rows as $item): ?>
    <tr>
        <td><input id="cb<?=$item->id?>" name="cid[]" value="<?=$item->id?>" onclick="Joomla.isChecked(this.checked);" type="checkbox"></td>
        <td><a target="_blank" href="index.php?option=com_users&view=users&filter[search]=ID:<?=$item->user_id?>"><?=JFactory::getUser($item->user_id)->username?></a></td>
        <td><a target="_blank" href="index.php?option=com_shoppingoverview&controller=items&filter[search]=<?=$item->post_id?>"><?=$item->product?></a></td>
        <td><?=DopFunction::viewPublish($item->published)?></td>
        <td><a href="index.php?option=com_shoppingoverview&controller=favorites&task=edit&id=<?=$item->id?>"><?=$item->id?></a></td>
    </tr>
<?php endforeach; ?>
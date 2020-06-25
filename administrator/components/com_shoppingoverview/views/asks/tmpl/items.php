<?php

defined('_JEXEC') or die;

JHtml::_('behavior.formvalidator');
JHtml::_('behavior.keepalive');

?>

<?php foreach($rows as $item): ?>
    <tr>
        <td><input id="cb<?=$item->id?>" name="cid[]" value="<?=$item->id?>" onclick="Joomla.isChecked(this.checked);" type="checkbox"></td>
        <td><?=JFactory::getUser($item->user_id)->username?></td>
        <td><?=JFactory::getUser($item->user_id)->email?></td>
        <td><?=$item->link?></td>
        <td><?=$item->text?></td>
        <td><?=$item->created?></td>
        <td><a href="index.php?option=com_shoppingoverview&controller=asks&task=edit&id=<?=$item->id?>"><?=$item->id?></a></td>
    </tr>
<?php endforeach; ?>
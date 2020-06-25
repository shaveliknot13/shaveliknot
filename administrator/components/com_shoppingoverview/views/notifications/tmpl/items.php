<?php

defined('_JEXEC') or die;

JHtml::_('behavior.formvalidator');
JHtml::_('behavior.keepalive');

?>

<?php foreach($rows as $item): ?>
    <tr>
        <td><input id="cb<?=$item->id?>" name="cid[]" value="<?=$item->id?>" onclick="Joomla.isChecked(this.checked);" type="checkbox"></td>
        <td><a href="index.php?option=com_shoppingoverview&controller=notifications&task=edit&id=<?=$item->id?>"><?=$item->title?></a></td>
        <td><?=$item->template?></td>
        <td><?=DopFunction::viewType($item->type)?></td>
        <td><?=DopFunction::viewPublish($item->published)?></td>
        <td><?=$item->id?></td>
    </tr>
<?php endforeach; ?>
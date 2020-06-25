<?php

defined('_JEXEC') or die;

JHtml::_('behavior.formvalidator');
JHtml::_('behavior.keepalive');

?>

<?php foreach($rows as $item): ?>
    <tr>
        <td><input id="cb<?=$item->id?>" name="cid[]" value="<?=$item->id?>" onclick="Joomla.isChecked(this.checked);" type="checkbox"></td>
        <td>
            <a href="index.php?option=com_shoppingoverview&controller=categories&task=edit&id=<?=$item->id?>"><?=$item->title_ru?></a><br/>
            <a href="index.php?option=com_shoppingoverview&controller=categories&task=edit&id=<?=$item->id?>"><?=$item->title_en?></a><br/>
            <a href="index.php?option=com_shoppingoverview&controller=categories&task=edit&id=<?=$item->id?>"><?=$item->title_he?></a>
        </td>
        <td><?=$item->alias?></td>
        <td><?=DopFunction::textToMini($item->text)?></td>
        <td><?=$item->created?></td>
        <td><?=DopFunction::viewPublish($item->published)?></td>
        <td><?=$item->id?></td>
    </tr>
<?php endforeach; ?>
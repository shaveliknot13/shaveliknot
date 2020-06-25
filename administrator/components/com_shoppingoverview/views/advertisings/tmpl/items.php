<?php

defined('_JEXEC') or die;

JHtml::_('behavior.formvalidator');
JHtml::_('behavior.keepalive');

?>

<?php foreach($rows as $item): ?>
    <tr>
        <td><input id="cb<?=$item->id?>" name="cid[]" value="<?=$item->id?>" onclick="Joomla.isChecked(this.checked);" type="checkbox"></td>
        <td><a href="index.php?option=com_shoppingoverview&controller=advertisings&task=edit&id=<?=$item->id?>"><?=$item->title?></a></td>
        <td><?=$item->type_mod_com?></td>
        <?php if($item->type_mod_com == 'component'){ ?>
            <td><?=$item->position?></td>
        <?php }elseif($item->type_mod_com == 'module'){ ?>
            <td><?=$item->mod_id?></td>
        <?php }elseif($item->type_mod_com == 'item'){ ?>
            <td>item</td>
        <?php }elseif($item->type_mod_com == 'email'){ ?>
        <td>[advertisings]</td>
            <?php } ?>
        <td><?=$item->hits_constraints?></td>
        <td><?=$item->hits?></td>
        <td><?=DopFunction::viewPublish($item->published)?></td>
        <td><?=$item->id?></td>
    </tr>
<?php endforeach; ?>
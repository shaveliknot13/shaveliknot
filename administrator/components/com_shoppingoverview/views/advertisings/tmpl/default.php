<?php

defined('_JEXEC') or die;

JHtml::_('behavior.formvalidator');
JHtml::_('behavior.keepalive');

ShoppingoverviewHelper::setDocument();

?>
<div id="j-sidebar-container" class="span2">
    <?php echo $this->sidebar; ?>
</div>
<div id="j-main-container" class="span10">

    <?php require_once(dirname(__FILE__).'/filter.php'); ?>

    <form id="adminForm" name="adminForm" method="post" action="/administrator/index.php?option=com_shoppingoverview&controller=advertisings">

        <table class="adminlist table table-striped">
            <thead>
            <tr>
                <th><input name="checkall-toggle" value="" class="hasTooltip" title="" onclick="Joomla.checkAll(this)" data-original-title="Выбрать все" type="checkbox"></th>
                <th>Название</th>
                <th>Тип</th>
                <th>Позиция</th>
                <th>Просмотров разрешено</th>
                <th>Просмотры</th>
                <th>Опубликован</th>
                <th>ID</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($this->rows as $item): ?>
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
                        <td>[advertisings]/td>
                    <?php } ?>
                    <td><?=$item->hits_constraints?></td>
                    <td><?=$item->hits?></td>
                    <td><?=DopFunction::viewPublish($item->published)?></td>
                    <td><?=$item->id?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot>
            <tr>
                <td colspan="8">
                    <button type="button" data-count="<?=$this->filter->limit?>" id="ajaxAdminAdvertisingsItems" class="btn btn-success btn-block btn-xs button-ajax_get_item">Показать ещё</button>
                </td>
            </tr>
            </tfoot>
        </table>
        <input type="hidden" value="" name="task">
        <input type="hidden" value="0" name="boxchecked">
    </form>
</div>
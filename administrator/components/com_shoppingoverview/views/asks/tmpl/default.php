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

    <form id="adminForm" name="adminForm" method="post" action="/administrator/index.php?option=com_shoppingoverview&controller=asks">

        <table class="adminlist table table-striped">
            <thead>
            <tr>
                <th><input name="checkall-toggle" value="" class="hasTooltip" title="" onclick="Joomla.checkAll(this)" data-original-title="Выбрать все" type="checkbox"></th>
                <th>Имя</th>
                <th>Емайл</th>
                <th>Ссылка</th>
                <th>Сообщение</th>
                <th>Создан</th>
                <th>ID</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($this->rows as $item): ?>
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
            </tbody>
            <tfoot>
            <tr>
                <td colspan="7">
                    <button type="button" data-count="<?=$this->filter->limit?>" id="ajaxAdminAsksItems" class="btn btn-success btn-block btn-xs button-ajax_get_item">Показать ещё</button>
                </td>
            </tr>
            </tfoot>
        </table>
        <input type="hidden" value="" name="task">
        <input type="hidden" value="0" name="boxchecked">
    </form>
</div>
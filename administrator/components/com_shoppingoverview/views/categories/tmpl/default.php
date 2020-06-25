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

    <form id="adminForm" name="adminForm" method="post" action="/administrator/index.php?option=com_shoppingoverview&controller=categories">

        <table class="adminlist table table-striped">
            <thead>
            <tr>
                <th><input name="checkall-toggle" value="" class="hasTooltip" title="" onclick="Joomla.checkAll(this)" data-original-title="Выбрать все" type="checkbox"></th>
                <th>Наименование</th>
                <th>Алияс</th>
                <th>Описание</th>
                <th>Создан</th>
                <th>Опубликован</th>
                <th>ID</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($this->rows as $item): ?>
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
            </tbody>
            <tfoot>
            <tr>
                <td colspan="7">
                    <button type="button" data-count="<?=$this->filter->limit?>" id="ajaxAdminCategoriesItems" class="btn btn-success btn-block btn-xs button-ajax_get_item">Показать ещё</button>
                </td>
            </tr>
            </tfoot>
        </table>
        <input type="hidden" value="" name="task">
        <input type="hidden" value="0" name="boxchecked">
    </form>
</div>
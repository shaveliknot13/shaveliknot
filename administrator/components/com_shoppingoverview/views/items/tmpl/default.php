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

    <form id="adminForm" name="adminForm" method="post" action="/administrator/index.php?option=com_shoppingoverview&controller=items">

        <table class="adminlist table table-striped">
            <thead>
            <tr>
                <th><input name="checkall-toggle" value="" class="hasTooltip" title="" onclick="Joomla.checkAll(this)" data-original-title="Выбрать все" type="checkbox"></th>
                <th>Продукт</th>
                <th>Категория</th>
                <th>Алияс</th>
                <th>Цена</th>
                <th>Магазин</th>
                <th>YouTube</th>
                <th>Теги</th>
                <th>Лайки</th>
                <th>Избранное</th>
                <th>Создан</th>
                <th>Изменен</th>
                <th>Опубликован</th>
                <th>ID</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($this->rows as $item):?>
                <tr>
                    <td><input id="cb<?=$item->id?>" name="cid[]" value="<?=$item->id?>" onclick="Joomla.isChecked(this.checked);" type="checkbox"></td>
                    <td><a href="index.php?option=com_shoppingoverview&controller=items&task=edit&id=<?=$item->id?>"><?=$item->product?></a></td>
                    <td>
                        <?=$item->cattitle_ru?><br/>
                        <?=$item->cattitle_en?><br/>
                        <?=$item->cattitle_he?>
                    </td>
                    <td>
                        <a target="_blank" class="so_tags_link" href="<?=DopFunction::siteLink('/index.php?option=com_shoppingoverview&cat_alias='.$item->cat_alias.'&item_alias='.$item->alias_ru.'&Itemid=101','ru')?>">
                            <?=DopFunction::textToMini($item->alias_ru,25)?>
                        </a>
                        <a target="_blank" class="so_tags_link" href="<?=DopFunction::siteLink('/index.php?option=com_shoppingoverview&cat_alias='.$item->cat_alias.'&item_alias='.$item->alias_en.'&Itemid=101','en')?>">
                            <?=DopFunction::textToMini($item->alias_en,25)?>
                        </a>
                        <a target="_blank" class="so_tags_link" href="<?=DopFunction::siteLink('/index.php?option=com_shoppingoverview&cat_alias='.$item->cat_alias.'&item_alias='.$item->alias_he.'&Itemid=101','he')?>">
                            <?=DopFunction::textToMini($item->alias_he,25)?>
                        </a>
                    </td>
                    <td><?=$item->price?></td>
                    <td>
                        <a target="_blank" href="<?=$item->shop?>"><?=DopFunction::textToMini($item->shop_name,10)?></a>
                    </td>
                    <td>
                        <?php if(!empty($item->youtube)): ?>
                            <a target="_blank" href="<?=$item->youtube?>">Показать</a>
                        <?php endif; ?>
                    </td>
                    <td>
                    <?php
                        $explodeTags = $this->modelTags->getCommunications($item->id);
                        foreach($explodeTags as $itemTag){
                    ?>
                            <a target="_blank" class="so_tags_link" href="index.php?option=com_shoppingoverview&controller=tags&task=filter&filter[search]=<?=$itemTag->title?>">
                                <?=DopFunction::textToMini($itemTag->title,10)?>
                            </a>
                    <?php
                        }
                    ?>
                    </td>
                    <td><?=$item->countlike?></td>
                    <td><a target="_blank" href="index.php?option=com_shoppingoverview&controller=favorites&task=filter&filter[search]=<?=$item->id?>"><?=$item->countfavorite?></a></td>
                    <td class="center">
                        <?=$item->created?>
                        <?php
                        $userItem = JFactory::getUser($item->user_id);
                        $userGroup = "user-published";
                        if($userItem->authorise('core.admin')){
                            $userGroup = "user-admin";
                        }
                        ?>
                        <div class="<?=$userGroup?>">
                            <?=$userItem->username;?>
                        </div>
                    </td>
                    <td class="center">
                        <?=$item->modified?>
                        <?php
                        $userModified = JFactory::getUser($item->modified_user_id);
                        $userGroup = "user-published";
                        if($userModified->authorise('core.admin')){
                            $userGroup = "user-admin";
                        }
                        ?>
                        <div class="<?=$userGroup?>">
                            <?=$userModified->username;?>
                        </div>
                    </td>
                    <td><?=DopFunction::viewPublish($item->published)?></td>
                    <td><?=$item->id?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot>
            <tr>
                <td colspan="15">
                    <button type="button" data-count="<?=$this->filter->limit?>" id="ajaxAdminItemsItems" class="btn btn-success btn-block btn-xs button-ajax_get_item">Показать ещё</button>
                </td>
            </tr>
            </tfoot>
        </table>
        <input type="hidden" value="" name="task">
        <input type="hidden" value="0" name="boxchecked">
    </form>
</div>
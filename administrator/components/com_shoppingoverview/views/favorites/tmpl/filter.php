<?php

defined('_JEXEC') or die;

JHtml::_('behavior.formvalidator');
JHtml::_('behavior.keepalive');

?>


<form id="adminFormFilter" name="adminFormFilter" method="post" action="/administrator/index.php?option=com_shoppingoverview&controller=favorites&task=filter">

    <div class="btn-wrapper input-append" style="float: left;">
        <input name="filter[search]" id="filter_search" value="<?=$this->filter->search?>" placeholder="Поиск" data-original-title="" title="" type="text">
        <button type="submit" class="btn hasTooltip" title="" data-original-title="Искать">
            <span class="icon-search"></span>
        </button>
    </div>
    <div class="btn-wrapper" style="float: right;margin-left: 10px;">
        <select id="filter_ordering" name="filter[ordering]">
            <?php
            $ordering = array(
                'id ASC'=>'ID (по возрастанию)',
                'id DESC'=>'ID (по убыванию)'
            );
            foreach($ordering as $key => $value):
            ?>
            <option value="<?=$key?>" <?php if($key == $this->filter->ordering): ?>selected="selected"<?php endif; ?> ><?=$value?></option>
            <?php
            endforeach;
            ?>
        </select>
    </div>
    <div class="btn-wrapper" style="float: right;margin-left: 10px;">
        <select id="filter_limit" name="filter[limit]" class="input-mini">
            <?php
            $limit = array(
                '10'=>'10',
                '25'=>'25',
                '50'=>'50',
                '100'=>'100',
                '0'=>'Все'
            );
            foreach($limit as $key => $value):
            ?>
            <option value="<?=$key?>" <?php if($key == $this->filter->limit): ?>selected="selected"<?php endif; ?> ><?=$value?></option>
            <?php
            endforeach;
            ?>
        </select>
    </div>

</form>

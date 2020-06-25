<?php
defined('_JEXEC') or die;

$explodeTags = $this->modelTags->getCommunications($this->row->id);

?>
<div class="so_tags">
    <div class="so_tags_items">
        <?php
            foreach($explodeTags as $item){
                echo "<span>".$item->title."<i class=\"so_tag_remove\"></i></span>";
            }
        ?>
    </div>
    <div class="so_tags_input"><input placeholder="<?php echo JText::_('COM_SHOPPINGOVERVIEW_EDIT_FILD_17'); ?>" maxlength="35" autocomplete="off" type="text"></div>
    <div class="so_tags_input_hide">
        <?php
        foreach($explodeTags as $item){
            echo "<input type=\"hidden\" name=\"jform[myFieldset][tags][]\" value=\"".$item->title."\">";
        }
        ?>
    </div>
</div>
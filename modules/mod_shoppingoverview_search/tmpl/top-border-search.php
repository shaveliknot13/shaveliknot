<?php
// No direct access
defined('_JEXEC') or die;
?>
<div class="mod_shoppingoverview_search">
    <form method="post" action="<?php echo JRoute::_( 'index.php?option=com_shoppingoverview&controller=search&Itemid=101' ); ?>">
        <div class="input-append">
            <input autocomplete="off" name="search" type="text" placeholder="&#xF002; <?php echo JText::_('MOD_SHOPPINGOVERVIEW_SEARCH_AMX_1'); ?>" >
            <select name="type">
                <option value="titles"><?php echo JText::_('MOD_SHOPPINGOVERVIEW_SEARCH_IN_HEADERS'); ?></option>
                <option value="tags"><?php echo JText::_('MOD_SHOPPINGOVERVIEW_SEARCH_IN_TAGS'); ?></option>
                <option value="users"><?php echo JText::_('MOD_SHOPPINGOVERVIEW_SEARCH_IN_AUTHORS'); ?></option>
            </select>
            <div class="btn input-search"><?php echo JText::_('MOD_SHOPPINGOVERVIEW_SEARCH_AMX_2'); ?></div>
        </div>
        <div class="result_search">
        </div>
    </form>
</div>
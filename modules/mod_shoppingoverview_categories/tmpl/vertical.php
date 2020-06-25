<?php
// No direct access
defined('_JEXEC') or die; ?>

<div>
    <ul>
    <?php foreach($row as $item): ?>

        <li>
            <a href="<?php echo JRoute::_( 'index.php?option=com_shoppingoverview&cat_alias='.$item->alias.'&Itemid=101' ); ?>">
                <?=$item->{'title_'.$lang}?>
            </a>
        </li>

    <?php endforeach; ?>
    </ul>
</div>
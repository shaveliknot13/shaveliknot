<?php
// No direct access
defined('_JEXEC') or die;

?>

<?php foreach($items as $item): ?>
    <?php
    // подготавливаем модели
    $modelFavorites = $modelFavorites;
    $modelImages = $modelImages;
    $modelTags = $modelTags;
    $lang = $lang;
    // Формируем шаблон
    $item = $item;
    ?>
    <div class="shoppingoverview-page-item">


        <div class="shoppingoverview-page-item-original">
            <?php require(JPATH_SITE.'/components/com_shoppingoverview/views/items/tmpl/item.php');?>
        </div>

    </div>
<?php endforeach; ?>
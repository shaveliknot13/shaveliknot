<?php
// No direct access
defined('_JEXEC') or die;

$date_m = array(
    "ru" => array(
        '01'=>'январь',
        '02'=>'февраль',
        '03'=>'март',
        '04'=>'апрель',
        '05'=>'май',
        '06'=>'июнь',
        '07'=>'июль',
        '08'=>'август',
        '09'=>'сентябрь',
        '10'=>'октябрь',
        '11'=>'ноябрь',
        '12'=>'декабрь'
    ),
    "en" => array(
        '01' => 'january',
        '02' => 'february',
        '03' => 'march',
        '04' => 'april',
        '05' => 'may',
        '06' => 'june',
        '07' => 'july',
        '08' => 'august',
        '09' => 'september',
        '10' => 'october',
        '11' => 'november',
        '12' => 'december'
    ),
    "he" => array(
        '01' => 'ינואר',
        '02' => 'פברואר',
        '03' => 'מרץ',
        '04' => 'אפריל',
        '05' => 'מאי',
        '06' => 'יוני',
        '07' => 'יולי',
        '08' => 'אוגוסט',
        '09' => 'ספטמבר',
        '10' => 'אוקטובר',
        '11' => 'נובמבר',
        '12' => 'דצמבר',
    )
);

$date_one = "";
$countFix = false;
?>

        <?php $i=1; foreach ( $items as $item ): ?>

            <?php if($date_one != $item->dateday ):
                        $date_one = $item->dateday;
                        $date_arr = explode("-",$item->dateday);
            ?>

            <?php if(!empty($countFix)):?>
                </div>
            <?php endif; $countFix=true; ?>

            <div class="row-fluid">
                <div class="span12">
                    <div class="row-fluid panel-my">
                        <div class="span12">
                            <i class="fal fa-calendar"></i> <?php echo $date_arr[0]." ".$date_m[$lang][$date_arr[1]]." ".$date_arr[2]; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
            <?php endif; ?>
            <?php
            // подготавливаем модели
            $modelFavorites = $modelFavorites;
            $modelImages = $modelImages;
            $modelTags = $modelTags;
            $modelAvertisings = $modelAvertisings;
            $lang = $lang;
            // Формируем шаблон
            $item = $item;
            ?>
            <?=$modelAvertisings->advertisingsItem();?>
            <div class="shoppingoverview-page-item">
                <div class="shoppingoverview-page-item-original">
                    <?php require(JPATH_SITE.'/components/com_shoppingoverview/views/items/tmpl/item.php');?>
                </div>

            </div>
        <?php $i++; endforeach; ?>

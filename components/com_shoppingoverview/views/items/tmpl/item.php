<?php
defined('_JEXEC') or die;

// вытаскиваем картинки
$img = DopFunction::explodeReg($item->{'text_'.$lang},$modelImages);
$countImg = count($img);
$amxI = 0;



// Для видео
$youtube = false;
if(!empty($item->youtube)){
    $getIdYoutube = DopFunction::getIdYoutube($item->youtube);
    if(!empty($getIdYoutube)){
        $countImg++;
        $youtube = true;
    }
}

if(($countImg > 5 && $youtube == true) || ($countImg > 6 && $youtube == false)){
    $countImg = 6;
}

// калаж
$countImg++;

// количество вариков
$rand = [2=>2, 3=>2, 5=>2, 6=>4];


?>





    <div class="shoppingoverview-page-item-imgs" data-num="1" date-limit="<?=$countImg?>">

        <div class="items-amx">
            <div class="items-amx-collage items-amx-collage-<?=$countImg-1?>-<?=rand(1,$rand[$countImg-1])?>">
            <?php
            foreach($img as $imgItem){

                $imgItem = str_replace('/upload/','/upload/thumbs/',$imgItem->img);
                $amxI++;
                if(($amxI > 5 && $youtube == true) || ($amxI > 6 && $youtube == false)){
                    break;
                }
                echo '<div style="background: url('.DopFunction::getUrlImg($imgItem).') center center no-repeat;">';
                echo '</div>';
            }

            if($youtube == true){
                echo '<div style="background: url(/components/com_shoppingoverview/assets/images/video.jpg) center center no-repeat;"></div>';
            }
            ?>
            </div>
        </div>


        <?php
        $amxI = 0;
        foreach($img as $imgItem){
            $imgItem = str_replace('/upload/','/upload/thumbs/',$imgItem->img);
            $amxI++;
            if(($amxI > 5 && $youtube == true) || ($amxI > 6 && $youtube == false)){
                break;
            }
            echo '<div class="items-amx">';
            echo $imgItem;
            echo '</div>';
        }
        ?>

        <?php
        // Видео вствляем
        if($youtube == true):
            ?>
            <div class="items-amx items-amx-video">
                <iframe id="video_<?=$item->id?>" type="text/html" width="100%" height="100%"
                        src="http://www.youtube.com/embed/<?=$getIdYoutube?>?autoplay=0&controls=0&loop=1&modestbranding=1showinfo=0&rel=0&mute=0&fs=0&enablejsapi=1&version=3"
                        frameborder="0"></iframe>
                <div class="youtube-play-stop" data-status="stop"></div>
            </div>
        <?php
        endif;
        ?>

        <div class="arrow-left-nav"></div>
        <div class="arrow-right-nav"></div>


    </div>

    <div class="shoppingoverview-page-item-favorites-sharing">
        <div class="span6amx shoppingoverview-page-item-info">
            <i class="fas fa-eye"></i> <?php echo DopFunction::replaceThreeZeros($item->hits); ?>
            &nbsp;
            <i class="fas fa-thumbs-up"></i> <?php echo DopFunction::replaceThreeZeros($item->countlike); ?>
        </div>
        <div class="span6amx">
            <div class="items-amx-imgs-mini">
                <?php
                echo "<div class='active'></div>";
                $amxI = 0;
                foreach($img as $imgItem){
                    $amxI++;
                    if(($amxI > 5 && $youtube == true) || ($amxI > 6 && $youtube == false)){
                        break;
                    }
                    echo "<div></div>";
                }
                if($youtube == true){
                    echo "<div></div>";
                }

                ?>
            </div>
        </div>
        <div class="span6amx" style="text-align: right;">
            <?php
                $star = $modelFavorites->displayFavoritesMini( $item->id,JFactory::getUser() );
            ?>
            <div data-id="<?=$item->id?>" class="shoppingoverview-page-item-add-favorites add-favorites <?=$star ?>">
                <i class="<?php if(trim($star) == 'favorites'): ?>fas<?php else: ?>fal<?php endif; ?> fa-star"></i>
            </div>
            <div class="shoppingoverview-page-item-sharing">
            <div class="me-share">
                <div>
                    <a target="_blank" href="https://www.facebook.com/sharer.php?src=sp&u=<?php echo JRoute::_( 'index.php?option=com_shoppingoverview&cat_alias='.$item->cat_alias.'&item_alias='.$item->{'alias_'.$lang}.'&Itemid=101', true, 1 ); ?>&title=<?php echo $item->product.' '.$item->{'title_'.$lang}; ?>&utm_source=share2">
                        <i class="fab fa-facebook-square"></i> Facebook
                    </a>
                </div>
                <div>
                    <a target="_blank" href="viber://forward?text=<?php echo $item->product.' '.$item->{'title_'.$lang}; ?> <?php echo JRoute::_( 'index.php?option=com_shoppingoverview&cat_alias='.$item->cat_alias.'&item_alias='.$item->{'alias_'.$lang}.'&Itemid=101', true, 1 ); ?>&utm_source=share2">
                        <i class="fab fa-viber"></i> Viber
                    </a>
                </div>
                <div>
                    <a target="_blank" href="https://twitter.com/intent/tweet?text=<?php echo $item->product.' '.$item->{'title_'.$lang}; ?>&url=<?php echo JRoute::_( 'index.php?option=com_shoppingoverview&cat_alias='.$item->cat_alias.'&item_alias='.$item->{'alias_'.$lang}.'&Itemid=101', true, 1 ); ?>&utm_source=share2">
                        <i class="fab fa-twitter-square"></i> Twitter
                    </a>
                </div>
                <div>
                    <a target="_blank" href="https://api.whatsapp.com/send?text=<?php echo $item->product.' '.$item->{'title_'.$lang}; ?> <?php echo JRoute::_( 'index.php?option=com_shoppingoverview&cat_alias='.$item->cat_alias.'&item_alias='.$item->{'alias_'.$lang}.'&Itemid=101', true, 1 ); ?>&utm_source=share2">
                        <i class="fab fa-whatsapp-square"></i> Whatsapp
                    </a>
                </div>
                <div>
                    <a target="_blank" href="https://web.skype.com/share?url=<?php echo JRoute::_( 'index.php?option=com_shoppingoverview&cat_alias='.$item->cat_alias.'&item_alias='.$item->{'alias_'.$lang}.'&Itemid=101', true, 1 ); ?>&utm_source=share2">
                        <i class="fab fa-skype"></i> Skype
                    </a>
                </div>
                <div>
                    <a target="_blank" href="https://telegram.me/share/url?url=<?php echo JRoute::_( 'index.php?option=com_shoppingoverview&cat_alias='.$item->cat_alias.'&item_alias='.$item->{'alias_'.$lang}.'&Itemid=101', true, 1 ); ?>&text=<?php echo $item->product.' '.$item->{'title_'.$lang}; ?>&utm_source=share2">
                        <i class="fab fa-telegram"></i> Telegram
                    </a>
                </div>
            </div>
                <i class="fa fa-share-alt"></i>
            </div>
        </div>
    </div>

    <div class="shoppingoverview-page-item-titles">
        <a href="<?php echo JRoute::_( 'index.php?option=com_shoppingoverview&cat_alias='.$item->cat_alias.'&item_alias='.$item->{'alias_'.$lang}.'&Itemid=101' ); ?>"><?php echo $item->product.' - '.$item->{'title_'.$lang}; ?></a>
    </div>

    <div class="shoppingoverview-page-item-tags">
        <?php
        $explodeTags = $modelTags->getCommunications($item->id);
        foreach($explodeTags as $itemTag){
            ?>
            <a href="<?php echo JRoute::_( 'index.php?option=com_shoppingoverview&controller=tags&task=tag&Itemid=101&id='.$itemTag->id ); ?>">
                <?php
                if(!empty($itemTag->{'title_'.$lang})){
                    echo '#'.$itemTag->{'title_'.$lang};
                }else{
                    echo '#'.$itemTag->title;
                }
                ?>
            </a>
        <?php
        }
        ?>
    </div>

    <div class="shoppingoverview-page-item-fast-link">

        <a href="<?php echo JRoute::_( 'index.php?option=com_shoppingoverview&cat_alias='.$item->cat_alias.'&item_alias='.$item->{'alias_'.$lang}.'&Itemid=101' ); ?>"><?php echo JText::_('COM_SHOPPINGOVERVIEW_ONE'); ?></a>
        <a target="_blank" href="<?=$item->shop?>"><?php echo JText::_('COM_SHOPPINGOVERVIEW_TEXT_70'); ?></a>
    </div>

    <div class="shoppingoverview-page-item-avatar row-fluid">
        <div class="shoppingoverview-page-item-avatar-mod-2">
            <div style="margin-bottom: 3px">
                <i class="fas fa-user"></i> <a href="<?=JRoute::_( 'index.php?option=com_shoppingoverview&controller=users&task=profile&Itemid=101&id='.$item->user_id );?>"><?=JFactory::getUser($item->user_id)->username?></a>
            </div>
            <div>
                <i class="far fa-calendar-alt"></i> <?php echo JText::_('COM_SHOPPINGOVERVIEW_TEXT_2'); ?> <?=DopFunction::showDate(strtotime($item->created));?>
            </div>
        </div>
    </div>

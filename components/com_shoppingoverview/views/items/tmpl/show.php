<?php

defined( '_JEXEC' ) or die; // No direct access
$user   = JFactory::getUser();
?>
<div class="item-page-show">



    <?php if($this->row->published == 0): ?>
        <div id="system-message-container">
            <div id="system-message">
                <div class="alert ">
                    <a class="close" data-dismiss="alert">×</a>

                    <h4 class="alert-heading"><?php echo JText::_('COM_SHOPPINGOVERVIEW_SHOW_FILD_12'); ?></h4>
                    <div>
                        <div class="alert-message"><?php echo JText::_('COM_SHOPPINGOVERVIEW_SHOW_FILD_13'); ?></div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <h1><span><?php echo JText::_('COM_SHOPPINGOVERVIEW_ONE'); ?> <?=$this->row->product;?></span><?=$this->row->{'title_'.$this->lang};?></h1>

    <div class="item-page-show-linephoto owl-carousel">
        <?php if( $this->modelYoutube->video_exists($this->modelYoutube->getId($this->row->youtube)) ): ?>
            <a data-fancybox="gallery" href="https://www.youtube.com/embed/<?=$this->modelYoutube->getId($this->row->youtube)?>"><img src="/components/com_shoppingoverview/assets/images/video.jpg" ></a>
        <?php endif; ?>
        <?php
        $img = DopFunction::explodeReg($this->row->{'text_'.$this->lang},$this->modelImages);
        foreach($img as $imgItem):
            $imgBig = str_replace('<img src="','',$imgItem->img);
            $imgBig = str_replace('"/>','',$imgBig);
            $imgMin = str_replace('/upload/','/upload/thumbs/',$imgItem->img);
            ?>
            <a data-fancybox="gallery" href="<?=$imgBig?>"><?=$imgMin?></a>
        <?php
        endforeach;
        ?>
    </div>
    <div class="item-page-show-description">
        <?=nl2br($this->row->{'mini_text_'.$this->lang})?>
    </div>

    <div class="item-page-show-price">

            <div class="nav-tabs-bar">
                <div class="active" date-href="ibuy"><?php echo JText::_('COM_SHOPPINGOVERVIEW_TEXT_37'); ?></div>
                <div date-href="morebuy"><?php echo JText::_('COM_SHOPPINGOVERVIEW_TEXT_39'); ?></div>
            </div>

            <div class="nav-tabs-bar-content">
                <div id="ibuy">
                    <div class="buy">
                        <a href="<?=$this->row->shop?>"><?php echo JText::_('COM_SHOPPINGOVERVIEW_TEXT_70'); ?></a> <span><?=$this->row->price?>$</span>
                    </div>
                    <div class="avatar">
                        <div class="item-page-show-avatar">
                            <?php
                            $customFields = FieldsHelper::getFields('com_users.user', ['id'=> $this->row->user_id]);
                            ?>
                            <div class="shoppingoverview-page-item-avatar-mod-1">
                                <img src="<?=$customFields[0]->value?>"/>
                            </div>
                            <div class="shoppingoverview-page-item-avatar-mod-2" style="width: calc(100% - 52px)">
                                <div>
                                    <a href="<?=JRoute::_( 'index.php?option=com_shoppingoverview&controller=users&task=profile&Itemid=101&id='.$this->row->user_id );?>"><?=JFactory::getUser($this->row->user_id)->username?></a>
                                </div>
                                <div>
                                    <?php echo JText::_('COM_SHOPPINGOVERVIEW_TEXT_2'); ?> <?=DopFunction::showDate(strtotime($this->row->created));?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="how-was-purchase">
                        <?=$this->row->{'hwp_text_'.$this->lang};?>
                    </div>
                </div>
                <div id="morebuy">
                    <div>
                        <div class="row-fluid">
                            <div class="span6"><span>500$</span> <a href="#"> - <?php echo JText::_('COM_SHOPPINGOVERVIEW_TEXT_38'); ?> Цитрус</a></div>
                            <div class="span6"><span>600$</span> <a href="#"> - <?php echo JText::_('COM_SHOPPINGOVERVIEW_TEXT_38'); ?> Алло</a></div>
                        </div>
                        <div class="row-fluid">
                            <div class="span6"><span>700$</span> <a href="#"> - <?php echo JText::_('COM_SHOPPINGOVERVIEW_TEXT_38'); ?> Розетка</a></div>
                            <div class="span6"><span>500$</span> <a href="#"> - <?php echo JText::_('COM_SHOPPINGOVERVIEW_TEXT_38'); ?> Цитрус</a></div>
                        </div>
                        <div class="row-fluid">
                            <div class="span6"><span>600$</span> <a href="#"> - <?php echo JText::_('COM_SHOPPINGOVERVIEW_TEXT_38'); ?> Алло</a></div>
                            <div class="span6"><span>700$</span> <a href="#"> - <?php echo JText::_('COM_SHOPPINGOVERVIEW_TEXT_38'); ?> Розетка</a></div>
                        </div>
                    </div>
                </div>
            </div>


    </div>


    <div class="item-page-show-info">
        <span><i class="far fa-eye"></i> <?php echo DopFunction::replaceThreeZeros($this->row->hits); ?> <?php echo JText::_('COM_SHOPPINGOVERVIEW_TEXT_1'); ?></span>
        <span><i class="fal fa-thumbs-up"></i> <?php echo DopFunction::replaceThreeZeros($this->row->countlike); ?> <?php echo JText::_('COM_SHOPPINGOVERVIEW_TEXT_34'); ?></span>
        <span><i class="fal fa-star"></i> <?php echo DopFunction::replaceThreeZeros($this->row->countfavorite); ?> <?php echo JText::_('COM_SHOPPINGOVERVIEW_TEXT_36'); ?></span>
        <span><i class="fal fa-comment"></i> <?php echo DopFunction::replaceThreeZeros($this->row->countcomment); ?> <?php echo JText::_('COM_SHOPPINGOVERVIEW_TEXT_35'); ?></span>
    </div>



    <div class="row-fluid item-page-show-button">
        <div class="span3">
            <div class="facebookBase">
                <div id="fb-root"></div>
                <?php
                if($this->lang == 'ru'){
                    $face_lang = 'ru_RU';
                }elseif($this->lang == 'he'){
                    $face_lang = 'he_IL';
                }else{
                    $face_lang = 'en_GB';
                }
                ?>
                <script>(function(d, s, id) {
                        var js, fjs = d.getElementsByTagName(s)[0];
                        if (d.getElementById(id)) return;
                        js = d.createElement(s); js.id = id;
                        js.src = 'https://connect.facebook.net/<?=$face_lang?>/sdk.js#xfbml=1&version=v2.12&appId=1658713200805550&autoLogAppEvents=1';
                        fjs.parentNode.insertBefore(js, fjs);
                    }(document, 'script', 'facebook-jssdk'));</script>
                <div class="fb-like"
                     data-href="<?='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>"
                     data-layout="button"
                     data-action="like"
                     data-size="large"
                     data-show-faces="false"
                     data-share="false"
                    >

                </div>
            </div>
        </div>
        <div class="span3">
            <div class="subscribeBase <?=$this->modelUsersubscribes->displaySubscribe( $this->row->user_id,JFactory::getUser() )?>" data-user-id="<?=$this->row->user_id?>">
                <?php echo JText::_('COM_SHOPPINGOVERVIEW_SHOW_FILD_11'); ?> <i class="fa fa-bell"></i>
            </div>
        </div>
        <div class="span3" style="position: relative">
            <div data-id="<?=$this->row->id?>" class="shoppingoverview-page-item-show-add-favorites add-favorites <?=$this->modelFavorites->displayFavoritesMini( $this->row->id,JFactory::getUser() ) ?>">
                <?php echo JText::_('COM_SHOPPINGOVERVIEW_FAVORITES'); ?> <i class="fas fa-star"></i>
            </div>
        </div>
        <div class="span3" style="position: relative">
            <div class="shoppingoverview-page-item-show-sharing">
                <div class="me-share">
                    <div>
                        <a target="_blank" href="https://www.facebook.com/sharer.php?src=sp&u=<?php echo JRoute::_( 'index.php?option=com_shoppingoverview&cat_alias='.$this->row->cat_alias.'&item_alias='.$this->row->{'alias_'.$this->lang}.'&Itemid=101', true, 1 ); ?>&title=<?php echo $this->row->product.' '.$this->row->{'title_'.$this->lang}; ?>&utm_source=share2">
                            <i class="fab fa-facebook-square"></i> Facebook
                        </a>
                    </div>
                    <div>
                        <a target="_blank" href="viber://forward?text=<?php echo $this->row->product.' '.$this->row->{'title_'.$this->lang}; ?> <?php echo JRoute::_( 'index.php?option=com_shoppingoverview&cat_alias='.$this->row->cat_alias.'&item_alias='.$this->row->{'alias_'.$this->lang}.'&Itemid=101', true, 1 ); ?>&utm_source=share2">
                            <i class="fab fa-viber"></i> Viber
                        </a>
                    </div>
                    <div>
                        <a target="_blank" href="https://twitter.com/intent/tweet?text=<?php echo $this->row->product.' '.$this->row->{'title_'.$this->lang}; ?>&url=<?php echo JRoute::_( 'index.php?option=com_shoppingoverview&cat_alias='.$this->row->cat_alias.'&item_alias='.$this->row->{'alias_'.$this->lang}.'&Itemid=101', true, 1 ); ?>&utm_source=share2">
                            <i class="fab fa-twitter-square"></i> Twitter
                        </a>
                    </div>
                    <div>
                        <a target="_blank" href="https://api.whatsapp.com/send?text=<?php echo $this->row->product.' '.$this->row->{'title_'.$this->lang}; ?> <?php echo JRoute::_( 'index.php?option=com_shoppingoverview&cat_alias='.$this->row->cat_alias.'&item_alias='.$this->row->{'alias_'.$this->lang}.'&Itemid=101', true, 1 ); ?>&utm_source=share2">
                            <i class="fab fa-whatsapp-square"></i> Whatsapp
                        </a>
                    </div>
                    <div>
                        <a target="_blank" href="https://web.skype.com/share?url=<?php echo JRoute::_( 'index.php?option=com_shoppingoverview&cat_alias='.$this->row->cat_alias.'&item_alias='.$this->row->{'alias_'.$this->lang}.'&Itemid=101', true, 1 ); ?>&utm_source=share2">
                            <i class="fab fa-skype"></i> Skype
                        </a>
                    </div>
                    <div>
                        <a target="_blank" href="https://telegram.me/share/url?url=<?php echo JRoute::_( 'index.php?option=com_shoppingoverview&cat_alias='.$this->row->cat_alias.'&item_alias='.$this->row->{'alias_'.$this->lang}.'&Itemid=101', true, 1 ); ?>&text=<?php echo $this->row->product.' '.$this->row->{'title_'.$this->lang}; ?>&utm_source=share2">
                            <i class="fab fa-telegram"></i> Telegram
                        </a>
                    </div>
                </div>
                <span><?php echo JText::_('COM_SHOPPINGOVERVIEW_SHARES'); ?></span> <i class="fa fa-share-alt"></i>
            </div>
        </div>
    </div>

    <div class="item-page-show-tags">
        <?php
        ob_start();
        $explodeTags = $this->modelTags->getCommunications($this->row->id);
        foreach($explodeTags as $itemTag){
            ?>
            <a href="<?php echo JRoute::_( 'index.php?option=com_shoppingoverview&controller=tags&task=tag&Itemid=101&id='.$itemTag->id ); ?>">
                <?php
                if(!empty($itemTag->{'title_'.$this->lang})){
                    echo '#'.$itemTag->{'title_'.$this->lang};
                }else{
                    echo '#'.$itemTag->title;
                }
                ?>
            </a>
            <?php
        }
        $tegi_result = ob_get_contents();
        ob_end_clean();
        ?>
        <?=$tegi_result;?>
    </div>
    <?=$this->modelAvertisings->advertisings("item");?>

    <div class="item-page-show-video">
        <?php if( $this->modelYoutube->video_exists($this->modelYoutube->getId($this->row->youtube)) ): ?>
            <iframe width="100%" height="280px" src="https://www.youtube.com/embed/<?=$this->modelYoutube->getId($this->row->youtube)?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
        <?php
        else:
            if($user->id == $this->row->user_id && !empty($this->row->youtube)):
                ?>
                <span style="color: #f00;"><?php echo JText::_('COM_SHOPPINGOVERVIEW_TEXT_40'); ?></span>
            <?php endif; endif; ?>
    </div>
    <div class="item-page-show-content">
        <?php echo nl2br($this->row->{'text_'.$this->lang}); ?>
    </div>
    <?php
    echo $this->modelComments->commentsBlock();
    ?>
</div>
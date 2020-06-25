<?php
// No direct access
defined('_JEXEC') or die;

?>

<div class="mod_shoppingoverview_preview">

    <div class="name-modul-head-mobile"><i class="fas fa-eye"></i> Предпросмотр</div>

    <div class="content-title name-modul-body-mobile">
        <?php echo JText::_('MOD_SHOPPINGOVERVIEW_PREVIEW_1'); ?>
    </div>
    <div class="content-tabs name-modul-body-mobile">
        <div class="item-tab <?php if($lang == 'ru'):?>active<?php endif; ?>" date-lang="ru">RU</div>
        <div class="item-tab <?php if($lang == 'en'):?>active<?php endif; ?>" date-lang="en">EN</div>
        <div class="item-tab <?php if($lang == 'he'):?>active<?php endif; ?>" date-lang="he">HE</div>
    </div>
    <div class="content-block name-modul-body-mobile">


        <div class="shoppingoverview-page-item-original block-mod-js block-mod-js-ru">
            <div class="shoppingoverview-page-item-imgs">
                <img src="/modules/mod_shoppingoverview_preview/assets/img/photo.jpg">
            </div>

            <div class="shoppingoverview-page-item-favorites-sharing">
                <div class="span6amx shoppingoverview-page-item-info">
                    <i class="fas fa-eye"></i> 0            &nbsp;
                    <i class="fas fa-thumbs-up"></i> 0        </div>
                <div class="span6amx">
                    <div class="items-amx-imgs-mini">
                        <div class="active"></div><div></div><div></div></div>
                </div>
                <div class="span6amx" style="text-align: right;">
                    <div data-id="0" class="shoppingoverview-page-item-add-favorites add-favorites  favorites">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="shoppingoverview-page-item-sharing">
                        <i class="fa fa-share-alt"></i>
                    </div>
                </div>
            </div>

            <div class="shoppingoverview-page-item-titles">
                <a href="#">
                    <img src="/modules/mod_shoppingoverview_preview/assets/img/title.jpg">
                </a>
            </div>

            <div class="shoppingoverview-page-item-tags">
                <img src="/modules/mod_shoppingoverview_preview/assets/img/tags.jpg">
            </div>

            <div class="shoppingoverview-page-item-fast-link">

                <a href="#">Обзор</a>
                <a target="_blank" href="#">В магазин</a>
            </div>

            <div class="shoppingoverview-page-item-avatar row-fluid">
                <div class="shoppingoverview-page-item-avatar-mod-2">
                    <div style="margin-bottom: 3px">
                        <i class="fas fa-user"></i> <a href="#"><?=JFactory::getUser()->username?></a>
                    </div>
                    <div>
                        <i class="far fa-calendar-alt"></i> Опубликовано только что</div>
                </div>
            </div>
        </div>


        <div class="shoppingoverview-page-item-original block-mod-js block-mod-js-en">
            <div class="shoppingoverview-page-item-imgs">
                <img src="/modules/mod_shoppingoverview_preview/assets/img/photo.jpg">
            </div>

            <div class="shoppingoverview-page-item-favorites-sharing">
                <div class="span6amx shoppingoverview-page-item-info">
                    <i class="fas fa-eye"></i> 0            &nbsp;
                    <i class="fas fa-thumbs-up"></i> 0        </div>
                <div class="span6amx">
                    <div class="items-amx-imgs-mini">
                        <div class="active"></div><div></div><div></div></div>
                </div>
                <div class="span6amx" style="text-align: right;">
                    <div data-id="0" class="shoppingoverview-page-item-add-favorites add-favorites  favorites">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="shoppingoverview-page-item-sharing">
                        <i class="fa fa-share-alt"></i>
                    </div>
                </div>
            </div>

            <div class="shoppingoverview-page-item-titles">
                <a href="#">
                    <img src="/modules/mod_shoppingoverview_preview/assets/img/title.jpg">
                </a>
            </div>

            <div class="shoppingoverview-page-item-tags">
                <img src="/modules/mod_shoppingoverview_preview/assets/img/tags.jpg">
            </div>

            <div class="shoppingoverview-page-item-fast-link">

                <a href="#">Overview</a>
                <a target="_blank" href="#">To the store</a>
            </div>

            <div class="shoppingoverview-page-item-avatar row-fluid">
                <div class="shoppingoverview-page-item-avatar-mod-2">
                    <div style="margin-bottom: 3px">
                        <i class="fas fa-user"></i> <a href="#"><?=JFactory::getUser()->username?></a>
                    </div>
                    <div>
                        <i class="far fa-calendar-alt"></i> Just published</div>
                </div>
            </div>
        </div>


        <div class="shoppingoverview-page-item-original block-mod-js block-mod-js-he">
            <div class="shoppingoverview-page-item-imgs">
                <img src="/modules/mod_shoppingoverview_preview/assets/img/photo.jpg">
            </div>

            <div class="shoppingoverview-page-item-favorites-sharing">
                <div class="span6amx shoppingoverview-page-item-info">
                    <i class="fas fa-eye"></i> 0            &nbsp;
                    <i class="fas fa-thumbs-up"></i> 0        </div>
                <div class="span6amx">
                    <div class="items-amx-imgs-mini">
                        <div class="active"></div><div></div><div></div></div>
                </div>
                <div class="span6amx" style="text-align: right;">
                    <div data-id="0" class="shoppingoverview-page-item-add-favorites add-favorites  favorites">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="shoppingoverview-page-item-sharing">
                        <i class="fa fa-share-alt"></i>
                    </div>
                </div>
            </div>

            <div class="shoppingoverview-page-item-titles">
                <a href="#">
                    <img src="/modules/mod_shoppingoverview_preview/assets/img/title.jpg">
                </a>
            </div>

            <div class="shoppingoverview-page-item-tags">
                <img src="/modules/mod_shoppingoverview_preview/assets/img/tags.jpg">
            </div>

            <div class="shoppingoverview-page-item-fast-link">

                <a href="#">סקירה</a>
                <a target="_blank" href="#">לחנות</a>
            </div>

            <div class="shoppingoverview-page-item-avatar row-fluid">
                <div class="shoppingoverview-page-item-avatar-mod-2">
                    <div style="margin-bottom: 3px">
                        <i class="fas fa-user"></i> <a href="#"><?=JFactory::getUser()->username?></a>
                    </div>
                    <div>
                        <i class="far fa-calendar-alt"></i> בדיוק פורסם</div>
                </div>
            </div>
        </div>


    </div>
</div>

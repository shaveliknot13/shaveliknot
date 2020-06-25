<?php
defined('_JEXEC') or die;
?>

                <div class="original original_<?=$langBlock?>">
                    <?php

                    $baseTextRu = DopFunction::explodeReg($textAdd,$this->modelImages);

                    for($i=1;$i<=10;$i++):

                        ?>
                        <div class="addblock addblock_<?=$i?>">
                            <div class="photo">
                                <?php
                                if(isset($baseTextRu[$i]) && $baseTextRu[$i]->img != ''):
                                    $dopInfoWidth = DopFunction::getWidthAndHeightImg($baseTextRu[$i]->img)->width;
                                    $dopInfoHeight = DopFunction::getWidthAndHeightImg($baseTextRu[$i]->img)->height;
                                ?>
                                    <div date-width="<?=$dopInfoWidth?>" date-height="<?=$dopInfoHeight?>" class="clouse_img_so">×</div>
                                    <?=$baseTextRu[$i]->img?>
                                <?php
                                endif;
                                ?>
                            </div>
                            <?php
                            if(isset($baseTextRu[$i]) && $baseTextRu[$i]->img != ''){
                                $style = 'style="display:none;"';
                            }else{
                                $style = '';
                            }

                            ?>
                            <div class="addphoto" <?=$style?>>Добавить фотографию</div>
                            <input class="hidefile" accept="image/jpeg,image/png" type="file">
                            <textarea name="jform[myFieldset][text_<?=$langBlock?>][]" class="addtext" placeholder="Расскажите о товаре..."><?php if(isset($baseTextRu[$i])): ?><?=$baseTextRu[$i]->text?><?php endif; ?></textarea>
                            <input class="imageUrl" type="hidden" name="jform[myFieldset][images_<?=$langBlock?>][]" value="<?php if(isset($baseTextRu[$i]) && $baseTextRu[$i]->imgId != ''): ?><?=$baseTextRu[$i]->imgId?><?php endif; ?>">

                            <input class="coordinates_x1" type="hidden" name="jform[myFieldset][coordinates_<?=$langBlock?>_x1][]" value="0">
                            <input class="coordinates_x2" type="hidden" name="jform[myFieldset][coordinates_<?=$langBlock?>_x2][]" value="0">
                            <input class="coordinates_y1" type="hidden" name="jform[myFieldset][coordinates_<?=$langBlock?>_y1][]" value="0">
                            <input class="coordinates_y2" type="hidden" name="jform[myFieldset][coordinates_<?=$langBlock?>_y2][]" value="0">
                            <input class="coordinates_width" type="hidden" name="jform[myFieldset][coordinates_<?=$langBlock?>_width][]" value="0">
                            <input class="coordinates_height" type="hidden" name="jform[myFieldset][coordinates_<?=$langBlock?>_height][]" value="0">

                        </div>
                    <?php
                    endfor;
                    ?>
                    <?php
                        if(count($baseTextRu) == 0){
                            $count = 2;
                        }else{
                            $count = count($baseTextRu)+1;
                        }
                    ?>
                    <div data-count="<?=$count?>" class="addphotooriginal_<?=$langBlock?> addphotooriginal">Добавить ещё фотографию</div>
                </div>
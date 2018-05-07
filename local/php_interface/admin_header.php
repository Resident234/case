<?php
//если редактируем расписание рейсов
if($_SERVER['SCRIPT_NAME'] == '/bitrix/admin/iblock_element_edit.php'):

    $iblockID = intval($_GET['IBLOCK_ID']);

    if(in_array($iblockID , array(IBLOCK_SLIDER_MAIN_PIN_ID, IBLOCK_SLIDER_COLLECTION_PIN_ID, IBLOCK_NEWS_PIN_ID, IBLOCK_SHARES_PIN_ID))):

        switch($iblockID) {
            case IBLOCK_SLIDER_MAIN_PIN_ID:
                $propertyPinID = PROPERTY_SLIDER_MAIN_PIN_COORD_ID;
                break;
            case IBLOCK_SLIDER_COLLECTION_PIN_ID:
                $propertyPinID = PROPERTY_SLIDER_COLLECTION_PIN_COORD_ID;
                break;
            case IBLOCK_NEWS_PIN_ID:
                $propertyPinID = PROPERTY_NEWS_PIN_COORD_ID;
                break;
            case IBLOCK_SHARES_PIN_ID:
                $propertyPinID = PROPERTY_SHARES_PIN_COORD_ID;
                $arProp = CIBlockProperty::GetList(array(), array('IBLOCK_ID'=>$iblockID, 'CODE'=>'COORDS_RESPONSE'))->Fetch();
                $propertyPinResponseID = $arProp['ID'];
                break;
        }

        if($_GET['find_section_section']) {
            $arSection = CIBlockSection::GetList(array(), array('ID'=>intval($_GET['find_section_section']), 'IBLOCK_ID' => $iblockID), false, array('PICTURE', 'UF_PICTURE_RESPONSE'))->Fetch();
            $img = CFile::ResizeImageGet($arSection['PICTURE'], array('width'=>1240, 'height'=>1000));
            $img_response = CFile::ResizeImageGet($arSection['UF_PICTURE_RESPONSE'], array('width'=>1240, 'height'=>1000));
        }
        if($img):
            ?>
            <script src="https://code.jquery.com/jquery-3.1.0.min.js"
                    integrity="sha256-cCueBR6CsyA4/9szpPfrX3s49M9vUU5BgtiJj06wt/s=" crossorigin="anonymous"></script>
            <script>
                $(function () {

                    $('.adm-detail-content-item-block').append('<div id="slider_img_wrap"><img id="slider_img" src="<?=$img['src']?>"></div>');
                    $('body').on('dblclick', '#slider_img_wrap', function(e){

                        var img_width = $('#slider_img').width();
                        var img_height = $('#slider_img').height();

                        var offset = $(this).offset();
                        var relativeX = ((e.pageX - offset.left)-15) / (img_width / 100);
                        var relativeY = ((e.pageY - offset.top)-15) / (img_height / 100);


                        $(this).find('.ideal_project_slider__slider-plus').remove();
                        $(this).append('<div class="ideal_project_slider__slider-plus" style="top: '+relativeY+'%; left: '+relativeX+'%;"></div>');
                        $('input[name^="PROP[<?=$propertyPinID?>]"]').val(relativeX+';'+relativeY);
                    });

                    if($('input[name^="PROP[<?=$propertyPinID?>]"]').val()) {
                        var coords = $('input[name^="PROP[<?=$propertyPinID?>]"]').val().split(';');
                        $('#slider_img_wrap').append('<div class="ideal_project_slider__slider-plus" style="left: '+coords[0]+'%; top: '+coords[1]+'%;"></div>');
                    }

                    <?if($img_response):?>
                        $('.adm-detail-content-item-block').append('<h2>Адаптивная картинка</h2><div id="slider_img_response_wrap"><img id="slider_img_response" src="<?=$img_response['src']?>"></div>');
                        $('body').on('dblclick', '#slider_img_response_wrap', function(e){

                            var img_width = $('#slider_img_response').width();
                            var img_height = $('#slider_img_response').height();

                            var offset = $(this).offset();
                            var relativeX = ((e.pageX - offset.left)-15) / (img_width / 100);
                            var relativeY = ((e.pageY - offset.top)-15) / (img_height / 100);


                            $(this).find('.ideal_project_slider__slider-plus').remove();
                            $(this).append('<div class="ideal_project_slider__slider-plus" style="top: '+relativeY+'%; left: '+relativeX+'%;"></div>');
                            $('input[name^="PROP[<?=$propertyPinResponseID?>]"]').val(relativeX+';'+relativeY);
                        });

                        if($('input[name^="PROP[<?=$propertyPinResponseID?>]"]').val()) {
                            var coords = $('input[name^="PROP[<?=$propertyPinResponseID?>]"]').val().split(';');
                            $('#slider_img_response_wrap').append('<div class="ideal_project_slider__slider-plus" style="left: '+coords[0]+'%; top: '+coords[1]+'%;"></div>');
                        }
                    <?endif;?>

                });
            </script>
            <style>
                #slider_img_wrap, #slider_img_response_wrap{
                    display: inline-block;
                    position: relative;
                }
                .ideal_project_slider__slider-plus{
                    width: 30px;
                    height: 30px;
                    background: white url(/html/img/ideal_project/plus.png) no-repeat center center;
                    border-radius: 50%;
                    position: absolute;
                    z-index: 15;
                    cursor: pointer;
                }
            </style>
            <?
        endif;
    endif;
endif;
?>

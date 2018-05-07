<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
} ?>

<div class="news-detail">
    <?
    $this->AddEditAction($arResult['ID'], $arResult['EDIT_LINK'],
        CIBlock::GetArrayByID($arResult["IBLOCK_ID"], "ELEMENT_EDIT"));
    $this->AddDeleteAction($arResult['ID'], $arResult['DELETE_LINK'],
        CIBlock::GetArrayByID($arResult["IBLOCK_ID"], "ELEMENT_DELETE"),
        array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
    ?>
    <?
    $isLinkToDetail = false;
    if (!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] ||
        ($arResult["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])) {
        $isLinkToDetail = true;
    }
    ?>
    <? if ($arParams["DISPLAY_PICTURE"] != "N"): ?>
        <?
        if (!empty($arResult["PREVIEW_PICTURE"]) || !empty($arResult["DETAIL_PICTURE"])) {
            $arPicture = (is_array($arResult["PREVIEW_PICTURE"])) ? $arResult["PREVIEW_PICTURE"] : $arResult["DETAIL_PICTURE"];

            ?>
            <img
                    class="detail_picture"
                    border="0"
                    src="<?= $arPicture["SRC"] ?>"
                    width="<?= $arPicture["WIDTH"] ?>"
                    height="<?= $arPicture["HEIGHT"] ?>"
                    alt="<?= $arPicture["ALT"] ?>"
                    title="<?= $arPicture["TITLE"] ?>"
            />
        <? } ?>
    <? endif ?>
    <? if ($arParams["DISPLAY_DATE"] != "N" && $arResult["DISPLAY_ACTIVE_FROM"]): ?>
        <span class="news-date-time"><?= $arResult["DISPLAY_ACTIVE_FROM"] ?></span>
    <? endif; ?>
    <? if ($arParams["DISPLAY_NAME"] != "N" && $arResult["NAME"]): ?>
        <h3><?= $arResult["NAME"] ?></h3>
    <? endif; ?>

    <? if (strlen($arResult["DETAIL_TEXT"]) > 0): ?>
        <? echo $arResult["DETAIL_TEXT"]; ?>
    <? else: ?>
        <? echo $arResult["PREVIEW_TEXT"]; ?>
    <? endif ?>
    <div style="clear:both"></div>
    <br/>
    <?
    foreach ($arResult["DISPLAY_PROPERTIES"] as $pid => $arProperty):?>

        <?= $arProperty["NAME"] ?>:&nbsp;
        <? if (is_array($arProperty["DISPLAY_VALUE"])): ?>
            <?= implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]); ?>
        <? else: ?>
            <?= $arProperty["DISPLAY_VALUE"]; ?>
        <? endif ?>
        <br/>
    <? endforeach; ?>
</div>

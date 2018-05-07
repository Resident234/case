<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
} ?>

<? if ($arParams['DISPLAY_TOP_PAGER'] === 'Y') { ?>
    <?= $arResult['NAV_STRING'] ?>
<? } ?>

<? foreach ($arResult['ELEMENTS'] as $arItem) { ?>
    <?
    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'],
        CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'],
        CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"),
        array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
    ?>
    <div class="bx-newslist-container col-sm-12 col-md-12"
         id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
        <div class="bx-newslist-block">
            <?
            $isLinkToDetail = false;
            if (!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] ||
                ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])) {
                $isLinkToDetail = true;
            }
            ?>
            <? if ($arParams["DISPLAY_PICTURE"] != "N"): ?>
                <?
                if (!empty($arItem["PREVIEW_PICTURE"]) || !empty($arItem["DETAIL_PICTURE"])) {
                    ?>
                    <? if (is_array($arItem["PREVIEW_PICTURE"])): ?>
                        <div class="bx-newslist-img col-sm-4 col-md-4">
                            <? if ($isLinkToDetail){ ?><a href="<?= $arItem["DETAIL_PAGE_URL"] ?>"><? } ?>
                                <img
                                        src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>"
                                        width="<?= $arItem["PREVIEW_PICTURE"]["WIDTH"] ?>"
                                        height="<?= $arItem["PREVIEW_PICTURE"]["HEIGHT"] ?>"
                                        alt="<?= $arItem["PREVIEW_PICTURE"]["ALT"] ?>"
                                        title="<?= $arItem["PREVIEW_PICTURE"]["TITLE"] ?>"
                                />
                                <? if ($isLinkToDetail){ ?></a><? } ?>
                        </div>
                    <? endif; ?>
                <? } ?>
            <? endif; ?>
            <? if ($arParams["DISPLAY_NAME"] != "N" && $arItem["NAME"]): ?>
                <h3 class="bx-newslist-title">
                    <? if ($isLinkToDetail): ?>
                        <a href="<? echo $arItem["DETAIL_PAGE_URL"] ?>"><? echo $arItem["NAME"] ?></a>
                    <? else: ?>
                        <? echo $arItem["NAME"] ?>
                    <? endif; ?>
                </h3>
            <? endif; ?>

            <? if ($arParams["DISPLAY_PREVIEW_TEXT"] != "N" && $arItem["PREVIEW_TEXT"]): ?>
                <div class="bx-newslist-content">
                    <? echo $arItem["PREVIEW_TEXT"]; ?>
                </div>
            <? endif; ?>
            <?

            ?>

            <div class="bx-newslist-author">
                <i class="fa fa-user"></i>
                <?= $arItem["CREATED_USER_NAME"]; ?>
            </div>

            <? foreach ($arItem["DISPLAY_PROPERTIES"] as $pid => $arProperty): ?>
                <?
                if (is_array($arProperty["DISPLAY_VALUE"])) {
                    $value = implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);
                } else {
                    $value = $arProperty["DISPLAY_VALUE"];
                }
                ?>
                <? if ($arProperty["CODE"] == "FORUM_MESSAGE_CNT"): ?>
                    <div class="bx-newslist-comments"><i class="fa fa-comments"></i> <?= $arProperty["NAME"] ?>:
                        <?= $value; ?>
                    </div>
                <? elseif ($value != ""): ?>
                    <div class="bx-newslist-other"><i class="fa"></i> <?= $arProperty["NAME"] ?>:
                        <?= $value; ?>
                    </div>
                <? endif; ?>
            <? endforeach; ?>
            <div class="row">
                <? if ($arParams["DISPLAY_DATE"] != "N" && $arItem["DISPLAY_ACTIVE_FROM"]): ?>
                    <div class="col-xs-5">
                        <div class="bx-newslist-date"><i
                                    class="fa fa-calendar-o"></i> <? echo $arItem["DISPLAY_ACTIVE_FROM"] ?></div>
                    </div>
                <? endif ?>
            </div>
            <div class="row">
                <div class="col-xs-5">
                    <? if ($isLinkToDetail): ?>
                        <div class="bx-newslist-more">
                            <a class="btn btn-primary btn-xs"
                                                         href="<? echo $arItem["DETAIL_PAGE_URL"] ?>">
                                <? echo GetMessage("CT_BNL_GOTO_DETAIL") ?>
                            </a>
                        </div>
                    <? endif; ?>
                </div>
            </div>
        </div>
    </div>
<? } ?>

<? if ($arParams['DISPLAY_BOTTOM_PAGER'] === 'Y') { ?>
    <?= $arResult['NAV_STRING'] ?>
<? } ?>
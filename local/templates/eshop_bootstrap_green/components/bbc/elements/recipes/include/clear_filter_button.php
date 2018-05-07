<?
/**
 * Created by PhpStorm.
 * User: GSU
 * Date: 07.05.2018
 * Time: 14:23
 */
?>
<?
global $APPLICATION;
$uri = new \Bitrix\Main\Web\Uri($APPLICATION->GetCurUri());
$uri->deleteParams(array("ingredient"));
$strMainSectionLink = $uri->getUri();
?>
<div class="row">
    <div class="col-xs-5">
        <div class="bx-newslist-more">
            <a class="btn btn-primary btn-xs" href="<?=$strMainSectionLink;?>">Сбросить</a></div>
    </div>
</div>

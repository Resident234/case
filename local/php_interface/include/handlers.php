<?
$eventManager = \Bitrix\Main\EventManager::getInstance();
$eventManager->addEventHandler(
    'iblock',
    'OnBeforeIBlockElementAdd',
    array('IblockClass', "OnBeforeIBlockElementHandler")
);
$eventManager->addEventHandler(
    'iblock',
    'OnBeforeIBlockElementUpdate',
    array('IblockClass', "OnBeforeIBlockElementHandler")
);

class IblockClass
{
    function OnBeforeIBlockElementHandler(&$arFields)
    {

        \Bitrix\Main\Loader::includeModule('iblock');

        if($arFields["IBLOCK_ID"] == \Local\iBlockData::getIblockIDByCode("ingredients")){
            $arFields["NAME"] = "";
            $INGREDIENT = \Local\iBlockData::getPropertyValueFormatted(current($arFields["PROPERTY_VALUES"][\Local\iBlockData::getIBlockPropertyIDByIBlockPropertyCode("INGREDIENT", $arFields["IBLOCK_ID"])])["VALUE"], \Local\iBlockData::getIBlockPropertyTypeByIBlockPropertyCode("INGREDIENT", $arFields["IBLOCK_ID"]));
            $QUANTITY = \Local\iBlockData::getPropertyValueFormatted(current($arFields["PROPERTY_VALUES"][\Local\iBlockData::getIBlockPropertyIDByIBlockPropertyCode("QUANTITY", $arFields["IBLOCK_ID"])])["VALUE"], \Local\iBlockData::getIBlockPropertyTypeByIBlockPropertyCode("QUANTITY", $arFields["IBLOCK_ID"]));
            $UNIT = \Local\iBlockData::getPropertyValueFormatted(current($arFields["PROPERTY_VALUES"][\Local\iBlockData::getIBlockPropertyIDByIBlockPropertyCode("UNIT", $arFields["IBLOCK_ID"])])["VALUE"], \Local\iBlockData::getIBlockPropertyTypeByIBlockPropertyCode("UNIT", $arFields["IBLOCK_ID"]));
            $arFields["NAME"] .= $INGREDIENT . ", ";
            if(IntVal($QUANTITY) > 0) $arFields["NAME"] .= $QUANTITY . " ";
            $arFields["NAME"] .=  ToLower($UNIT);
        }else if($arFields["IBLOCK_ID"] == \Local\iBlockData::getIblockIDByCode("recipes")){

            $arSinglePropertyValues = array();
            foreach($arFields["PROPERTY_VALUES"][\Local\iBlockData::getIBlockPropertyIDByIBlockPropertyCode("INGREDIENTS", $arFields["IBLOCK_ID"])] as $subArr){
                $arSinglePropertyValues[] = current($subArr);
            }
            $arSinglePropertyValues = array_diff($arSinglePropertyValues, array(''));

            $arFilter = array (
                "ID" => $arSinglePropertyValues,
                "ACTIVE" => "Y",
                "ACTIVE_DATE" => "Y",
                "CHECK_PERMISSIONS" => "Y",
            );
            $rsIngredients = CIBlockElement::GetList(
                array(),
                $arFilter,
                false,
                false,
                array("ID", "IBLOCK_ID", "NAME", "PROPERTY_INGREDIENT")
            );
            $arIngredients = [];
            $arPropertyIngredientsFilter = [];
            while($arIngredient = $rsIngredients->GetNext()){
                $arIngredients[] = $arIngredient["PROPERTY_INGREDIENT_VALUE"];
                $arPropertyIngredientsFilter[] = array("VALUE" => $arIngredient["PROPERTY_INGREDIENT_VALUE"]);
            };

            $arFields["PROPERTY_VALUES"][\Local\iBlockData::getIBlockPropertyIDByIBlockPropertyCode("INGREDIENTS_FILTER", $arFields["IBLOCK_ID"])] = $arPropertyIngredientsFilter;

        }


    }


}


$eventManager->addEventHandler(
    'iblock',
    'OnAfterIBlockPropertyAdd',
    array('ManagedCacheClass', "ClearIBlockPropertyCacheByTagHandler")
);
$eventManager->addEventHandler(
    'iblock',
    'OnAfterIBlockPropertyDelete',
    array('ManagedCacheClass', "ClearIBlockPropertyCacheByTagHandler")
);
$eventManager->addEventHandler(
    'iblock',
    'OnAfterIBlockPropertyUpdate',
    array('ManagedCacheClass', "ClearIBlockPropertyCacheByTagHandler")
);

class ManagedCacheClass
{
    function ClearIBlockPropertyCacheByTagHandler($arFields)
    {
        \Bitrix\Main\Loader::includeModule('iblock');
        global $CACHE_MANAGER;
        $CACHE_MANAGER->ClearByTag("CIBlockProperty_" . $arFields["IBLOCK_ID"]);

    }
}
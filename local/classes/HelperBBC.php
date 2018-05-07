<?

namespace Local;

use Bitrix\Iblock;

/**
 * Class HelperBBC
 */
class HelperBBC
{

    /**
     * @param $element
     * @param $arParams
     * @return mixed
     */
    public static function formatter($element, $arParams)
    {
        if ($arParams["DISPLAY_PICTURE"] != "N") {
            $ipropValues = new Iblock\InheritedProperty\ElementValues($element["IBLOCK_ID"], $element["ID"]);
            $element["IPROPERTY_VALUES"] = $ipropValues->getValues();

            if (!empty($element["PREVIEW_PICTURE"]) || !empty($element["DETAIL_PICTURE"])) {

                Iblock\Component\Tools::getFieldImageData(
                    $element,
                    array('PREVIEW_PICTURE', 'DETAIL_PICTURE'),
                    Iblock\Component\Tools::IPROPERTY_ENTITY_ELEMENT,
                    'IPROPERTY_VALUES'
                );

            }
        }

        $element["DISPLAY_PROPERTIES"] = array();
        foreach ($arParams["SELECT_PROPS"] as $pid) {

            $prop = &$element["PROPS"][$pid];

            if (
                (is_array($prop["VALUE"]) && count($prop["VALUE"]) > 0)
                || (!is_array($prop["VALUE"]) && strlen($prop["VALUE"]) > 0)
            ) {

                if ($arParams["FOLDER"]) {
                    $element["FOLDER"] = $arParams["FOLDER"];
                }
                $element["DISPLAY_PROPERTIES"][$pid] = \Local\CIBlockFormatPropertiesCustom::GetDisplayValue($element, $prop,
                    "recipes_out");
            }
        }

        $dateItem = (empty($element["ACTIVE_FROM"])) ? $element["DATE_CREATE"] : $element["ACTIVE_FROM"];
        $element["DISPLAY_ACTIVE_FROM"] = \Local\CIBlockFormatPropertiesCustom::DateFormat($arParams["DATE_FORMAT"],
            MakeTimeStamp($dateItem, \CSite::GetDateFormat()));

        return $element;

    }

}
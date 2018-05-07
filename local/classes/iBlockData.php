<?

namespace Local;

/**
 * Class iBlockData
 * @package Local
 */
class iBlockData
{

    /**
     * @var array
     */
    protected static $byCode;
    protected static $elementDataByIBlockIDElementID;
    protected static $sectionsDataByIBlockID;
    protected static $arIBlockPropertyCodeIBlockPropertyIDMap;
    protected static $arIBlockPropertyCodeIBlockPropertyTypeMap;

    /**
     * @param $code string IBlock symbolic code
     * @return bool|int
     */
    public static function getIblockIDByCode($code)
    {

        if (empty(self::$byCode)) {
            self::getIBlocksData();
        }

        if (isset(self::$byCode[$code])) {
            return self::$byCode[$code];
        }

        return false;
    }

    /**
     * @param $strPropertyCode
     * @param $iblockID
     * @return mixed
     */
    public static function getIBlockPropertyIDByIBlockPropertyCode($strPropertyCode, $iblockID)
    {

        self::getIBlockPropertyCodeIBlockPropertyIDMap($iblockID);
        return self::$arIBlockPropertyCodeIBlockPropertyIDMap[$strPropertyCode];
    }

    /**
     * @param $strPropertyCode
     * @param $iblockID
     * @return mixed
     */
    public static function getIBlockPropertyTypeByIBlockPropertyCode($strPropertyCode, $iblockID)
    {
        self::getIBlockPropertyCodeIBlockPropertyTypeMap($iblockID);
        return self::$arIBlockPropertyCodeIBlockPropertyTypeMap[$strPropertyCode];
    }

    /**
     * @param $propertyValue
     * @param string $propertyType
     * @return mixed
     */
    public static function getPropertyValueFormatted($propertyValue, $propertyType = "N")
    {
        switch ($propertyType) {
            case "N":
                return $propertyValue;
            case "E":
                $resElement = \CIBlockElement::GetByID($propertyValue);
                if ($arElement = $resElement->GetNext()) {
                    return $arElement["NAME"];
                }
            default:
                return $propertyValue;
        }
    }


    /**
     * Fill self::$byCode variable by iblocks data
     */
    protected static function getIBlocksData()
    {
        if (!\Bitrix\Main\Loader::includeModule('iblock')) {
            return;
        }

        $iblocksByCode = array();

        $cache = new \CPHPCache();
        $cache_time = 86400;
        $cache_id = 'getIBlocksData' . \Local\Helper::getSiteID();
        $cache_path = '/iBlockData/getIBlocksData';

        if ($cache_time > 0 && $cache->InitCache($cache_time, $cache_id, $cache_path)) {
            $res = $cache->GetVars();
            if (is_array($res["iblocksByCode"]) && (count($res["iblocksByCode"]) > 0)) {
                $iblocksByCode = $res["iblocksByCode"];
            }
        }

        if (empty($iblocksByCode)) {

            $rsIBlocks = \CIBlock::GetList(
                Array(),
                Array(
                    "SITE_ID" => \Local\Helper::getSiteID()
                )
            );

            global $CACHE_MANAGER;
            $CACHE_MANAGER->StartTagCache($cache_path);
            while ($arIBlock = $rsIBlocks->Fetch()) {
                $CACHE_MANAGER->RegisterTag("iblock_id_" . $arIBlock["ID"]);
                $iblocksByCode[$arIBlock['CODE']] = $arIBlock['ID'];
            }
            $CACHE_MANAGER->RegisterTag("iblock_id_new");
            $CACHE_MANAGER->EndTagCache();

            if ($cache_time > 0) {
                $cache->StartDataCache($cache_time, $cache_id, $cache_path);
                $cache->EndDataCache(array("iblocksByCode" => $iblocksByCode));
            }
        }

        self::$byCode = $iblocksByCode;
    }

    /**
     * @param $iblock_id
     */
    protected static function getIBlockPropertyCodeIBlockPropertyIDMap($iblock_id)
    {
        $arrIBlockProperties = array();

        $cache = new \CPHPCache();
        $cache_time = 86400;
        $cache_id = 'getIBlockPropertyCodeIBlockPropertyIDMap' . \Local\Helper::getSiteID() . "_" . $iblock_id;
        $cache_path = '/iBlockData/getIBlockPropertyCodeIBlockPropertyIDMap';

        if ($cache_time > 0 && $cache->InitCache($cache_time, $cache_id, $cache_path)) {
            $res = $cache->GetVars();
            if (is_array($res["arrIBlockProperties"]) && (count($res["arrIBlockProperties"]) > 0)) {
                $arrIBlockProperties = $res["arrIBlockProperties"];
            }
        }

        if (empty($arrIBlockProperties)) {
            $resIBlockProperties = \CIBlock::GetProperties($iblock_id);
            while ($arrIBlockProperty = $resIBlockProperties->Fetch()) {
                $arrIBlockProperties[$arrIBlockProperty["CODE"]] = $arrIBlockProperty["ID"];
            }
            global $CACHE_MANAGER;
            $CACHE_MANAGER->StartTagCache($cache_path);
            $CACHE_MANAGER->RegisterTag("CIBlockProperty_" . $iblock_id);
            $CACHE_MANAGER->EndTagCache();

            if ($cache_time > 0) {
                $cache->StartDataCache($cache_time, $cache_id, $cache_path);
                $cache->EndDataCache(array("arrIBlockProperties" => $arrIBlockProperties));
            }
        }

        self::$arIBlockPropertyCodeIBlockPropertyIDMap = $arrIBlockProperties;
    }

    /**
     * @param $iblock_id
     */
    protected static function getIBlockPropertyCodeIBlockPropertyTypeMap($iblock_id)
    {

        $arrIBlockProperties = array();

        $cache = new \CPHPCache();
        $cache_time = 86400;
        $cache_id = 'getIBlockPropertyCodeIBlockPropertyTypeMap' . \Local\Helper::getSiteID() . "_" . $iblock_id;
        $cache_path = '/iBlockData/getIBlockPropertyCodeIBlockPropertyTypeMap';

        if ($cache_time > 0 && $cache->InitCache($cache_time, $cache_id, $cache_path)) {
            $res = $cache->GetVars();
            if (is_array($res["arrIBlockProperties"]) && (count($res["arrIBlockProperties"]) > 0)) {
                $arrIBlockProperties = $res["arrIBlockProperties"];
            }
        }

        if (empty($arrIBlockProperties)) {
            $resIBlockProperties = \CIBlock::GetProperties($iblock_id);
            while ($arrIBlockProperty = $resIBlockProperties->Fetch()) {
                $arrIBlockProperties[$arrIBlockProperty["CODE"]] = $arrIBlockProperty["PROPERTY_TYPE"];
            }
            global $CACHE_MANAGER;
            $CACHE_MANAGER->StartTagCache($cache_path);
            $CACHE_MANAGER->RegisterTag("CIBlockProperty_" . $iblock_id);
            $CACHE_MANAGER->EndTagCache();

            if ($cache_time > 0) {
                $cache->StartDataCache($cache_time, $cache_id, $cache_path);
                $cache->EndDataCache(array("arrIBlockProperties" => $arrIBlockProperties));
            }
        }

        self::$arIBlockPropertyCodeIBlockPropertyTypeMap = $arrIBlockProperties;
    }

}
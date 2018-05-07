<?php
/**
 * Created by PhpStorm.
 * User: GSU
 * Date: 02.05.2018
 * Time: 17:35
 */

namespace Local;

use \Bitrix\Main\Context;

/**
 * Class Helper
 * @package Local
 */
class Helper
{
    /**
     * @return bool|mixed|string
     */
    public static function getSiteID(){
        if(Context::getCurrent()->getRequest()->isAdminSection()){
            return "s1";
        }else{
            return SITE_ID;
        }
    }

}
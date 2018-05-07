<?php

// composer autoload и dotenv подключаются в файлах конфигурации ядра
// bitrix/.settings.php и bitrix/php_interface/dbconn.php
// которые в свою очередь можно обновить, отредактировав данные в директории /environments/
// и "перезагрузить" командой `./vendor/bin/jedi env:init default`



// так как  автолоад (в нашем случае) регистрируется до ядра,
// Твиг не успевает зарегистрироваться
// необходимо это действие повтроить еще раз:

maximasterRegisterTwigTemplateEngine();

Arrilot\BitrixModels\ServiceProvider::register();
Arrilot\BitrixModels\ServiceProvider::registerEloquent();

Bex\Monolog\MonologAdapter::loadConfiguration();

include_once 'events.php';
/*
function customAutoload($className) {
    if (!CModule::RequireAutoloadClass($className)) {

        $path = $_SERVER["DOCUMENT_ROOT"]."/local/php_interface/classes/" .
            str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';

        if (file_exists($path)) {
            require_once $path;
            return true;
        }
        return false;
    }
    return true;
}

spl_autoload_register('customAutoload', false);
*/
include_once 'include/handlers.php';

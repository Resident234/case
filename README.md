# Краткие пояснения

Раздел с рецептами располагается здесь: /recipes/

Пример URL в применённым фильтром по ингредиенту: /recipes/?ingredient=877

Пример детальной страницы рецепта: /recipes/kurinye-ruletiki-s-syrom/


Используется bbc:

1) Комплексный компонент

local/templates/eshop_bootstrap_green/components/bbc/elements/recipes/index.php

local/templates/eshop_bootstrap_green/components/bbc/elements/recipes/detail.php

2) bbc.custom:recipes.list отнаследованный от bbc:elements.list

3) bbc.custom:recipes.detail отнаследованный от bbc:elements.detail

В отнаследованных классах RecipesDetail и RecipesList в prepareElementsResult задействован специально написанный вспомогательный класс \Local\HelperBBC::formatter , который приводит некоторую информацию из arResult к более читаемому виду.


Созданные классы:
local/classes/CIBlockFormatPropertiesCustom.php
local/classes/Helper.php
local/classes/HelperBBC.php
local/classes/iBlockData.php


Обработчики событий расположены здесь:
local/php_interface/include/handlers.php


Front-End использовался из штатного шаблона интернет-магазина

Дополнительные стили лежат в local/assets/styles , для сборки используется webpack-encore

Проект работает на основе решения https://github.com/regiomedia/bitrix-project

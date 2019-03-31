# Описание кейса

На типовой установке Битрикс (решение “Интернет-магазин” или “Корпоративный сайт”) с использованием типовых компонентов news, news.list и news.detail нужно запилить на сайте раздел "Рецепты". 

На карточке рецепта, кроме всего, должен быть список необходимых ингредиентов с указанием количества (типа "Мука: 1 стакан, Соль: 1 ч. л."). 

Название ингредиента должно быть ссылкой, ведущей на страницу со списком всех рецептов, в которых используется этот ингредиент. Дизайн раздела на ваше усмотрение.


# Краткие пояснения к результатам

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

# Case Description

On a typical Bitrix installation (solution “Online store” or “Corporate site”) using standard components news, news.list and news.detail, you need to add a section “Recipes” on the site.

On the recipe card, besides everything, there should be a list of necessary ingredients with an indication of the amount (such as "Flour: 1 cup, Salt: 1 tsp.").

The name of the ingredient should be a link to a page with a list of all recipes that use this ingredient. Design section at your discretion.


# Brief explanation of the results

The section with recipes is located here: /recipes/

Example URL in the applied filter by ingredient: /recipes/?ingredient=877

Sample recipe detail page: /recipes/kurinye-ruletiki-s-syrom/


Bbc used:

1) Complex component

local/templates/eshop_bootstrap_green/components/bbc/elements/recipes/index.php

local/templates/eshop_bootstrap_green/components/bbc/elements/recipes/detail.php

2) bbc.custom:recipes.list inherited from bbc:elements.list

3) bbc.custom:recipes.detail inherited from bbc:elements.detail

In the inherited RecipesDetail and RecipesList classes, a specially written auxiliary class \Local\HelperBBC::formatter is involved in the prepareElementsResult, which brings some information from arResult to a more readable form.

Classes created:
local/classes/CIBlockFormatPropertiesCustom.php
local/classes/Helper.php
local/classes/HelperBBC.php
local/classes/iBlockData.php


Event handlers are located here:
local/php_interface/include/handlers.php


Front-End used from regular online store template

Additional styles lie in local/assets/styles , used for assembly webpack-encore


The project works on the basis of the solution https://github.com/regiomedia/bitrix-project

<?

namespace Recipes\Components;

use Bex\Bbc\Components\ElementsList;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

\CBitrixComponent::includeComponentClass('bbc:elements.list');

class RecipesList extends ElementsList
{
    public function prepareElementsResult($element)
    {
        return \Local\HelperBBC::formatter($element, $this->arParams);
    }
}
<?

namespace Recipes\Components;

use Bex\Bbc\Components\ElementsDetail;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

\CBitrixComponent::includeComponentClass('bbc:elements.detail');

class RecipesDetail extends ElementsDetail
{
    public function prepareElementsResult($element)
    {
        return \Local\HelperBBC::formatter($element, $this->arParams);
    }
}
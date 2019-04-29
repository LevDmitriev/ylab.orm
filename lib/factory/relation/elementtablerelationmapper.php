<?php
namespace Ylab\ORM\Factory\Relation;

use Bitrix\Main\ORM\Fields\Relations\OneToMany;
use Ylab\ORM\Iblock\YlabElementPropertyTable;

/**
 * Класс для формирования отношений таблицы b_iblock_element
 *
 * @package Ylab\ORM\Factory\Relation
 */
class ElementTableRelationMapper extends RelationMapper
{
    /**
     * @inheritdoc
     */
    public function getRelations()
    {
        $arResult = [];
        $arResult['PROPERTIES'] = new OneToMany('PROPERTIES', YlabElementPropertyTable::class, 'ELEMENT');
    
        return $arResult;
    }
}
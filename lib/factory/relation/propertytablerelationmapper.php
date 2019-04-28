<?php
namespace Ylab\ORM\Factory\Relation;

use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;
use Ylab\ORM\Iblock\YlabIblockTable;

/**
 * Класс для формирования отношений таблицы b_iblock_property
 *
 * @package Ylab\ORM\Factory\Relation
 */
class PropertyTableRelationMapper extends RelationMapper
{
    function getRelations()
    {
        $arResult = [];
        $arMap['IBLOCK'] = (new Reference('IBLOCK', YlabIblockTable::class,
            Join::on('this.IBLOCK_ID', 'ref.ID')))->configureJoinType('inner');
        
        return $arResult;
    }
    
}
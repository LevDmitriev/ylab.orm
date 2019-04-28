<?php
namespace Ylab\ORM\Iblock;

use Bitrix\Iblock\SectionTable;
use Ylab\ORM\Factory\Relation\RelationMapperStaticFactory;

/**
 * Class YlabSectionTable. Класс для работы с таблицей b_iblock_section
 *
 * @package Ylab\ORM\Iblock
 */
abstract class YlabSectionTable extends SectionTable
{
    /**
     * @inheritdoc
     */
    public static function getMap()
    {
        $arMap = array_merge(RelationMapperStaticFactory::create(static::getTableName())->getRelations(), parent::getMap());
        
        return $arMap;
    }
}
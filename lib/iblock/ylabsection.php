<?php

namespace Ylab\ORM\Iblock;

use Bitrix\Iblock\PropertyEnumerationTable;
use Bitrix\Iblock\SectionTable;
use Ylab\ORM\Factory\Relation\RelationMapperStaticFactory;

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
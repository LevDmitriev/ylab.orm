<?php

namespace Ylab\ORM\Iblock;

use Bitrix\Iblock\PropertyEnumerationTable;
use Ylab\ORM\Factory\Relation\RelationMapperStaticFactory;

abstract class YlabPropertyEnumTable extends PropertyEnumerationTable
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
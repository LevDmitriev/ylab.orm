<?php

namespace Ylab\ORM\Iblock;

use Bitrix\Iblock\PropertyTable;
use Ylab\ORM\Factory\Relation\RelationMapperStaticFactory;

abstract class YlabPropertyTable extends PropertyTable
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
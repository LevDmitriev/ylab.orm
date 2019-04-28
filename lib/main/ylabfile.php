<?php

namespace Ylab\ORM\Main;

use Bitrix\Main\FileTable;
use Ylab\ORM\Factory\Relation\RelationMapperStaticFactory;

class YlabFileTable extends FileTable
{
    public static function getMap()
    {
        $arResult = [];
    
        $arResult = array_merge(RelationMapperStaticFactory::create(static::getTableName())->getRelations(), $arResult, parent::getMap());
        
        return $arResult;
    }
}
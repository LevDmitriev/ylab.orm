<?php
namespace Ylab\ORM\Iblock;

\Bitrix\Main\Loader::includeModule('iblock');

use Ylab\ORM\Factory\Relation\RelationMapperStaticFactory;
use \Bitrix\Iblock\IblockTable;

class YlabIblockTable extends IblockTable
{
    /**
     * @inheritdoc
     */
    public static function getMap() {
        $arMap = array_merge(RelationMapperStaticFactory::create(static::getTableName())->getRelations(), parent::getMap());
        
        return $arMap;
    }
}
<?php
namespace Ylab\ORM\Iblock;

use Ylab\ORM\Factory\Relation\RelationMapperStaticFactory;
use \Bitrix\Iblock\IblockTable;

/**
 * Class YlabIblockTable. Класс для работы с таблицей b_iblock
 *
 * @package Ylab\ORM\Iblock
 */
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
<?php
namespace Ylab\ORM\Factory\Relation;

use Bitrix\Iblock\ElementTable;
use Bitrix\Iblock\IblockTable;
use Bitrix\Iblock\PropertyEnumerationTable;
use Bitrix\Iblock\PropertyTable;
use Bitrix\Iblock\SectionTable;
use Bitrix\Main\FileTable;
use Ylab\ORM\Iblock\YlabElementPropertyTable;

/**
 * Class RelationMapperStaticFactory
 * Статическая фабрика по созданию объектов {@link RelationMapper}
 *
 * @package Ylab\ORM\Factory\Relation
 */
class RelationMapperStaticFactory
{
    /**
     * Приватный конструктор, т.к. статическая фабрика не имеет экземпляров.
     */
    private function __construct() { }
    
    /**
     * Получить массив, описывающий какой класс отвечает за описание отношений какой таблицы
     * @return array
     */
    private static function getFactoryMap()
    {
        return [
            // main
            FileTable::getTableName() => FileTableRelationMapper::class,
            // iblock
            IblockTable::getTableName() => IblockTableRelationMapper::class,
            SectionTable::getTableName() => IblockTableRelationMapper::class,
            PropertyTable::getTableName() => PropertyTableRelationMapper::class,
            PropertyEnumerationTable::getTableName() => PropertyEnumerationTableRelationMapper::class,
            ElementTable::getTableName() => ElementTableRelationMapper::class,
            YlabElementPropertyTable::getTableName() => ElementPropertyTableRelationMapper::class,
        ];
    }
    
    /**
     * Возвращает объект {@link RelationMapper} отвечающий за создание отношений переданной таблицы
     *
     * @param string $tableName Имя таблицы
     *
     * @return RelationMapper Объект {@link RelationMapper}
     */
    public static function create($tableName)
    {
        $class = static::getFactoryMap()[$tableName];
        
        return new $class;
    }
}
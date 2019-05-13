<?php

namespace Ylab\ORM\Main;

use Bitrix\Main\FileTable;
use Ylab\ORM\Factory\Relation\RelationMapperStaticFactory;

/**
 * Class YlabFileTable. Класс для работы с таблицей b_file
 *
 * @package Ylab\ORM\Main
 */
class YlabFileTable extends FileTable
{
    /**
     * @inheritdoc
     */
    public static function getMap()
    {
        return array_merge(RelationMapperStaticFactory::create(static::getTableName())->getRelations(), [], parent::getMap());
    }
}
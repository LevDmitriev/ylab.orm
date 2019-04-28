<?php
namespace Ylab\ORM\Factory\Relation;

use Bitrix\Main\ORM\Fields\Relations\Relation;

/**
 * Class RelationMapper.
 *
 * @package Ylab\ORM\Factory\Relation
 */
abstract class RelationMapper
{
    /**
     * Получить массив отношений
     *
     * @return Relation[]
     */
    abstract public function getRelations();
}
<?php

namespace Ylab\ORM\Factory\Relation;

use Bitrix\Main\ORM\Fields\Relations\Relation;

abstract class RelationMapper
{
    /**
     * Получить массив отношений
     *
     * @return Relation[]
     */
    abstract function getRelations();
}
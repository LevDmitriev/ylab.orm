<?php

namespace Ylab\ORM\Factory\Relation;

use Bitrix\Iblock\EO_Property_Collection;
use Bitrix\Iblock\PropertyTable;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;
use Bitrix\Main\ORM\Query\Query;
use Ylab\ORM\Iblock\YlabElementPropertyTable;
use Ylab\ORM\Iblock\YlabElementTable;

/**
 * Класс для формирования отношений таблицы b_file
 *
 * @package Ylab\ORM\Factory\Relation
 */
class FileTableRelationMapper extends RelationMapper
{
    /**
     * @inheritdoc
     */
    public function getRelations()
    {
        $arResult = [];
        /** @var EO_Property_Collection $oIblockPropCollection Свойства инфоблоков с привязкой к файлам */
        $oIblockPropCollection = PropertyTable::getList(['filter' => ['=PROPERTY_TYPE' => 'F']])->fetchCollection();
        // Привязка к свойству элемента инфоблока
        $arResult['IBLOCK_ELEMENT_PROPERTY'] = (new Reference('IBLOCK_ELEMENT_PROPERTY',
            YlabElementPropertyTable::class, Join::on('this.ID', 'ref.VALUE')->where(Query::filter()->logic('or')
                    ->where('ref.IBLOCK_PROPERTY_ID',
                        array_map(function ($id) { return ['ref.IBLOCK_PROPERTY_ID', $id]; },
                            $oIblockPropCollection->getIdList())))))->configureJoinType('inner');
        // Привязка к элементу инфоблока
        $arResult['IBLOCK_ELEMENT'] = (new Reference('IBLOCK_ELEMENT', YlabElementTable::class,
            Join::on('this.IBLOCK_ELEMENT_PROPERTY.IBLOCK_ELEMENT_ID', 'ref.ID')));
        
        return $arResult;
    }
    
}
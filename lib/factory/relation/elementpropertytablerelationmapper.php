<?php
namespace Ylab\ORM\Factory\Relation;

use Bitrix\Iblock\EO_Property_Collection;
use Bitrix\Iblock\PropertyTable;
use Bitrix\Main\ORM\Fields\Relations\OneToMany;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;
use Ylab\ORM\Iblock\YlabElementTable;
use Ylab\ORM\Iblock\YlabPropertyEnumTable;
use Ylab\ORM\Iblock\YlabSectionTable;
use Ylab\ORM\Main\YlabFileTable;

/**
 * Класс для формирования отношений таблицы b_iblock_element_property
 *
 * @package Ylab\ORM\Factory\Relation
 */
class ElementPropertyTableRelationMapper extends RelationMapper
{
    /**
     * @inheritdoc
     */
    public function getRelations()
    {
        $arResult = [];
        // Элемент, к которому относится свойство
        $arResult['ELEMENT'] = (new Reference('ELEMENT', YlabElementTable::class,
        Join::on('this.IBLOCK_ELEMENT_ID', 'ref.ID')))->configureJoinType('inner');
        /** @var EO_Property_Collection $oIblockPropCollection Коллекция свойство инфоблоков */
        $oIblockPropCollection = PropertyTable::getList()->fetchCollection();
        
        /*
         * Чтобы иметь возможность делать отношения OneToMany, нужно как-то привязаться к ID инфоблока.
         * Перебираем все свойства инфоблока и создаём соответствующие поля для привязки, у которых на конце будет
         * ID инфоблока
         */
        foreach ($oIblockPropCollection as $oIblockProp) {
            $arResult[] = (new Reference('PRIVATE_ELEMENT_BY_PROPERTY_' . $oIblockProp->getCode(),
                YlabElementTable::class,
                Join::on('this.IBLOCK_ELEMENT_ID', 'ref.ID')
                    ->where('this.IBLOCK_PROPERTY_ID', $oIblockProp->getId())
            ))->configureJoinType('inner');
        }
        
        // Привязка к элементу
        /** @var EO_Property_Collection $oIblockBindElementCollection Коллекция со свойствами, привязки к элементам */
        $oIblockBindElementCollection = PropertyTable::getList(['filter' => ['=PROPERTY_TYPE' => 'E']])->fetchCollection();
        $arResult['BIND_ELEMENT'] = new Reference('BIND_ELEMENT',
            YlabElementTable::class,
            Join::on('this.VALUE', 'ref.ID')->where('ref.IBLOCK_ID',
                array_map(function ($id) { return ['this.IBLOCK_ID', $id]; },$oIblockBindElementCollection->getIblockIdList())
                ));
        
        // Привязка к разделу
        /** @var EO_Property_Collection $oIblockBindSectionCollection Коллекция со свойствами, привязки к разделам инфоблока */
        $oIblockBindSectionCollection = PropertyTable::getList(['filter' => ['=PROPERTY_TYPE' => 'G']])->fetchCollection();
        $arResult['BIND_SECTION'] = new Reference('BIND_SECTION',
            YlabSectionTable::class,
            Join::on('this.VALUE', 'ref.ID')->where(
                array_map(function ($id) { return ['ref.IBLOCK_ID', $id]; },$oIblockBindSectionCollection->getLinkIblockIdList())
            ));
        
        // Привязка к таблице b_iblock_property_enum
        $arResult['ENUM'] = (new Reference('ENUM', YlabPropertyEnumTable::class,
            Join::on('this.VALUE_ENUM', 'ref.ID')->whereNotNull('this.VALUE_ENUM')
        ))->configureJoinType('inner');

        // Файл, привязанный к свойству элемента инфоблока
        $arResult['FILE'] = (new Reference('FILE', YlabFileTable::class,
            Join::on('this.VALUE', 'ref.ID')
            ->where('this.IBLOCK_PROPERTY_ID',
                array_map(function ($id) { return ['ref.IBLOCK_PROPERTY_ID', $id]; }, PropertyTable::getList(['filter' => ['=PROPERTY_TYPE' => 'F']])->fetchCollection()->getIdList())
            )
        ));
        
        return $arResult;
    }
}
